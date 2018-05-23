<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 19/04/2018
 * Time: 17:13
 */

namespace Drupal\wscontent\WSContent\Serve\Client;


interface ClientInterface
{

  /**
   * @return string
   */
  public function get() : string;

  /**
   * @return \Drupal\wscontent\WSContent\Serve\Client\ClientInterface
   */
  public function setWsconfigFromYaml() : ClientInterface;

  /**
   * @param array $config
   *
   * @return \Drupal\wscontent\WSContent\Serve\Client\ClientInterface
   */
  public function setWsconfig($config) : ClientInterface;

  /**
   * @param string $method
   * @param string $param
   *
   * @return \Drupal\wscontent\WSContent\Serve\Client\ClientInterface
   */
  public function init($method, $param = '') : ClientInterface;

  /**
   * @return \Drupal\wscontent\WSContent\Serve\Client\ClientInterface
   */
  public function setOptions()  : ClientInterface;


}
