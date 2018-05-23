<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 19/04/2018
 * Time: 17:16
 */

namespace Drupal\wscontent\WSContent\Serve\WSRequest;


interface WSRequestInterface
{
  public function __construct($profile = '');

  public function get($method, $param = '');

  public function getConfig();

  public function setConfig(array $config);

  public function setConfigFromYaml();

  public function getData($format = 'json');
}
