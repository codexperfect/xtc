<?php

namespace Drupal\xtc\PluginManager\XtcHandler;

use Drupal\Component\Plugin\PluginBase;
use Drupal\Component\Plugin\PluginInspectionInterface;

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
   * @var array
   */
  protected $options = [];

  /**
   * {@inheritdoc}
   */
  public function label() {
    // Cast the label to a string since it is a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }

  public function create() {
  }

  public function set() {
  }

  public function process() {
    if(method_exists($this, $this->method)){
      $getMethod = $this->method;
      $this->${"getMethod"}();
    }
    return $this;
  }

  public function update() {
  }

  public function delete() {
  }

  public function search() {
    return $this->process();
  }

  public function content() {
    return $this->content ?? null;
  }

  public function values() {
    return $this->content['values'] ?? null;
  }

  public function getContent() {
    return $this->process()
                ->content();
  }

  public function getValues() {
    return $this->process()
                ->values();
  }

  public function searchContent() {
    return $this->search()
                ->content();
  }

  public function searchValues() {
    return $this->search()
                ->values();
  }

  public function setProfile(array $profile) : XtcHandlerPluginBase{
    $this->profile = $profile;
    return $this;
  }

  /**
   * @param        $method
   * @param string $param
   *
   * @return \Drupal\xtc\PluginManager\XtcHandler\XtcHandlerPluginBase
   */
  public function init($method, $param = '') : XtcHandlerPluginBase{
    $this->method = $method;
    $this->param = $param;
    return $this;
  }

}
