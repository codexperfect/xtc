<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 2019-01-29
 * Time: 17:08
 */

namespace Drupal\xtc\XtendedContent\API;


use Drupal\xtcsearch\PluginManager\XtcSearchFilter\XtcSearchFilterDefault;

class XtcFilter extends Plugin
{

  public static function get($name): XtcSearchFilterDefault{
    return parent::get($name);
  }

    protected static function getService() :string {
    return 'plugin.manager.xtcsearch_filter';
  }
}