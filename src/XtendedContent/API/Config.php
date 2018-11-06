<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 03/11/2017
 * Time: 16:25
 */

namespace Drupal\xtc\XtendedContent\API;

use Drupal\xtc\XtendedContent\Serve\XtcRequest\AbstractXtcRequest;

class Config
{
  public static function get($name){
    return \Drupal::config('xtc.'.$name.'.settings');
  }

  public static function getData ($name){
    return self::get($name)->getRawData();
  }

  public static function getConfigs($work, $task){
    return [
      'xtc' => self::mergeConfig($work, $task),
    ];
  }

  public static function getXtcProfile($name){
    $profile = \Drupal::service('plugin.manager.xtc_profile')
      ->getDefinition($name)
    ;
    $xtcrequest = (New $profile['service']($name));
    if($xtcrequest instanceof AbstractXtcRequest){
      $xtcrequest->setConfigfromPlugins();
    }

    return $xtcrequest;
  }

  private static function mergeConfig($work, $task){
    $xtcList = self::getList($work, $task);
    foreach ($xtcList as $key => $config){
      $configs[] = \Drupal::config($config)->getRawData()['xtcontent'];
    }

    $config = [];
    if(isset($configs)){
      foreach ($configs as $conf){
        $current = array_shift($configs);
        $config = array_merge_recursive($config, $current);
      }
    }

    return $config;
  }

  private static function getList($work, $task){
    $factory = \Drupal::configFactory();
    return preg_grep('/.*\.xtc\.'.$work.'\.'.$task.'/', $factory->listAll());
  }
}
