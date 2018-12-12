<?php

namespace Drupal\xtc\PluginManager\XtcHandler;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\xtc\XtendedContent\Serve\Client\ClientInterface;

/**
 * Base class for xtc_handler plugins.
 */
abstract class XtcHandlerPluginBase extends PluginBase
  implements XtcHandlerInterface, PluginInspectionInterface
{

  /**
   * @var string
   */
  protected $method;

  /**
   * @var string
   */
  protected $param;

  /**
   * @var string
   */
  protected $content;

  /**
   * @var array
   */
  protected $profile = [];

  /**
   * {@inheritdoc}
   */
  public function label() {
    // Cast the label to a string since it is a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }


  public function get() {
    if(method_exists($this, $this->method)){
      $getMethod = $this->method;
      $this->${"getMethod"}();
    }
    return $this->content;
  }

  /**
   * @param string $method
   * @param string $param
   *
   * @return ClientInterface
   */
  public function init($method, $param = '') : ClientInterface{
    $this->method = $method;
    $this->param = $param;
    return $this;
  }

  protected function getContent(){
    if(file_exists($this->options['path'])){
      $this->content = file_get_contents($this->options['path']);
    }
  }

  public function setProfile(array $profile){
    $this->profile = $profile;
  }

}
