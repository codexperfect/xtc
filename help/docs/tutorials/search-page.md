# Creating a search page

> Presently, only Elastica search is available.

## Start by providing a route

Define a **route** as usual in a `*.routing.yaml` file: 

```yaml
xtcsearch.search:
  path: '/xtcsearch/search'
  defaults:
    _controller: '\Drupal\xtcsearch\Controller\XtcSearchController::search'
    _title: 'XTC Search'
  requirements:
    _permission: 'access content'
```

This route will trigger a standard controller.

## Controller

The controller can be defined from scratch: 

```php
namespace Drupal\xtcsearch\Controller;


use Drupal\Core\Controller\ControllerBase;
use Drupal\xtc\XtendedContent\API\Config;
use Symfony\Component\HttpFoundation\JsonResponse;

class XtcSearchController extends ControllerBase
{
  /**
   * @var array
   */
  protected $form;

  /**
   * @return array
   */
  public function search() {
    $this->form = Config::getSearch('xtc_search');
    return [
      '#theme' => 'xtc_search_form',
      '#response' => [
        'headline' => $this->getTitle(),
      ],
      '#form' => $this->form,
    ];
  }

  public function getTitle() {
    $route = \Drupal::routeMatch();
    return $route->getRouteObject()->getDefaults()['_title'];
  }
}
```

Or by extending ` \Drupal\xtcsearch\Controller\XtcSearchController`:

```php
namespace Drupal\xtc_search\Controller;


class SearchController extends XtcSearchController
{
}
```

Usually, you will want to override the `search()` function.

## Loading a Search form

To load a Search form, simply provide the profile name, the helper static function `Config::getSearch()` from `\Drupal\xtc\XtendedContent\API\Config`.

```php
$form = Config::getSearch('xtc_search');
```

## Plugin example

A Search profile definition looks like this:

```yaml
xtc_search:
  label: 'XTC Search'
  description: 'XTC Search'
  server: 'xtc_elastica'
  routeName: 'xtcsearch.search'
  resetRoute: 'xtcsearch.search'
  display: 'xtc_search_page'
  items:
    theme: 'xtc_search_result_element'
    region: 'content'
  index:
    - 'contenu'
    - 'document'
    - 'publication'
  type: '_doc'
  filters:
    excludeUnsearchable: 'hidden'
    fulltext: 'header'
    published: 'sidebar'
    learningResource: 'sidebar'
    editor: 'sidebar'
  pager:
    name: 'page'
    size: 20
    masonry: false
```

Another example, for Agenda in a fictional `xtc_agenda` module:

```yaml
agenda:
  label: 'Agenda'
  description: 'Agenda search per month.'
  form: 'Drupal\xtc_agenda\Form\AgendaForm'
  routeName: 'xtc_agenda.agenda_month'
  resetRoute: 'xtc_agenda.agenda'
  server: 'xtc_elastica'
  display: 'xtc_search_page'
  items:
    theme: 'teaser_event'
    region: 'content'
  index:
    - 'event'
  type: '_doc'
  filters:
    excludeUnsearchable: 'hidden'
    thisMonth: 'sidebar'
    editor: 'sidebar'
  pager:
    name: 'more'
    size: 50
    masonry: true
  nav:
    top_navigation: true
    bottom_navigation: true
  sort:
    field: 'startDate'
    dir: 'desc'
```

## Extending available XtcSearch form

Any new XtcRequest service should be based on `\Drupal\xtcelastica\XtendedContent\Serve\XtcRequest\AbstractElasticaXtcRequest`.

Example from the `GetElasticaXtcRequest` type:

```php
namespace Drupal\xtcelastica\XtendedContent\Serve\XtcRequest;


use Drupal\xtcelastica\XtendedContent\Serve\Client\GetElasticaClient;

class GetElasticaXtcRequest extends AbstractElasticaXtcRequest
{
  /**
   * @return \Drupal\xtcelastica\XtendedContent\Serve\Client\AbstractElasticaClient
   */
  protected function getElasticaClient(){
    return New GetElasticaClient($this->profile);
  }

}
```