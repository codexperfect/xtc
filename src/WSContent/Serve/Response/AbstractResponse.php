<?php
/**
 * Created by PhpStorm.
 * User: w3wfr
 * Date: 22/04/2018
 * Time: 15h50
 */

namespace Drupal\wscontent\WSContent\Serve\Response;

use Drupal\Component\Serialization\Json;
use Drupal\wscontent\WSContent\API\Config;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class AbstractResponse implements ResponseInterface {

  /**
   * @var
   */
  private $config;

  /**
   * @var HttpResponse
   */
  protected $response;

  public function __construct() {
    $this->setConfig()->init();
  }

  /**
   * @return HttpResponse $response
   */
  protected function init() {
    $this->response = New HttpResponse();
    return $this->response;
  }

  /**
   * @return HttpResponse $response
   */
  public function get() : HttpResponse {
    $this->response->setContent(Json::decode($this->response->getContent()));
    return $this->response;
  }

  public function getJson(): JsonResponse {
    return $this->response;
  }

  public function getContent(){
    return $this->response->getContent();
  }

//  /**
//   * @return \Symfony\Component\HttpFoundation\Response
//   */
//  public function getResponse(): \Symfony\Component\HttpFoundation\Response {
//    $this->response->setContent(Json::decode($this->response->getContent()));
//    return $this->response;
//  }

  /**
   * @param HttpResponse $response
   *
   * @return $this
   */
  public function setResponse(HttpResponse $response) {
    $this->response = $response;
    return $this;
  }

  public function setData($data){
    $this->response->setContent($data);
  }

  /**
   * @return mixed
   */
  public function getConfig()
  {
    return $this->config;
  }

  public function setConfig()
  {
    $this->config = Config::getConfigs('serve', 'wsrequest');
    return $this;
  }
}
