<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 2019-01-29
 * Time: 17:08
 */

namespace Drupal\xtc\XtendedContent\API;


use Drupal\xtcsearch\PluginManager\XtcSearchDisplay\XtcSearchDisplayDefault;

class XtcDisplay extends XtcPluginBase
{

  public static function get($name, $options = []): XtcSearchDisplayDefault{
    return parent::get($name);
  }

  protected static function getService() : string {
    return 'plugin.manager.xtcsearch_display';
  }
}
