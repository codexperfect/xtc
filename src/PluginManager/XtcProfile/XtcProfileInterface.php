<?php

namespace Drupal\xtc\PluginManager\XtcProfile;

/**
 * Interface for xtc_profile plugins.
 */
interface XtcProfileInterface {

  /**
   * Returns the translated plugin label.
   *
   * @return string
   *   The translated title.
   */
  public function label();

}
