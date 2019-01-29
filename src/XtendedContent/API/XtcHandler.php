<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 2019-01-29
 * Time: 17:08
 */

namespace Drupal\xtc\XtendedContent\API;


use Drupal\xtc\PluginManager\XtcHandler\XtcHandlerPluginBase;

class XtcHandler extends Plugin
{

  public static function get($name): XtcHandlerPluginBase{
    dump(\Drupal::service(static::getService()));
    dump(\Drupal::service(static::getService())->getDefinitions());
    return parent::get($name);
  }

  protected static function getService() :string {
    return 'plugin.manager.xtc_handler';
  }

  /**
   * @param $name
   *
   * @return \Drupal\xtc\PluginManager\XtcHandler\XtcHandlerPluginBase|null
   */
  public static function getHandlerFromProfile($name){
    $profile = XtcProfile::load($name);
    if(!empty($profile)){
      return XtcHandler::get($profile['type'])
                 ->setProfile($profile)
                 ->setOptions()
        ;
    }
    return null;
  }

  public static function getFile($name) {
    $handler = self::getHandlerFromProfile($name);
    if(!empty($handler)){
      return $handler->get();
    }
  }
}