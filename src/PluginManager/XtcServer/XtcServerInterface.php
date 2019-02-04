<?php

namespace Drupal\xtc\PluginManager\XtcServer;

/**
 * Interface for xtc_server plugins.
 */
interface XtcServerInterface {

  /**
   * Returns the translated plugin label.
   *
   * @return string
   *   The translated title.
   */
  public function label();

}
