<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 27/04/2018
 * Time: 11:01
 */

namespace Drupal\xtc\XtendedContent\Serve\Client;


class ElasticaClient extends AbstractClient
{

  /**
   * @param string $method
   * @param string $param
   *
   * @return \Drupal\xtc\XtendedContent\Serve\Client\ClientInterface
   */
  public function init($method, $param = '') : ClientInterface {
//    $this->setUri($method, $param);
    return $this;
  }

  /**
   * @return string
   */
  public function get() : string {
    $res = $this->client->get($this->uri);
    return $res->getBody()->getContents();
  }

}
