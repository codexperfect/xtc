<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 19/04/2018
 * Time: 17:16
 */

namespace Drupal\xtc\XtendedContent\Serve\XtcRequest;


use Drupal\xtc\XtendedContent\API\Config;
use Drupal\xtc\XtendedContent\Serve\Client\ClientInterface;
use GuzzleHttp\Exception\RequestException;

class AbstractXtcRequest implements XtcRequestInterface
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

  protected function buildClient(){
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
   * @param $method
   * @param string $param
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup|mixed|string
   */
  public function get($method, $param = '')
  {
    if ($this->isAllowed($method)){
      try {
        $this->client->init($method, $param);
        $content = $this->client->get();
      } catch (RequestException $e) {
        $content = '';
      }
    }
    else{
      $content = 'Request error: The "'.$method.'" method is not allowed.';
    }
    $this->setData($content);
    return $this;
  }

  public function isAllowed($method)
  {
//    return in_array($method, $this->webservice['allowed']);
    return TRUE;
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
    $client = Config::getConfigs('serve', 'client');
    $xtcrequest = Config::getConfigs('serve', 'xtcrequest');
    return array_merge_recursive($client, $xtcrequest);
  }

  /**
   * @return $this
   */
  protected function setWebservice()
  {
    $xtcRequestSettings = (!empty($this->config['xtc']['serve_xtcrequest'][$this->profile])) ? $this->config['xtc']['serve_xtcrequest'][$this->profile] : [];
    $this->webservice = array_merge_recursive(
      $this->config['xtc']['serve_client'][$this->profile],
      $xtcRequestSettings
    );
    return $this;
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
        return json_decode($this->data);
        break;
      case 'array':
        return (array) json_decode($this->data);
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
}
