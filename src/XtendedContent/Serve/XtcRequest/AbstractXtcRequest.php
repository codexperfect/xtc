<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 19/04/2018
 * Time: 17:16
 */

namespace Drupal\xtc\XtendedContent\Serve\XtcRequest;


use Drupal\Component\Serialization\Json;
use Drupal\Core\Site\Settings;
use Drupal\xtc\XtendedContent\API\Config;
use Drupal\xtc\XtendedContent\Serve\Client\ClientInterface;
use GuzzleHttp\Exception\RequestException;

abstract class AbstractXtcRequest implements XtcRequestInterface
{

  /**
   * @var array
   */
  protected $options = [];

  protected $config;

  protected $data;

  /**
   * @var ClientInterface
   */
  protected $client;

  protected $profile;

  protected $webservice;

  public function __construct($profile = '')
  {
    $this->profile = $profile;
  }

  public function setProfile($profile = '')
  {
    $this->profile = $profile;
  }

  abstract protected function buildClient();

  public function setConfigfromPlugins()
  {
    $name = $this->profile;
    $profile = Config::loadXtcProfile($name);
    $this->webservice = [
      'type' => $profile['type'],
    ];
    $this->config['xtc']['serve_client'][$name] = $profile;

    $this->buildClient();
    return $this;
  }

  /**
   * @return ClientInterface
   */
  public function getClient(): ClientInterface {
    return $this->client;
  }

  /**
   * @return mixed
   */
  public function getType()
  {
    return $this->webservice['type'];
  }

  /**
   * @param        $method
   * @param string $param
   *
   * @return $this
   */
  public function get($method, $param = '')
  {
    try {
      $this->client->init($method, $param);
      $content = $this->client->get();
    } catch (RequestException $e) {
      $content = '';
    }
    $this->setData($content);
    return $this;
  }

  /**
   * @return mixed
   */
  public function getConfig()
  {
    return $this->config;
  }

  public function setConfig(array $config = [])
  {
    $this->config = ([] == $config) ? $this->getConfigFromYaml() : $config;
    $this->setWebservice();
    $this->buildClient();
    return $this;
  }

  public function getConfigFromYaml()
  {
    $params = Config::getConfigs('serve', 'client');

    // Enable config override from settings.local.php
    $settings = Settings::get('xtc.serve_client');
    if(!empty($settings)){
      return array_replace_recursive($params, $settings);
    }
    return $params;
  }

  /**
   * @return $this
   */
  protected function setWebservice()
  {
    $this->webservice = $this->config['xtc']['serve_client'][$this->profile];
    return $this;
  }

  /**
   * @return mixed
   */
  public function getWebservice() {
    return $this->webservice;
  }

  /**
   * @return mixed
   */
  public function getData($format = 'json')
  {
    if(!isset($this->data)){
      $this->data = '{}';
    }
    switch ($format){
      case 'object':
        return Json::decode($this->data);
        break;
      case 'array':
        return (array) Json::decode($this->data);
        break;
      default:
        return $this->data;
    }
  }

  /**
   * @param $data
   * @return $this
   */
  public function setData($data)
  {
    $this->data = $data;
    return $this;
  }

  /**
   * @return string
   */
  public function getProfile(): string {
    return $this->profile;
  }

}
