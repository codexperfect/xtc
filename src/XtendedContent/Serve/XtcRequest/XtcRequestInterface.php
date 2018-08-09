<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 19/04/2018
 * Time: 17:16
 */

namespace Drupal\xtc\XtendedContent\Serve\XtcRequest;


interface XtcRequestInterface
{
  public function __construct($profile = '');

  /**
   * @param $method
   * @param string $param
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup|mixed|string
   */
  public function get($method, $param = '');

  public function getConfig();

  public function setConfig(array $config);

  public function getData($format = 'json');

  public function getWebservice();

}
