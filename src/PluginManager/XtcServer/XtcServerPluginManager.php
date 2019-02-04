<?php

namespace Drupal\xtc\PluginManager\XtcServer;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Plugin\Discovery\YamlDiscovery;
use Drupal\Core\Plugin\Factory\ContainerFactory;

/**
 * Defines a plugin manager to deal with xtc_servers.
 *
 * Modules can define xtc_servers in a MODULE_NAME.xtc_servers.yml file contained
 * in the module's base directory. Each xtc_server has the following structure:
 *
 * @code
 *   MACHINE_NAME:
 *     label: STRING
 *     description: STRING
 * @endcode
 *
 * @see \Drupal\xtc\PluginManager\XtcServer\XtcServerDefault
 * @see \Drupal\xtc\PluginManager\XtcServer\XtcServerInterface
 * @see plugin_api
 */
class XtcServerPluginManager extends DefaultPluginManager {

  /**
   * {@inheritdoc}
   */
  protected $defaults = [
    // The xtc_server id. Set by the plugin system based on the top-level YAML key.
    'id' => '',
    // The xtc_server label.
    'label' => '',
    // The xtc_server description.
    'description' => '',
    // Default plugin class.
    'class' => 'Drupal\xtc\PluginManager\XtcServer\XtcServerDefault',
  ];

  /**
   * Constructs XtcServerPluginManager object.
   *
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   */
  public function __construct(ModuleHandlerInterface $module_handler, CacheBackendInterface $cache_backend) {
    $this->factory = new ContainerFactory($this);
    $this->moduleHandler = $module_handler;
    $this->alterInfo('xtc_server_info');
    $this->setCacheBackend($cache_backend, 'xtc_server_plugins');
  }

  /**
   * {@inheritdoc}
   */
  protected function getDiscovery() {
    if (!isset($this->discovery)) {
      $this->discovery = new YamlDiscovery('xtc_servers', $this->moduleHandler->getModuleDirectories());
      $this->discovery->addTranslatableProperty('label', 'label_context');
      $this->discovery->addTranslatableProperty('description', 'description_context');
    }
    return $this->discovery;
  }

}
