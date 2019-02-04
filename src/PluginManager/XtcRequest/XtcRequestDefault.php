<?php

namespace Drupal\xtc\PluginManager\XtcRequest;

use Drupal\Core\Plugin\PluginBase;

/**
 * Default class used for xtc_requests plugins.
 */
class XtcRequestDefault extends PluginBase implements XtcRequestInterface {

  /**
   * {@inheritdoc}
   */
  public function label() {
    // The title from YAML file discovery may be a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }

}
