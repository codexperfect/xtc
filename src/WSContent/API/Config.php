<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 03/11/2017
 * Time: 16:25
 */

namespace Drupal\wscontent\WSContent\API;

class Config
{
  public static function get($name){
    return \Drupal::config('wscontent.'.$name.'.settings');
  }

  public static function getData ($name){
    return self::get($name)->getRawData();
  }

  public static function getConfigs($work, $task){
    return [
      'wscontent' => self::mergeConfig($work, $task),
    ];
  }

  private static function mergeConfig($work, $task){
    $wscList = self::getList($work, $task);
    foreach ($wscList as $key => $config){
      $configs[] = \Drupal::config($config)->getRawData()['wscontent'];
    }

    $config = [];
    foreach ($configs as $conf){
      $current = array_shift($configs);
      $config = array_merge_recursive($config, $current);
    }

    return $config;
  }

  private static function getList($work, $task){
    $factory = \Drupal::configFactory();
    return preg_grep('/.*\.wsc\.'.$work.'\.'.$task.'/', $factory->listAll());
  }
}
