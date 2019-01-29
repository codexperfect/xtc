<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 03/11/2017
 * Time: 16:25
 */

namespace Drupal\xtc\XtendedContent\API;


use Drupal\Core\Block\BlockBase;
use Drupal\Core\Link;
use Drupal\xtc\PluginManager\XtcHandler\XtcHandlerPluginBase;
use Drupal\xtc\XtendedContent\Serve\XtcRequest\AbstractXtcRequest;
use Drupal\xtcfile\Controller\XtcDocumentationController;
use Drupal\xtcsearch\PluginManager\XtcSearch\XtcSearchDefault;
use Drupal\xtcsearch\PluginManager\XtcSearchDisplay\XtcSearchDisplayDefault;
use Drupal\xtcsearch\PluginManager\XtcSearchFilter\XtcSearchFilterDefault;
use Drupal\xtcsearch\PluginManager\XtcSearchFilterType\XtcSearchFilterTypePluginBase;
use Drupal\xtcsearch\PluginManager\XtcSearchPager\XtcSearchPagerPluginBase;
use Drupal\xtcsearch\SearchBuilder\XtcSearchBuilder;
use Drupal\xtcsearch\PluginManager\XtcSearchPager\XtcSearchPagerPluginBase;

class Config
{

  /**
   * PROFILE
   */

  public static function loadXtcHandler($name) : array{
    return XtcHandler::load($name);
  }

  // Search
  public static function getXtcForm($name) : XtcSearchDefault{
    return XtcForm::get($name);
  }
  public static function loadXtcForm($name) : array{
    return XtcForm::load($name);
  }

  // Server
  public static function loadXtcServer($name) : array {
    return XtcServer::load($name);
  }

  // Display
  public static function getXtcDisplay($name) : XtcSearchDisplayDefault{
    return XtcDisplay::get($name);
  }
  public static function loadXtcDisplay($name) : array{
    return XtcDisplay::load($name);
  }

  // Pager
  public static function getXtcPager($name) : XtcSearchPagerPluginBase{
    return XtcPager::get($name);
  }

  // Filter
  public static function getXtcFilter($name) : XtcSearchFilterDefault{
    return XtcFilter::get($name);
  }

  // Mapping
  public static function loadXtcMapping($name) : array{
    return XtcMapping::load($name);
  }

  // Request
  public static function loadXtcRequest($name) : array{
    return XtcRequest::load($name);
  }

  // Filter Type
  public static function getXtcFilterType($name) : XtcSearchFilterTypePluginBase{
    return XtcFilterType::get($name);
  }
  public static function loadXtcFilterType($name) : array {
    return XtcFilterType::load($name);
  }

  // Profile
  public static function getProfile($name) : XtcHandlerPluginBase{
    return XtcHandler::getHandlerFromProfile($name);
  }
  public static function loadXtcProfile($name) : array {
    return XtcProfile::load($name);
  }

  // File
  public static function getFile($name) {
    return XtcHandler::getFile($name);
  }









  public static function transliterate($phrase){
    $string = strtolower(\Drupal::transliteration()->transliterate($phrase));
    return str_replace(' ', '_', $string);
  }



  /**
   * @param $name
   *
   * @return string
   */
  public static function getHelp($module){
    $links =(New XtcDocumentationController())->getHelp();
    return self::getHelpFile($module)
           . $links;
  }

  /**
   * @param $name
   *
   * @return string
   */
  public static function getHelpFile($module){
    foreach(['help/help.md'] as $path){
      $profile = [
        'type' => 'markdown',
        'abs_path' => false,
        'module' => $module,
        'path' => $path,
      ];
      $content = self::getFromProfile($profile);
      if(!empty($content)){
        return $content;
      }
    }
    return '';
  }

  public static function getDocs($module){
    $profile = [
      'type' => 'mkdocs',
      'abs_path' => false,
      'module' => $module,
      'path' => 'help/mkdocs.yml',
    ];
    $content = self::getFromProfile($profile);
    if(!empty($content) && is_array($content)) {
      return $content;
    }
    return "<h2>Documentation needs to be created.</h2>
           <p>Documentation follows <b><a href='https://www.mkdocs.org/' target='_blank'>
           mkdocs</a></b> standards.</p>
        ";
  }

