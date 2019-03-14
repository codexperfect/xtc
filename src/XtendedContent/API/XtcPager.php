<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 2019-01-29
 * Time: 17:08
 */

namespace Drupal\xtc\XtendedContent\API;


use Drupal\xtcsearch\PluginManager\XtcSearchPager\XtcSearchPagerPluginBase;

class XtcPager extends XtcPluginBase
{

  public static function get($name, $options = []): XtcSearchPagerPluginBase{
    return parent::get($name);
  }

  protected static function getService() : string {
    return 'plugin.manager.xtcsearch_pager';
  }
}