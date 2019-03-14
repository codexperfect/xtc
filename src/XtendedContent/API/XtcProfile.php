<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 2019-01-29
 * Time: 17:08
 */

namespace Drupal\xtc\XtendedContent\API;


use Drupal\xtc\PluginManager\XtcProfile\XtcProfileDefault;

class XtcProfile extends XtcPluginBase
{

  public static function get($name, $options = []): XtcProfileDefault{
    return parent::get($name);
  }

  protected static function getService() : string {
    return 'plugin.manager.xtc_profile';
  }

  /**
   * @param       $name
   * @param array $options
   *
   * @return \Drupal\xtc\PluginManager\XtcHandler\XtcHandlerPluginBase|null
   */
  public static function getValues($name, $options = []){
    $profile = self::load($name);
    if(!empty($profile)){
      if(!empty($profile['args'])){
        $options = array_merge($options, $profile['args']);
      }
      $handler = XtcHandler::get($profile['type']);
      return $handler->setProfile($profile)
                 ->setOptions($options)
                 ->get()
        ;
    }
    return null;
  }

  /**
   * @param       $name
   * @param array $options
   *
   * @return \Drupal\xtc\PluginManager\XtcHandler\XtcHandlerPluginBase|null
   */
  public static function getFilters($name, $options = []){
    $profile = self::load($name);
    if(!empty($profile)){
      if(!empty($profile['args'])){
        $options = array_merge($options, $profile['args']);
      }
      $handler = XtcHandler::get($profile['type']);
      $filters = $handler->setProfile($profile)
                 ->setOptions($options)
                 ->getFilters()
        ;
      return $filters;
    }
    return null;
  }

}