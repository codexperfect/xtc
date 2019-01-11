<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 03/11/2017
 * Time: 16:25
 */

namespace Drupal\xtc\XtendedContent\API;


use Drupal\Core\Block\BlockBase;
use Drupal\Core\Plugin\PluginBase;
use Drupal\xtc\PluginManager\XtcHandler\XtcHandlerPluginBase;
use Drupal\xtc\XtendedContent\Serve\XtcRequest\AbstractXtcRequest;
use Drupal\xtcsearch\PluginManager\XtcSearch\XtcSearchDefault;
use Drupal\xtcsearch\PluginManager\XtcSearchDisplay\XtcSearchDisplayDefault;
use Drupal\xtcsearch\SearchBuilder\XtcSearchBuilder;

class Config
{

  public static function getProfile($name){
    $profile = self::loadProfile($name);
    return self::getHandler($profile['type'])
                   ->setProfile($profile)
                   ->setOptions();
  }

  public static function transliterate($phrase){
    $string = strtolower(\Drupal::transliteration()->transliterate($phrase));
    return str_replace(' ', '_', $string);
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
    $items = $search->getResultSet()->getSuggests()['completion_q'][0]['options'];

    foreach($items as $key => $item){
      $value = strtolower($item['text']);
      $options[$key] = [
        'value' => $value,
        'label' => $value,
      ];
    }
    return $options;
  }

  public static function loadProfile($name) : array {
    return self::loadPlugin('plugin.manager.xtc_profile', $name);
  }

  public static function getPrefix($type, $display, $name) : string{
    $display = self::loadXtcDisplay($display);
    return $display[$type][$name]['prefix'] ?? '';
  }
  public static function getSuffix($type, $display, $name) : string{
    $display = self::loadXtcDisplay($display);
    return $display[$type][$name]['suffix'] ?? '';
  }

  private static function loadPlugin($service, $name) : array{
    return \Drupal::service($service)
                  ->getDefinition($name);
  }
  private static function createPlugin($service, $name) : PluginBase{
    return \Drupal::service($service)
                  ->createInstance($name);
  }

  protected static function getHandler($name) : XtcHandlerPluginBase{
    return self::createPlugin('plugin.manager.xtc_handler', $name);
  }
  public static function loadHandler($name) : array{
    return self::loadPlugin('plugin.manager.xtc_handler', $name);
  }

  public static function getXtcForm($name) : XtcSearchDefault{
    return self::createPlugin('plugin.manager.xtcsearch', $name);
  }
  public static function loadXtcForm($name) : array{
    return self::loadPlugin('plugin.manager.xtcsearch', $name);
  }

  public static function getXtcDisplay($name) : XtcSearchDisplayDefault{
    return self::createPlugin('plugin.manager.xtcsearch_display', $name);
  }
  public static function loadXtcDisplay($name) : array{
    return self::loadPlugin('plugin.manager.xtcsearch_display', $name);
  }


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










  public static function getXtcProfile($name){
    $profile = \Drupal::service('plugin.manager.xtc_profile')
      ->getDefinition($name)
    ;
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
