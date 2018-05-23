<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 19/04/2018
 * Time: 17:14
 */

namespace Drupal\wscontent\WSContent\Serve\Client;

use Drupal\wscontent\WSContent\API\Config;

/**
 * Class AbstractClient
 *
 * @package Drupal\wscontent\WSContent\Serve\Client
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
  protected $wsconfig;

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
   * @return \Drupal\wscontent\WSContent\Serve\Client\ClientInterface
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
   * @return \Drupal\wscontent\WSContent\Serve\Client\ClientInterface
   */
  public function setOptions()  : ClientInterface {
    $this->setClientProfile();
    $options = [];
    $this->options = $options;
    return $this;
  }

  /**
   * @return \Drupal\wscontent\WSContent\Serve\Client\ClientInterface
   */
  public function setClientProfile() : ClientInterface
  {
    $this->clientProfile = $this->wsconfig['wscontent']['serve_client'][$this->profile];
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
  public function getWsconfig() : array{
    return $this->wsconfig;
  }

  /**
   * @return \Drupal\wscontent\WSContent\Serve\Client\ClientInterface
   */
  public function setWsconfigFromYaml() : ClientInterface {
    $client = Config::getConfigs('serve', 'client');
    $this->wsconfig = array_merge_recursive($client);
    $this->buildClient();
    return $this;
  }

  /**
   * @param array $config
   *
   * @return \Drupal\wscontent\WSContent\Serve\Client\ClientInterface
   */
  public function setWsconfig($config) : ClientInterface {
    $this->wsconfig = $config;
    $this->buildClient();
    return $this;
  }

  /**
   * @return \Drupal\wscontent\WSContent\Serve\Client\ClientInterface
   */
  protected function buildClient() : ClientInterface {
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
}
