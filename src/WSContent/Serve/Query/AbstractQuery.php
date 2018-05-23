<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 27/04/2018
 * Time: 10:04
 */

namespace Drupal\wscontent\WSContent\Serve\Query;


use Drupal\wscontent\WSContent\API\Config;

class AbstractQuery implements QueryInterface
{

  private $config;

  /**
   * @var array
   */
  private $parameters;

  private $isValid;

  private $serviceSpecs;

  public function __construct(Array $parameters)
  {
    $this->setConfig();
    $this->parameters = $parameters;
    $this->setServiceSpecs();
  }

  /**
   * @return mixed
   */
  public function getServiceSpecs()
  {
    return $this->serviceSpecs;
  }

  /**
   * @param mixed $serviceSpecs
   */
  public function setServiceSpecs()
  {
    $allowed = $this->getConfig()['wscontent']['serve_request']['allowed_ws'];
    if (isset($allowed[$this->getSource()][$this->getType()][$this->getFormat()])) {
      $this->serviceSpecs = $allowed[$this->getSource()][$this->getType()][$this->getFormat()];
      $this->isValid = TRUE;
    } else {
      drupal_set_message(t('Request for @source/@type/@format is not allowed: Please provide a valid request.',
        ['@source' => $this->getSource(), '@type' => $this->getType(), '@format' => $this->getFormat(),]), 'error');
      $this->isValid = FALSE;
    }
    return $this;
  }

  /**
   * @return mixed
   */
  public function getContentType()
  {
    return $this->serviceSpecs['content_type'];
  }

  /**
   * @return mixed
   */
  public function getMethod()
  {
    return $this->serviceSpecs['method'];
  }

  public function getAll()
  {
    return [
      'source' => $this->getSource(),
      'type' => $this->getType(),
      'format' => $this->getFormat(),
      'service' => $this->getService(),
      'profile' => $this->getProfile(),
      'respone' => $this->getResponse(),
    ];
  }

  /**
   * @return mixed
   */
  public function getSource()
  {
    return $this->parameters['source'];
  }

  /**
   * @return mixed
   */
  public function getType()
  {
    return $this->parameters['type'];
  }

  /**
   * @return mixed
   */
  public function getFormat()
  {
    return $this->parameters['format'];
  }

  /**
   * @return mixed
   */
  public function getService()
  {
    return $this->serviceSpecs['service'];
  }

  /**
   * @return mixed
   */
  public function getProfile()
  {
    return $this->serviceSpecs['profile'];
  }

  /**
   * @return mixed
   */
  public function getResponse()
  {
    return $this->serviceSpecs['response'];
  }

  /**
   * @return mixed
   */
  public function isValid()
  {
    return $this->isValid;
  }

  /**
   * @return array
   */
  public function getParameters()
  {
    return $this->parameters;
  }

  /**
   * @param array $parameters
   * @return $this
   */
  public function setParameters(Array $parameters)
  {
    $this->parameters = $parameters;
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
    $this->config = array_merge_recursive($serveRequest);
    return $this;
  }

}
