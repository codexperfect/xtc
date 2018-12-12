<?php

namespace Drupal\xtc\PluginManager\XtcHandler;

/**
 * Interface for xtc_handler plugins.
 */
interface XtcHandlerInterface
{

  /**
   * Returns the translated plugin label.
   *
   * @return string
   *   The translated title.
   */
  public function label();

}
