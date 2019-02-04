<?php

namespace Drupal\xtc\PluginManager\XtcProfile;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Plugin\Discovery\YamlDiscovery;
use Drupal\Core\Plugin\Factory\ContainerFactory;

/**
 * Defines a plugin manager to deal with xtc_profiles.
 *
 * Modules can define xtc_profiles in a MODULE_NAME.xtc_profiles.yml file contained
 * in the module's base directory. Each xtc_profile has the following structure:
 *
 * @code
 *   MACHINE_NAME:
 *     label: STRING
 *     description: STRING
 * @endcode
 *
 * @see \Drupal\xtc\PluginManager\XtcProfile\XtcProfileDefault
 * @see \Drupal\xtc\PluginManager\XtcProfile\XtcProfileInterface
 * @see plugin_api
 */
class XtcProfilePluginManager extends DefaultPluginManager {

  /**
   * {@inheritdoc}
   */
  protected $defaults = [
    // The xtc_profile id. Set by the plugin system based on the top-level YAML key.
    'id' => '',
    // The xtc_profile label.
    'label' => '',
    // The xtc_profile description.
    'description' => '',
    // Default plugin class.
    'class' => 'Drupal\xtc\PluginManager\XtcProfile\XtcProfileDefault',
  ];

  /**
   * Constructs XtcProfilePluginManager object.
   *
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   */
  public function __construct(ModuleHandlerInterface $module_handler, CacheBackendInterface $cache_backend) {
    $this->factory = new ContainerFactory($this);
    $this->moduleHandler = $module_handler;
    $this->alterInfo('xtc_profile_info');
    $this->setCacheBackend($cache_backend, 'xtc_profile_plugins');
  }

  /**
   * {@inheritdoc}
   */
  protected function getDiscovery() {
    if (!isset($this->discovery)) {
      $this->discovery = new YamlDiscovery('xtc_profiles', $this->moduleHandler->getModuleDirectories());
      $this->discovery->addTranslatableProperty('label', 'label_context');
      $this->discovery->addTranslatableProperty('description', 'description_context');
    }
    return $this->discovery;
  }

}
