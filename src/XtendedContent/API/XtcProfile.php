<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 2019-01-29
 * Time: 17:08
 */

namespace Drupal\xtc\XtendedContent\API;


use Drupal\xtc\PluginManager\XtcProfile\XtcProfileDefault;

class XtcProfile extends Plugin
{

  public static function get($name): XtcProfileDefault{
    return parent::get($name);
  }

  protected static function getService() :string {
    return 'plugin.manager.xtc_profile';
  }

}