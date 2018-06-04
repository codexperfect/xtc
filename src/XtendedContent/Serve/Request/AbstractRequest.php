<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 19/04/2018
 * Time: 17:15
 */

namespace Drupal\xtc\XtendedContent\Serve\Request;

use Drupal\xtc\XtendedContent\API\Config;
use Drupal\xtc\XtendedContent\Serve\Query\Query;
use Drupal\xtc\XtendedContent\Serve\Query\QueryInterface;
use Drupal\xtc\XtendedContent\Serve\Response\JsonResponse;
use Drupal\xtc\XtendedContent\Serve\Response\Response;
use Drupal\xtc\XtendedContent\Serve\Response\ResponseInterface;
use Drupal\xtc\XtendedContent\Serve\XtcRequest\XtcRequest;
use Drupal\xtc\XtendedContent\Serve\XtcRequest\XtcRequestInterface;

/**
 * Class AbstractRequest
 *
 * @package Drupal\xtc\XtendedContent\Serve\Request
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
   * @var XtcRequestInterface
   */
  private $xtcrequest;

  /**
   * AbstractRequest constructor.
   */
  public function __construct()
  {
    $this->setConfig()
      ->setQuery();
    $xtcRequest = New XtcRequest($this->query->getProfile());
    $xtcRequest->setConfigFromYaml();
    $this->setWsrequest($xtcRequest)
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
    $this->xtcrequest->get($method, $param);
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
    $data = $this->xtcrequest->getData('json');
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
   * @return XtcRequestInterface
   */
  public function getWsrequest(): XtcRequestInterface {
    return $this->xtcrequest;
  }

  public function setWsrequest(XtcRequestInterface $xtcrequest) {
    $this->xtcrequest = $xtcrequest;
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
    $xtcRequest = Config::getConfigs('serve', 'xtcrequest');

    $this->config = array_merge_recursive($serveRequest, $xtcRequest);
    return $this;
  }
}
