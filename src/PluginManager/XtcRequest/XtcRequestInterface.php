<?php

namespace Drupal\xtc\PluginManager\XtcRequest;

/**
 * Interface for xtc_request plugins.
 */
interface XtcRequestInterface {

  /**
   * Returns the translated plugin label.
   *
   * @return string
   *   The translated title.
   */
  public function label();

}
