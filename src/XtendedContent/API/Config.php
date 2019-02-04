<?php
/**
 * Created by PhpStorm.
 * User: aisrael
 * Date: 03/11/2017
 * Time: 16:25
 */

namespace Drupal\xtc\XtendedContent\API;


use Drupal\xtc\PluginManager\XtcHandler\XtcHandlerPluginBase;
use Drupal\xtcsearch\PluginManager\XtcSearch\XtcSearchDefault;
use Drupal\xtcsearch\PluginManager\XtcSearchDisplay\XtcSearchDisplayDefault;
use Drupal\xtcsearch\PluginManager\XtcSearchFilter\XtcSearchFilterDefault;
use Drupal\xtcsearch\PluginManager\XtcSearchFilterType\XtcSearchFilterTypePluginBase;
use Drupal\xtcsearch\PluginManager\XtcSearchPager\XtcSearchPagerPluginBase;

class Config
{

  /**********
   * PROFILE
   *********/


  /**
   * @param $name
   *
   * @return array
   * @deprecated use XtcHandler::load
   */
  public static function loadXtcHandler($name) : array{
    return XtcHandler::load($name);
  }

  // Search
  /**
   * @param $name
   *
   * @return \Drupal\xtcsearch\PluginManager\XtcSearch\XtcSearchDefault
   * @deprecated use XtcForm::get
   */
  public static function getXtcForm($name) : XtcSearchDefault{
    return XtcForm::get($name);
  }

  /**
   * @param $name
   *
   * @return array
   * @deprecated use XtcForm::load
   */
  public static function loadXtcForm($name) : array{
    return XtcForm::load($name);
  }

  // Server
  /**
   * @param $name
   *
   * @return array
   * @deprecated use XtcServer::load
   */
  public static function loadXtcServer($name) : array {
    return XtcServer::load($name);
  }

  // Display
  /**
   * @param $name
   *
   * @return \Drupal\xtcsearch\PluginManager\XtcSearchDisplay\XtcSearchDisplayDefault
   *
   * @deprecated use XtcDisplay::get
   */
  public static function getXtcDisplay($name) : XtcSearchDisplayDefault{
    return XtcDisplay::get($name);
  }

  /**
   * @param $name
   *
   * @return array
   * @deprecated use XtcDisplay::load
   */
  public static function loadXtcDisplay($name) : array{
    return XtcDisplay::load($name);
  }

  // Pager
  /**
   * @param $name
   *
   * @return \Drupal\xtcsearch\PluginManager\XtcSearchPager\XtcSearchPagerPluginBase
   *
   * @deprecated use XtcPager::get
   */
  public static function getXtcPager($name) : XtcSearchPagerPluginBase{
    return XtcPager::get($name);
  }

  // Filter
  /**
   * @param $name
   *
   * @return \Drupal\xtcsearch\PluginManager\XtcSearchFilter\XtcSearchFilterDefault
   *
   * @deprecated use XtcFilter::get
   */
  public static function getXtcFilter($name) : XtcSearchFilterDefault{
    return XtcFilter::get($name);
  }

  // Mapping
  /**
   * @param $name
   *
   * @return array
   * @deprecated use XtcMapping::load
   */
  public static function loadXtcMapping($name) : array{
    return XtcMapping::load($name);
  }

  // Request
  /**
   * @param $name
   *
   * @return array
   * @deprecated use XtcRequest::load
   */
  public static function loadXtcRequest($name) : array{
    return XtcRequest::load($name);
  }

  // Filter Type
  /**
   * @param $name
   *
   * @return \Drupal\xtcsearch\PluginManager\XtcSearchFilterType\XtcSearchFilterTypePluginBase
   * @deprecated use XtcFilterType::get
   */
  public static function getXtcFilterType($name) : XtcSearchFilterTypePluginBase{
    return XtcFilterType::get($name);
  }

  /**
   * @param $name
   *
   * @return array
   * @deprecated use XtcFilterType::load
   */
  public static function loadXtcFilterType($name) : array {
    return XtcFilterType::load($name);
  }

  // Profile
  /**
   * @param $name
   *
   * @return \Drupal\xtc\PluginManager\XtcHandler\XtcHandlerPluginBase
   * @deprecated use XtcHandler::getHandlerFromProfile
   */
  public static function getProfile($name) : XtcHandlerPluginBase{
    return XtcHandler::getHandlerFromProfile($name);
  }

  /**
   * @param $name
   *
   * @return array
   * @deprecated use XtcProfile::load
   */
  public static function loadXtcProfile($name) : array {
    return XtcProfile::load($name);
  }

  // File
  /**
   * @param $name
   *
   * @return string
   * @deprecated use XtcHandler::getFile
   */
  public static function getFile($name) {
    return XtcHandler::getFile($name);
  }


  //------------//

  /**
   * @param $phrase
   *
   * @return mixed
   * @deprecated use ToolBox::transliterate
   */
  public static function transliterate($phrase){
    return ToolBox::transliterate($phrase);
  }


  /**
   * @param $name
   *
   * @return array
   * @deprecated use XtcSearch::get
   */
  public static function getSearch($name){
    return XtcSearch::get($name);
  }

  /**
   * @param $name
   *
   * @return array
   * @deprecated use XtcAutocomplete::get
   */
  public static function getAutocomplete($name){
    return XtcAutocomplete::get($name);
  }



  // Prefix - Suffix

  /**
   * @param $type
   * @param $display
   * @param $name
   *
   * @return string
   * @deprecated use ToolBox::getPrefix
   */
  public static function getPrefix($type, $display, $name) : string{
    return ToolBox::getPrefix($type, $display, $name);
  }
  /**
   *
   * @param $type
   * @param $display
   * @param $name
   *
   * @return string
   * @deprecated use ToolBox::getSuffix
   */
  public static function getSuffix($type, $display, $name) : string{
    return ToolBox::getSuffix($type, $display, $name);
  }


  // Search Block

  /**
   * @param $name
   *
   * @return array
   * @deprecated use XtcSearch::getBlock
   */
  public static function getXtcSearchBlock($name){
    return XtcSearch::getBlock($name);
  }






  // Profile - legacy

  /**
   * @param $name
   *
   * @return mixed
   * @deprecated use XtcRequest::getXtcRequestFromProfile
   */
  public static function getXtcRequestFromProfile($name){
    return XtcRequest::getXtcRequestFromProfile($name);
  }

  /**
   * @param $work
   * @param $task
   *
   * @return array
   */
  public static function getConfigs($work, $task){
    return [
      'xtc' => self::mergeConfig($work, $task),
    ];
  }

  private static function mergeConfig($work, $task){
    $xtcList = self::getList($work, $task);
    foreach ($xtcList as $config){
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
