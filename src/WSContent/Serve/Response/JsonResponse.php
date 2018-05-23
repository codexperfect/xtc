<?php
/**
 * Created by PhpStorm.
 * User: w3wfr
 * Date: 22/04/2018
 * Time: 15h50
 */

namespace Drupal\wscontent\WSContent\Serve\Response;


use Symfony\Component\HttpFoundation\JsonResponse as HttpJsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

class JsonResponse extends AbstractResponse
{

  /**
   * @var HttpJsonResponse
   */
  protected $response;

  /**
   * @return HttpJsonResponse $response
   */
  protected function init() {
    $this->response = New HttpJsonResponse();
    return $this->response;
  }

  public function getContent(){
    return $this->response->getContent();
  }

  /**
   * @return HttpResponse
   */
  public function get(): HttpResponse {
    return $this->response;
  }

  /**
   * @return HttpJsonResponse
   */
  public function getJson(): HttpJsonResponse {
    return $this->response;
  }
}
