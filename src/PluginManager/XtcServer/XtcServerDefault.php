<?php

namespace Drupal\xtc\PluginManager\XtcServer;

use Drupal\Core\Plugin\PluginBase;

/**
 * Default class used for xtc_servers plugins.
 */
class XtcServerDefault extends PluginBase implements XtcServerInterface {

  /**
   * {@inheritdoc}
   */
  public function label() {
    // The title from YAML file discovery may be a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }

}
