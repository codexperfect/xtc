<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 19/04/2018
 * Time: 17:15
 */

namespace Drupal\wscontent\WSContent\Serve\Request;

use Drupal\wscontent\WSContent\API\Config;
use Drupal\wscontent\WSContent\Serve\Query\Query;
use Drupal\wscontent\WSContent\Serve\Query\QueryInterface;
use Drupal\wscontent\WSContent\Serve\Response\JsonResponse;
use Drupal\wscontent\WSContent\Serve\Response\Response;
use Drupal\wscontent\WSContent\Serve\Response\ResponseInterface;
use Drupal\wscontent\WSContent\Serve\WSRequest\WSRequest;
use Drupal\wscontent\WSContent\Serve\WSRequest\WSRequestInterface;

/**
 * Class AbstractRequest
 *
 * @package Drupal\wscontent\WSContent\Serve\Request
 */
class AbstractRequest implements RequestInterface
{

  /**
   * @var QueryInterface
   */
  private $query;

  /**
   * @var
   */
  private $config;

  /**
   * @var ResponseInterface
   */
  private $response;

  /**
   * @var WSRequestInterface
   */
  private $wsrequest;

  /**
   * AbstractRequest constructor.
   */
  public function __construct()
  {
    $this->setConfig()
      ->setQuery();
    $wsRequest = New WSRequest($this->query->getProfile());
    $wsRequest->setConfigFromYaml();
    $this->setWsrequest($wsRequest)
      ->initResponse()
      ->setData($this->getMethod(), $this->getQueryParam());
    $this->renderData();
  }

  /**
   * @return mixed
   */
  public function getService()
  {
    return $this->query->getService();
  }

  /**
   * @return mixed
   */
  public function getMethod() {
    return $this->query->getMethod();
  }

  protected function getQueryParam()
  {
    return $this->getParams()['query'];
  }

  public function setData($method, $param = '')
  {
    $this->wsrequest->get($method, $param);
    return $this;
  }

  /**
   * @return mixed
   */
  public function getContentType() {
    return $this->query->getContentType();
  }

  /**
   * @return mixed
   */
  public function getParams()
  {
    return \Drupal::request()->attributes->all();
  }

  public function renderData()
  {
    $data = $this->wsrequest->getData('json');
    $this->response->setData($data);
  }

  /**
   * @return QueryInterface
   */
  public function getQuery()
  {
    return $this->query;
  }

  /**
   * @return $this
   */
  public function setQuery()
  {
    $this->query = New Query($this->getParams());
    return $this;
  }

  /**
   * @return WSRequestInterface
   */
  public function getWsrequest(): WSRequestInterface {
    return $this->wsrequest;
  }

  public function setWsrequest(WSRequestInterface $wsrequest) {
    $this->wsrequest = $wsrequest;
    return $this;
  }

  /**
   * @return ResponseInterface
   */
  public function getResponse() : ResponseInterface
  {
    return $this->response;
  }

  /**
   * @param Response $response
   */
  public function setResponse($response)
  {
    $this->response = $response;
    return $this;
  }

  /**
   * @param Response $response
   */
  public function initResponse()
  {
    $params = $this->query->getParameters();
    if($params['json']){
      $this->response = New JsonResponse();
    }
    else {
      $this->response = New Response();
    }
    return $this;
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
    $serveRequest = Config::getConfigs('serve', 'request');
    $wsRequest = Config::getConfigs('serve', 'wsrequest');

    $this->config = array_merge_recursive($serveRequest, $wsRequest);
    return $this;
  }
}
