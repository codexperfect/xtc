<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 2019-01-29
 * Time: 17:08
 */

namespace Drupal\xtc\XtendedContent\API;


use Drupal\xtcsearch\PluginManager\XtcSearchFilterType\XtcSearchFilterTypePluginBase;

class XtcFilterType extends PluginBase
{

  public static function get($name): XtcSearchFilterTypePluginBase{
    return parent::get($name);
  }

  protected static function getService() : string {
    return 'plugin.manager.xtcsearch_filter_type';
  }

  public static function loadFromFilter($name) : XtcSearchFilterTypePluginBase{
    $filter = XtcFilter::get($name);
    return $filter->getFilterType();
  }

}