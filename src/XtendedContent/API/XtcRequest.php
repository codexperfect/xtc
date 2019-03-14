<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 2019-01-29
 * Time: 17:08
 */

namespace Drupal\xtc\XtendedContent\API;


use Drupal\xtc\PluginManager\XtcRequest\XtcRequestDefault;
use Drupal\xtc\XtendedContent\Serve\XtcRequest\AbstractXtcRequest;

class XtcRequest extends XtcPluginBase
{

  /**
   * @param $name
   *
   * @return \Drupal\xtc\PluginManager\XtcRequest\XtcRequestDefault
   */
  public static function get($name, $options = []): XtcRequestDefault{
    return parent::get($name);
  }

  /**
   * @return string
   */
  protected static function getService() : string {
    return 'plugin.manager.xtc_request';
  }


  // Profile - legacy

  /**
   * @param $name
   *
   * @return mixed
   */
  public static function getXtcRequestFromProfile($name){
    $profile = XtcProfile::load($name);
    $xtcrequest = (New $profile['service']($name));
    if($xtcrequest instanceof AbstractXtcRequest){
      $xtcrequest->setConfigfromPlugins();
    }
    return $xtcrequest;
  }

}