<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 27/04/2018
 * Time: 11:01
 */

namespace Drupal\wscontent\WSContent\Serve\Client;

use Drupal\wscontent\WSContent\API\Config;
use GuzzleHttp\Psr7\Uri;
use GuzzleHttp\Client as GuzzleClient;

class HttpClient extends AbstractClient
{

  /**
   * @var string
   */
  private $url;

  /**
   * @var Uri
   */
  private $uri;

  /**
   * @var GuzzleClient
   */
  protected $client;

  /**
   * @return string
   */
  public function get() : string {
    $res = $this->client->get($this->uri);
    return $res->getBody()->getContents();
  }

  /**
   * @param string $method
   * @param string $param
   *
   * @return \Drupal\wscontent\WSContent\Serve\Client\ClientInterface
   */
  public function init($method, $param = '') : ClientInterface {
    $this->setUri($method, $param);
    return $this;
  }

  /**
   * @return \Drupal\wscontent\WSContent\Serve\Client\ClientInterface
   */
  protected function buildClient() : ClientInterface {
    $this->setOptions();
    $this->client = New GuzzleClient($this->options);
    return $this;
  }

  /**
   * @return \GuzzleHttp\Client
   */
  public function getClient() {
    return $this->client;
  }

  /**
   * @return \Drupal\wscontent\WSContent\Serve\Client\ClientInterface
   */
  public function setWsconfigFromYaml() : ClientInterface {
    $client = Config::getConfigs('serve', 'client');
    $wstoken = Config::getConfigs('serve', 'wstoken');
    $this->wsconfig = array_merge_recursive($client, $wstoken);
    $this->buildClient();
    return $this;
  }

  /**
   * @return $this|\Drupal\wscontent\WSContent\Serve\Client\ClientInterface
   */
  public function setOptions() : ClientInterface
  {
    $this->setClientProfile();
    $this->setUrl();

    $options = $this->clientProfile['options'];
    $options['base_uri'] = $this->getUrl();
    $options['headers']['auth_token'] = $this->getToken();
    $this->options = $options;
    return $this;
  }

  /**
   * @return string
   */
  public function getToken() : string
  {
    return $this->clientProfile['token'];
  }

  /**
   * @param $method
   * @param string $param
   *
   * @return \Drupal\wscontent\WSContent\Serve\Client\ClientInterface
   */
  public function setUri($method, $param = '') : ClientInterface {
    $this->uri = New Uri($method . '/' . $param);
    return $this;
  }

  /**
   * @return \GuzzleHttp\Psr7\Uri
   */
  public function getUri() {
    return $this->uri;
  }

  /**
   * @return string
   */
  public function getUrl()
  {
    return $this->url;
  }

  /**
   * @return \Drupal\wscontent\WSContent\Serve\Client\ClientInterface
   */
  public function setUrl() : ClientInterface
  {
    $this->url = $this->buildWSPath($this->clientProfile['env']);
    return $this;
  }

  /**
   * @param string $environment
   *
   * @return string
   */
  private function buildWSPath($environment){
    $env =  $this->getEnvironment($environment);
    $protocole = ($env['tls']) ? 'https' : 'http' ;
    $port = (isset($env['port'])) ? ':'.$env['port'] : '';
    return $protocole.'://'.$env['server'].$port.'/'.$env['endpoint'].'/';
  }
}
