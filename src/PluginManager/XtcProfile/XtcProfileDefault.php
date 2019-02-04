<?php

namespace Drupal\xtc\PluginManager\XtcProfile;

use Drupal\Core\Plugin\PluginBase;

/**
 * Default class used for xtc_profiles plugins.
 */
class XtcProfileDefault extends PluginBase implements XtcProfileInterface {

  /**
   * {@inheritdoc}
   */
  public function label() {
    // The title from YAML file discovery may be a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }

}
