<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 19/04/2018
 * Time: 17:21
 */

namespace Drupal\xtc\XtendedContent\Serve\XtcRequest;


use Drupal\xtc\XtendedContent\Serve\Client\HttpClient;

class GuzzleXtcRequest extends AbstractXtcRequest
{
  protected function buildClient(){
    if(isset($this->profile)){
      $this->client = new HttpClient($this->profile);
    }
    $this->client->setXtcConfigFromYaml();
    return $this;
  }
}