  /**
   * @param $name
   *
   * @return string
   */
  public static function getDocsPage($module, $path){
    $profile = [
      'type' => 'mkdocs',
      'abs_path' => false,
      'module' => $module,
      'path' => 'help/docs/' . $path,
    ];
    $content = self::getFromProfile($profile);
    if(!empty($content)) {
      return $content;
    }
    $link = Link::createFromRoute('Index', 'xtcfile.docs.docs',
                                  ['module' => $module])->toString();
    return "<h2>Page not found.</h2>
           <p>Go back to the documentation index: $link.</p>
        ";
  }

  public static function getHandlerFromProfile($profile){
    return self::getXtcHandler($profile['type'])
               ->setProfile($profile)
               ->setOptions();
    ;
  }

  public static function getFromProfile($profile){
    return self::getXtcHandler($profile['type'])
               ->setProfile($profile)
               ->setOptions()
               ->get();
    ;
  }

  /**
   * @param $name
   *
   * @return array
   */
  public static function getSearch($name){
    $xtcsearch = self::getXtcForm($name);
    return \Drupal::formBuilder()
                  ->getForm($xtcsearch->getForm());
  }

  /**
   * @param $name
   *
   * @return mixed
   */
  public static function getAutocomplete($name){
    $xtcform = (Config::getXtcForm($name))->getForm();
    $search = New XtcSearchBuilder($xtcform);
    $search->triggerSearch();
    if(!empty($search->getResultSet())){
      $items = $search->getResultSet()->getSuggests()['completion_q'][0]['options'];
      $textList = [];

      foreach($items as $key => $item){
        $value = strtolower(\Drupal::service('csoec_common.common_service')->replaceAccents($item['text']));
        if(!in_array($value, $textList)) {
          $options[$key] = [
            'value' => $value,
            'label' => $value,
          ];
          $textList[] = $value;
        }
      }
    }
    return $options ?? [];
  }



  // Prefix - Suffix
  public static function getPrefix($type, $display, $name) : string{
    $display = self::loadXtcDisplay($display);
    return $display[$type][$name]['prefix'] ?? '';
  }
  public static function getSuffix($type, $display, $name) : string{
    $display = self::loadXtcDisplay($display);
    return $display[$type][$name]['suffix'] ?? '';
  }


  // Search Block
  public static function getXtcSearchBlock($name){
    $block_manager = \Drupal::service('plugin.manager.block');
    $config = [];
    $plugin_block = $block_manager->createInstance($name, $config);
    if($plugin_block instanceof BlockBase){
      $access_result = $plugin_block->access(\Drupal::currentUser());
      if (is_object($access_result) && $access_result->isForbidden()
          || is_bool($access_result) && !$access_result) {
        // You might need to add some cache tags/contexts.
        return [];
      }
      return $plugin_block->build();
    }
  }










  // Profile - legacy
  public static function getXtcRequestFromProfile($name){
    $profile = self::loadXtcProfile($name);
    $xtcrequest = (New $profile['service']($name));
    if($xtcrequest instanceof AbstractXtcRequest){
      $xtcrequest->setConfigfromPlugins();
    }
    return $xtcrequest;
  }

  public static function getConfigs($work, $task){
    return [
      'xtc' => self::mergeConfig($work, $task),
    ];
  }

  private static function mergeConfig($work, $task){
    $xtcList = self::getList($work, $task);
    foreach ($xtcList as $key => $config){
      $configs[] = \Drupal::config($config)->getRawData()['xtcontent'];
    }

    $config = [];
    if(isset($configs)){
      foreach ($configs as $conf){
        $current = array_shift($configs);
        $config = array_merge_recursive($config, $current);
      }
    }

    return $config;
  }

  private static function getList($work, $task){
    $factory = \Drupal::configFactory();
    return preg_grep('/.*\.xtc\.'.$work.'\.'.$task.'/', $factory->listAll());
  }
}
