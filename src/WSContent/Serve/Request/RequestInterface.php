<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 19/04/2018
 * Time: 17:15
 */

namespace Drupal\wscontent\WSContent\Serve\Request;

use Drupal\wscontent\WSContent\Serve\Response\ResponseInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * Interface RequestInterface
 * @package Drupal\wscontent\WSContent\Serve\Request
 */
interface RequestInterface
{
  /**
   * RequestInterface constructor.
   * @param Request $request
   */
  public function __construct();

  /**
   * @return mixed
   */
  public function setConfig();

  public function getQuery();

  public function getResponse() : ResponseInterface;

  public function getWsrequest();
}
