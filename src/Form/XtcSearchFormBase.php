<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 31/10/2018
 * Time: 16:33
 */

namespace Drupal\xtc\Form;


use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\AppendCommand;
use Drupal\Core\Ajax\RemoveCommand;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\csoec_common\EsService;
use Drupal\xtc\PluginManager\XtcSearchFilter\XtcSearchFilterInterface;
use Elastica\Document;

abstract class XtcSearchFormBase extends FormBase implements XtcSearchFormInterface
{

  /**
   * @var array
   */
  protected $form;

  /**
   * @var array
   */
  protected $definition;

  /**
   * @var array
   */
  protected $musts;

  protected $results;

  protected $search;

  protected $searched = false;

  /**
   * @var array
   *
   * An associative array of additional URL options, with the
   * following elements:
   * - 'from'
   * - 'size'
   * - 'total'
   * - 'page'
   */
  protected $pagination = [
    'from' => 0,
    'size' => 5,
    'total' => 0,
    'page' => 1,
  ];

  /**
   * @var array
   */
  protected $filters = [];

  /**
   * @var
   */
  public $elastica;

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return $this->getSearchId() .'_form';
  }

  abstract protected function getSearchId();

  protected function init(){
    $this->definition = \Drupal::service('plugin.manager.xtc_search')
      ->getDefinition($this->getSearchId());

    foreach ($this->definition['pagination'] as $name => $value){
      $this->pagination[$name] = $value;
    }
    $this->filters = $this->definition['filters'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $this->form = $form;

    $this->init();
    $form_state->cleanValues();
    $form_state->setCached(FALSE);
    $form_state->setRebuild(TRUE);
    $this->searched = false;

    $this->getContainers();

    $this->getCriteria();
    $this->getSearch();

    $this->getFilters();
    $this->getFilterButton();

    $this->getItems();
    $this->getPagination();
    $this->attachLibraries();

    return $this->form;
  }

  public function getElastica(){
    // TODO from plugin.manager.xtc_search
    if ($this->elastica === NULL) {
//      $this->elastica = \Drupal::service('csoec_common.es');
//      $this->elastica->getConnection();
      return null;
    }
    return $this->elastica;
  }

  /**
   * @return \Elastica\ResultSet
   */
  public function getSearch() {
    $request = \Drupal::request();
    if (empty($this->search)
      || !$this->searched
    ){
      $this->pagination['page'] = $request->get('page_number') ?? 1;
      $this->pagination['from'] = $this->pagination['size'] * ($this->pagination['page'] - 1);

      $must = [];
      foreach ($this->musts as $request) {
        if(!empty($request)){
          $must['query']['bool']['must'][] = $request;
        }
      }

      $this->getElastica()
        ->setRawQuery($must)
        ->setIndex($this->definition['index'])
        ->setType($this->definition['type'])
        ->setFrom($this->pagination['from'])
        ->setSize($this->pagination['size'])
        ->setSort(
          $this->definition['sort']['field'],
          $this->definition['sort']['dir']
        )
      ;
      $this->addAggregations();
      $this->search = $this->getElastica()->search();

      $this->pagination['total'] = $this->search->getTotalHits();
      $this->results = $this->search->getDocuments();
      $this->searched = true;
    }

    return $this->search;
  }

  protected function addAggregations(){
    foreach ($this->filters as $key => $name){
      $type = \Drupal::service('plugin.manager.xtc_search_filter');
      $filter = $type->createInstance($name);
      if($filter instanceof XtcSearchFilterInterface){
        $filter->setForm($this);
        $filter->addAggregation();
      }
    }
  }

  protected function getFilters(){
    foreach ($this->filters as $key => $name){
      $type = \Drupal::service('plugin.manager.xtc_search_filter');
      $filter = $type->createInstance($name);
      if($filter instanceof XtcSearchFilterInterface){
        $filter->setForm($this);
        $this->form['container']['container_filters'][$filter->getPluginId()] = $filter->getFilter();
        $this->form['container']['container_filters'][$filter->getPluginId()]['#weight'] = $key;
      }
    }
  }

  protected function getCriteria(){
    foreach ($this->filters as $key => $name){
      $type = \Drupal::service('plugin.manager.xtc_search_filter');
      $filter = $type->createInstance($name);
      if($filter instanceof XtcSearchFilterInterface){
        $filter->setForm($this);
        $this->musts[$filter->getPluginId()] = $filter->getRequest();
      }
    }
  }

  protected function getFilterButton(){
    $this->form['container']['container_filters']['filtrer'] = [
      '#type' => 'submit', //onclick on this one: page reset to 0
      '#value' => $this->t('Filtrer'),
      '#attributes' => [
        'class' =>
          [
            'btn',
            'btn-dark',
            'filter-submit',
          ],
        'onclick' => 'this.form["page_number"].value = 1;',
      ],
      '#prefix' => '<div class="col-12 mt-3"> <div class="form-group text-right">',
      '#suffix' => '</div> </div>',
      '#weight' => '3',
    ];
  }

  protected function getContainers(){
    $this->form['container'] = [
      '#prefix' => ' <div class="row m-0" id="container-news-filter"> ',
      '#suffix' => '</div>',
    ];

    $this->containerElements();
    $this->containerFilters();
  }

  protected function containerFilters(){
    $this->form['container']['container_filters'] = [
      '#prefix' => '<div id="filter-div" class="order-1 order-md-2 mb-4 mb-md-0 col-12 col-md-4">
          <div class="row mr-md-0 h-100">
            <div class="col-12 filter-div pt-3">',
      '#suffix' => '</div> </div> </div>',
      '#weight' => 1,
    ];
    $this->form['container']['container_filters']['hide'] = [
      '#type' => 'button',
      '#value' => $this->t('Cacher les filtres'),
      '#weight' => '-1',
      '#attributes' => [
        'class' =>
          [
            'filter-button',
            'filter-button-active',
          ],
        'id' => 'filter-button-sm',
      ],
      '#prefix' => '<div class="col-12 mt-3 mb-3 d-block d-md-none"> <div class="text-center text-sm-right d-block">',
      '#suffix' => '</div> </div>',
    ];
    $this->form['container']['container_filters']['reset'] = [
      '#type' => 'button',
      '#value' => $this->t('Réinitialiser'),
      '#weight' => '0',
      '#attributes' => [
        'class' =>
          [
            'button-reset',
            'd-inline-block p-1',
          ],
        'onclick' => 'window.location = "' . $this->resetLink() . '"; return false;',
      ],
      '#prefix' => '<div class="col-12 text-right">',
      '#suffix' => '</div>',
    ];
  }

  protected function getPagination(){
    /**
     * Es query from /
     */
    $this->form['container']['page_number'] = [
      '#type' => 'hidden',
      '#value' => $this->pagination['page'],
    ];
    $numberOfPages = ceil($this->pagination['total'] / $this->pagination['size']);
    $numberOfPages = $numberOfPages > 1 ? $numberOfPages : 1;

    $this->form['submit'] = [
      '#type' => 'submit', //onclick on this one page ++
      '#value' => $this->t('En voir plus'),
      '#attributes' => [
        'class' =>
          [
            'see-more-news',
            'btn btn-secondary',
          ],
        'onclick' => 'this.form["page_number"].value = parseInt(this.form["page_number"].value) + 1;',
      ],
      '#ajax' => [
        'callback' => [$this, 'pagerCallback'],
        'event' => 'click',
        'progress' => [
          'type' => 'throbber',
          'message' => t('Chargement des résultats ') . '...',
        ],
      ],
      '#states' => [
        'visible' => [
          'input[name="page_number"]' => ['!value' => $numberOfPages],
        ],
      ],
      '#prefix' => '<div id="pagination" class="row mb-50 mx-0"> <div class="col-12 text-center">',
      '#suffix' => '</div> </div>',
      '#weight' => count($this->results) + 100, //Granted to be the last element
    ];
  }

  protected function getItems(){
    if(empty($this->results)){
      $this->emptyResultMessage();
    }
    else{
      $this->getResults();
    }
  }

  protected function buildEmptyResultMessage($msg_none, $msg_reset){
    $this->form['container']['elements']['no_results'] = [
      '#type' => 'container',
      '#prefix' => '<div class="row mx-0 mb-30"><div class="col-12 px-0 px-md-15 no-result">',
      '#suffix' => '</div></div>',
      '#weight' => '0',
    ];
    $this->form['container']['elements']['no_results']['message'] = [
      '#type' => 'item',
      '#markup' => $msg_none,
    ];
    $this->form['container']['elements']['no_results']['reset']['button'] = [
      '#type' => 'button',
      '#value' => $this->t('Réinitialiser ma recherche'),
      '#weight' => '0',
      '#attributes' => [
        'class' => ['btn', 'btn-light', 'd-block', 'd-lg-inline-block', 'mt-4', 'mt-lg-0', 'ml-lg-5', 'm-0'],
        'onclick' => 'window.location = "' . $this->resetLink() . '"; return false;',
      ],
      '#prefix' => '<div class="reset">
          <div class="chevron"></div>
          <div class="reset-txt"><p>' . $msg_reset . '</p></div>',
      '#suffix' => '</div>',
    ];
  }

  protected function emptyResultMessage(){
    $msg_none = '<p><span>Aucun contenu</span> trouvé</p>';
    $msg_reset = '<span>Réinitialiser ma recherche </span> et voir tous les contenus';
    $this->buildEmptyResultMessage($msg_none, $msg_reset);
  }

  protected function getResults(){
    $this->preprocessResults();
    foreach ($this->results as $key => $result) {
      if($result instanceof Document){
        $element = [
          '#theme' => 'teaser_event',
          '#event' => $result,
        ];
        $this->form['container']['elements']['item_' . $key] = [
          '#type' => 'item',
          '#markup' => render($element),
        ];
      }
    }
  }

  abstract protected function preprocessResults();

  protected function attachLibraries(){
    $this->form['#attached']['library'][] = 'csoec_actualite/refresh_actualite';
  }

  protected function containerElements(){
    $this->form['container']['elements'] = [
      '#prefix' => '<div id="news-list-div" class="col-12 p-0 order-2 order-md-1">
          <div class="gallery-wrapper clearfix"> <div class="col-sm-12 col-md-6 col-lg-4 grid-sizer px-0 px-md-3"></div>',
      '#suffix' => '</div> </div>',
      '#weight' => 0,
    ];
  }

  /**
   * @return \Drupal\Core\GeneratedUrl|string
   */
  abstract protected function resetLink();


  /**
   * Ajax callback to change page
   */
  public function pagerCallback(array $form, FormStateInterface $form_state) {
    $form_state->setCached(FALSE);
    $form_state->disableCache();
    $this->pagination['total'] = $this->getSearch()->getTotalHits();
    $this->results = $this->getSearch()->getDocuments();
    $form['container']['elements'] = [
      '#prefix' => '<div id="news-list-div" class="col-12 p-0 order-2 order-md-1">
          <div class="gallery-wrapper clearfix"> <div class="col-sm-12 col-md-6 col-lg-4 grid-sizer px-0 px-md-3"></div>',
      '#suffix' => '</div> </div>',
      '#weight' => 0,
    ];
    for ($i = 0; $i < count($this->results); $i++) {
      $element = [
        '#theme' => 'teaser_event',
        '#event' => $this->results[$i],
      ];
      $form['container']['elements']['item_' . $i] = [
        '#type' => 'item',
        '#markup' => render($element),
        '#weight' => $this->pagination['total'] + $i, //$from ++
      ];
    }
    $response = new AjaxResponse();
    $response->addCommand(new AppendCommand('#news-list-div', $form['container']['elements']));

    if ($form_state->getUserInput()['page_number'] == (ceil($this->pagination['total'] / $this->pagination['size']))) {
      $response->addCommand(new RemoveCommand('#pagination'));
    }
    return $response;
  }

  /**
   * {@inheritdoc}
   */
  public function validateForm(array &$form, FormStateInterface $form_state) {
    //$form_state->setLimitValidationErrors([]);
  }

}