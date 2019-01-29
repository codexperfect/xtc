<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 2019-01-29
 * Time: 17:08
 */

namespace Drupal\xtc\XtendedContent\API;


use Drupal\xtc\PluginManager\XtcRequest\XtcRequestDefault;

class XtcRequest extends Plugin
{

  public static function get($name): XtcRequestDefault{
    return parent::get($name);
  }

  protected static function getService() :string {
    return 'plugin.manager.xtc_request';
  }
}