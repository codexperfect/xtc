<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 19/04/2018
 * Time: 17:13
 */

namespace Drupal\xtc\XtendedContent\Serve\Client;


interface ClientInterface
{

  /**
   * @return string
   */
  public function get() : string;

  /**
   * @return \Drupal\xtc\XtendedContent\Serve\Client\ClientInterface
   */
  public function setXtcConfigFromYaml() : ClientInterface;

  /**
   * @param array $config
   *
   * @return \Drupal\xtc\XtendedContent\Serve\Client\ClientInterface
   */
  public function setXtcConfig($config) : ClientInterface;

  /**
   * @param string $method
   * @param string $param
   *
   * @return \Drupal\xtc\XtendedContent\Serve\Client\ClientInterface
   */
  public function init($method, $param = '') : ClientInterface;

  /**
   * @return \Drupal\xtc\XtendedContent\Serve\Client\ClientInterface
   */
  public function setOptions()  : ClientInterface;


}
