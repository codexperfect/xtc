<?php
/**
 * Created by PhpStorm.
 * User: dev
 * Date: 19/04/2018
 * Time: 17:21
 */

namespace Drupal\xtc\XtendedContent\Serve\XtcRequest;


class ElasticaRequest extends AbstractXtcRequest
{
  /**
   * @param $method
   * @param string $param
   *
   * @return \Drupal\Core\StringTranslation\TranslatableMarkup|mixed|string
   */
  public function get($method, $param = '')
  {
    // @TODO: Do it the ES way.
    if ($this->isAllowed($method)){
      try {
        $this->getClient()->setUri($method, $param);
        $content = $this->getClient()->get();
        $this->setData($content);
        return $this;
      } catch (RequestException $e) {
        return ('Request error: ' . $e->getMessage());
      }
    }
    else{
      return (t('Request error: The "'.$method.'" method is not allowed.'));
    }
  }
}
