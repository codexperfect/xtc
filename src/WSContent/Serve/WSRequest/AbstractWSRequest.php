<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 19/04/2018
 * Time: 17:16
 */

namespace Drupal\wscontent\WSContent\Serve\WSRequest;


use Drupal\wscontent\WSContent\API\Config;
use Drupal\wscontent\WSContent\Serve\Client\DummyClient;
use Drupal\wscontent\WSContent\Serve\Client\ESClient;
use Drupal\wscontent\WSContent\Serve\Client\HttpClient;
use Drupal\wscontent\WSContent\Serve\Client\ClientInterface;
use GuzzleHttp\Exception\RequestException;

class AbstractWSRequest implements WSRequestInterface
{

  /**
   * @var array
   */
  protected $options = [];

  private $config;

  private $data;

  /**
   * @var ClientInterface
   */
  private $client;

  private $profile;

  private $webservice;

  public function __construct($profile = '')
  {
    $this->profile = $profile;
  }

  private function buildClient(){
    if(isset($this->profile)){
      switch ($this->getType()){
        case 'dummy':
          $this->client = new DummyClient($this->profile);
          break;
        case 'elasticsearch':
          $this->client = new ESClient($this->profile);
          break;
        case 'guzzle':
        default:
        $this->client = new HttpClient($this->profile);
      }
    }
    $this->client->setWsconfigFromYaml();
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
        $this->setData($content);
        return $this;
      } catch (RequestException $e) {
        return ('Request error: ' . $e->getMessage());
      }
    }
    else{
      return (t('Request error: The "'.$method.'" method is not allowed.'));
    }
  }

  public function isAllowed($method)
  {
    return in_array($method, $this->webservice['allowed']);
  }

  /**
   * @return mixed
   */
  public function getConfig()
  {
    return $this->config;
  }

  public function setConfig(array $config)
  {
    $this->config = $config;
    $this->setWebservice();
    $this->buildClient();
    return $this;
  }

  public function setConfigFromYaml()
  {
    $client = Config::getConfigs('serve', 'client');
    $wsrequest = Config::getConfigs('serve', 'wsrequest');
    $this->config = array_merge_recursive($client, $wsrequest);
    $this->setWebservice();
    $this->buildClient();
    return $this;
  }

  /**
   * @return $this
   */
  private function setWebservice()
  {
    $this->webservice = array_merge_recursive(
      $this->config['wscontent']['serve_client'][$this->profile],
      $this->config['wscontent']['serve_wsrequest'][$this->profile]
      );
    return $this;
  }

  /**
   * @return mixed
   */
  public function getData($format = 'json')
  {
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
