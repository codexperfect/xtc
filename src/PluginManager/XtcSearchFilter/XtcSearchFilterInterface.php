<?php

namespace Drupal\xtc\PluginManager\XtcSearchFilter;

use Drupal\Component\Plugin\PluginInspectionInterface;
use Drupal\xtc\Form\XtcSearchFormInterface;
/**
 * Defines an interface for XTC Search Filter plugins.
 */
interface XtcSearchFilterInterface extends PluginInspectionInterface
{

  /**
   * Returns the translated plugin label.
   *
   * @return string
   *   The translated title.
   */
  function label();

  function setForm(XtcSearchFormInterface $form): void;

  function getTitle();

  function getRequest();

  function getFilter();

  function getOptions();

  function getDefault();

  function addAggregation();

}
