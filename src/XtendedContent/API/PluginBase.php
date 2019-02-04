<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 2019-01-29
 * Time: 16:47
 */

namespace Drupal\xtc\XtendedContent\API;


abstract class PluginBase
{

  public static function get($name){
    return \Drupal::service(static::getService())
                  ->createInstance($name) ?? [];
  }
  public static function load($name){
    return \Drupal::service(static::getService())
                  ->getDefinition($name) ?? [];
  }
  protected static function getService() : string {
    return '';
  }
}