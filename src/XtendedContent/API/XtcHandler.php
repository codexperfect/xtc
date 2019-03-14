<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 2019-01-29
 * Time: 17:08
 */

namespace Drupal\xtc\XtendedContent\API;


use Drupal\Component\Serialization\Json;
use Drupal\xtc\PluginManager\XtcHandler\XtcHandlerPluginBase;

class XtcHandler extends XtcPluginBase
{

  public static function get($name, $options = []): XtcHandlerPluginBase{
    if(!empty($options)){
      return self::getHandlerFromProfile($name, $options);
    }
    return parent::get($name);
  }

  protected static function getService() : string {
    return 'plugin.manager.xtc_handler';
  }

  public static function getFile($name) {
    $handler = self::getHandlerFromProfile($name);
    if(!empty($handler)){
      return $handler->get();
    }
  }

  public static function getElastica($name, $options = []) {
    $handler = self::getHandlerFromProfile($name, $options);
    if(!empty($handler)){
      return $handler->get();
    }
  }

  public static function getGraphQL($name) {
    $handler = XtcHandler::getHandlerFromProfile($name);
    if(!empty($handler)) {
      return Json::decode($handler->get());
    }
    return [];
  }

  /**
   * @param       $name
   * @param array $options
   *
   * @return \Drupal\xtc\PluginManager\XtcHandler\XtcHandlerPluginBase|null
   */
  public static function getHandlerFromProfile($name, $options = []){
    $profile = XtcProfile::load($name);
    if(!empty($profile)){
      return self::get($profile['type'])
                 ->setProfile($profile)
                 ->setOptions($options)
        ;
    }
    return null;
  }

}