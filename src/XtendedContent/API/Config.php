<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 03/11/2017
 * Time: 16:25
 */

namespace Drupal\xtc\XtendedContent\API;


use Drupal\xtc\PluginManager\XtcHandler\XtcHandlerPluginBase;
use Drupal\xtc\XtendedContent\Serve\XtcRequest\AbstractXtcRequest;
use Drupal\xtcsearch\PluginManager\XtcSearch\XtcSearchDefault;

class Config
{

  public static function getProfile($name){
    $profile = self::loadProfile($name);
    return self::createHandler($profile['type'])
                   ->setProfile($profile)
                   ->setOptions();
  }

  public static function transliterate($phrase){
    $string = strtolower(\Drupal::transliteration()->transliterate($phrase));
    return str_replace(' ', '_', $string);
  }

  protected static function loadProfile($name) : array {
    return \Drupal::service('plugin.manager.xtc_profile')
                  ->getDefinition($name)
      ;
  }

  protected static function createHandler($name) : XtcHandlerPluginBase{
    return \Drupal::service('plugin.manager.xtc_handler')
                  ->createInstance($name)
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

  protected static function getXtcForm($name) : XtcSearchDefault{
    return \Drupal::service('plugin.manager.xtcsearch')
             ->createInstance($name);
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
