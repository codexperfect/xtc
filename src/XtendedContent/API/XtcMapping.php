<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 2019-01-29
 * Time: 17:08
 */

namespace Drupal\xtc\XtendedContent\API;


use Drupal\xtcelastica\PluginManager\XtcElasticaMappingManagerInterface;

class XtcMapping extends Plugin
{

  public static function get($name): XtcElasticaMappingManagerInterface{
    return parent::get($name);
  }

  protected static function getService() :string {
    return 'plugin.manager.xtcelastica_mapping';
  }
}