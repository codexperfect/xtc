<?php

namespace Drupal\wscontent\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\wscontent\WSContent\Serve\Request\Request;
use Drupal\wscontent\WSContent\Serve\Request\RequestInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class DbManagerController
 *
 * @package Drupal\dbmanager\Controller
 */
class WscController extends ControllerBase
{
  private $config;

  /**
   * @var RequestInterface
   */
  private $request;

  /**
   * Constructs a CronController object.
   *
   * @param \Drupal\Core\CronInterface $cron
   *   The cron service.
   */
  public function __construct() {
  }

  /**
   * @return Response
   */
  public function content($json = false) {
    $this->request = New Request();
    if($json){
      return $this->request->getResponse()->getJson();
    }
    else {
      return $this->request->getResponse()->get();
    }
  }
}
