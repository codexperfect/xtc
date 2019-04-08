<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 2019-01-29
 * Time: 16:47
 */

namespace Drupal\xtc\XtendedContent\API;


abstract class XtcPluginBase
{

  public static function get($name, $options = []){
    return \Drupal::service(static::getService())
                  ->createInstance($name) ?? [];
  }

  public static function load($name){
    $definition = \Drupal::service(static::getService())
                  ->getDefinition($name) ?? [];
    if(!empty($definition['override'])){
      $definition = array_merge(self::load($definition['override']), $definition);
    }
    return $definition;
  }

  protected static function getService() : string {
    return '';
  }
}