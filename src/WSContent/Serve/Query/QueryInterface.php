<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 27/04/2018
 * Time: 10:03
 */

namespace Drupal\wscontent\WSContent\Serve\Query;


interface QueryInterface
{
  public function __construct(Array $parameters);

  public function getSource();

  public function getType();

  public function getParameters();

  public function getContentType();

  public function getProfile();

  public function getResponse();

  public function getFormat();

  public function getService();

  public function getMethod();

  public function getAll();
}
