<?php

namespace Drupal\xtc\PluginManager\XtcHandler;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for xtc_handler plugins.
 */
abstract class XtcHandlerPluginBase extends PluginBase implements XtcHandlerInterface {

  /**
   * {@inheritdoc}
   */
  public function label() {
    // Cast the label to a string since it is a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }

}
