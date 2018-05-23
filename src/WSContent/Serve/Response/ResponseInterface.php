<?php
/**
 * Created by PhpStorm.
 * User: w3wfr
 * Date: 22/04/2018
 * Time: 15h50
 */

namespace Drupal\wscontent\WSContent\Serve\Response;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

interface ResponseInterface
{
  public function __construct();

  public function get(): HttpResponse;

  public function getJson(): JsonResponse;

  public function setData($data);

  public function getContent();
}
