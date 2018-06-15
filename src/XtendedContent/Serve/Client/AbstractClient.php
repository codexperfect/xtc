<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 19/04/2018
 * Time: 17:14
 */

namespace Drupal\xtc\XtendedContent\Serve\Client;

use Drupal\xtc\XtendedContent\API\Config;

/**
 * Class AbstractClient
 *
 * @package Drupal\xtc\XtendedContent\Serve\Client
 */
class AbstractClient implements ClientInterface
{

  /**
   * @var string
   */
  protected $profile;

  /**
   * @var array
   */
  protected $xtcConfig;

  /**
   * @var array
   */
  protected $options;

  /**
   * @var array
   */
  protected $clientProfile;

  /**
   * AbstractClient constructor.
   *
   * @param string $profile
   */
  public function __construct(string $profile) {
    $this->profile = $profile;
  }

  /**
   * @param string $method
   * @param string $param
   *
   * @return \Drupal\xtc\XtendedContent\Serve\Client\ClientInterface
   */
  public function init($method, $param = '') : ClientInterface{
    return $this;
  }

  /**
   * @return string
   */
  public function get() : string {
    return '';
  }

  /**
   * @return \Drupal\xtc\XtendedContent\Serve\Client\ClientInterface
   */
  public function setOptions()  : ClientInterface {
    $this->setClientProfile();
    $options = [];
    $this->options = $options;
    return $this;
  }

  /**
   * @return \Drupal\xtc\XtendedContent\Serve\Client\ClientInterface
   */
  protected function buildClient() : ClientInterface {
    $this->setOptions();
    return $this;
  }

  /**
   * @return \Drupal\xtc\XtendedContent\Serve\Client\ClientInterface
   */
  public function setClientProfile() : ClientInterface
  {
    $this->clientProfile = $this->xtcConfig['xtc']['serve_client'][$this->profile];
    return $this;
  }

  /**
   * @return mixed
   */
  public function getType() : string
  {
    return $this->clientProfile['type'];
  }

  /**
   * @return array
   */
  public function getXtcConfig() : array{
    return $this->xtcConfig;
  }

  /**
   * @return \Drupal\xtc\XtendedContent\Serve\Client\ClientInterface
   */
  public function setXtcConfigFromYaml() : ClientInterface {
    $client = Config::getConfigs('serve', 'client');
    $this->xtcConfig = array_merge_recursive($client);
    $this->buildClient();
    return $this;
  }

  /**
   * @param array $config
   *
   * @return \Drupal\xtc\XtendedContent\Serve\Client\ClientInterface
   */
  public function setXtcConfig($config) : ClientInterface {
    $this->xtcConfig = $config;
    $this->buildClient();
    return $this;
  }

  /**
   * @param $environment
   *
   * @return array
   */
  protected function getEnvironment($environment) : array {
    return $this->clientProfile['path'][$environment];
  }

  protected function getInfo($item) : string {
    return (isset($this->clientProfile[$item])) ? $this->clientProfile[$item] : '';
  }

}
