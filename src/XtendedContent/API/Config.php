<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 03/11/2017
 * Time: 16:25
 */

namespace Drupal\xtc\XtendedContent\API;

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

  private static function mergeConfig($work, $task){
    $xtcList = self::getList($work, $task);
    foreach ($xtcList as $key => $config){
      $configs[] = \Drupal::config($config)->getRawData()['xtcontent'];
    }

    dump($configs);
    $config = [];
    foreach ($configs as $conf){
      $current = array_shift($configs);
      $config = array_merge_recursive($config, $current);
    }

    return $config;
  }

  private static function getList($work, $task){
    $factory = \Drupal::configFactory();
    return preg_grep('/.*\.xtc\.'.$work.'\.'.$task.'/', $factory->listAll());
  }
}
