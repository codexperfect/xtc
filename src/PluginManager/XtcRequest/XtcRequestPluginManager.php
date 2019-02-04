<?php

namespace Drupal\xtc\PluginManager\XtcRequest;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;
use Drupal\Core\Plugin\Discovery\YamlDiscovery;
use Drupal\Core\Plugin\Factory\ContainerFactory;

/**
 * Defines a plugin manager to deal with xtc_requests.
 *
 * Modules can define xtc_requests in a MODULE_NAME.xtc_requests.yml file contained
 * in the module's base directory. Each xtc_request has the following structure:
 *
 * @code
 *   MACHINE_NAME:
 *     label: STRING
 *     description: STRING
 * @endcode
 *
 * @see \Drupal\xtc\PluginManager\XtcRequest\XtcRequestDefault
 * @see \Drupal\xtc\PluginManager\XtcRequest\XtcRequestInterface
 * @see plugin_api
 */
class XtcRequestPluginManager extends DefaultPluginManager {

  /**
   * {@inheritdoc}
   */
  protected $defaults = [
    // The xtc_request id. Set by the plugin system based on the top-level YAML key.
    'id' => '',
    // The xtc_request label.
    'label' => '',
    // The xtc_request description.
    'description' => '',
    // Default plugin class.
    'class' => 'Drupal\xtc\PluginManager\XtcRequest\XtcRequestDefault',
  ];

  /**
   * Constructs XtcRequestPluginManager object.
   *
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   */
  public function __construct(ModuleHandlerInterface $module_handler, CacheBackendInterface $cache_backend) {
    $this->factory = new ContainerFactory($this);
    $this->moduleHandler = $module_handler;
    $this->alterInfo('xtc_request_info');
    $this->setCacheBackend($cache_backend, 'xtc_request_plugins');
  }

  /**
   * {@inheritdoc}
   */
  protected function getDiscovery() {
    if (!isset($this->discovery)) {
      $this->discovery = new YamlDiscovery('xtc_requests', $this->moduleHandler->getModuleDirectories());
      $this->discovery->addTranslatableProperty('label', 'label_context');
      $this->discovery->addTranslatableProperty('description', 'description_context');
    }
    return $this->discovery;
  }

}
