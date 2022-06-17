<?php

namespace Drupal\custom_plugin;

use Drupal\Core\Cache\CacheBackendInterface;
use Drupal\Core\Extension\ModuleHandlerInterface;
use Drupal\Core\Plugin\DefaultPluginManager;

/**
 * CustomPlugin plugin manager.
 */
class CustomPluginPluginManager extends DefaultPluginManager {

  /**
   * Constructs CustomPluginPluginManager object.
   *
   * @param \Traversable $namespaces
   *   An object that implements \Traversable which contains the root paths
   *   keyed by the corresponding namespace to look for plugin implementations.
   * @param \Drupal\Core\Cache\CacheBackendInterface $cache_backend
   *   Cache backend instance to use.
   * @param \Drupal\Core\Extension\ModuleHandlerInterface $module_handler
   *   The module handler to invoke the alter hook with.
   */
  public function __construct(\Traversable $namespaces, CacheBackendInterface $cache_backend, ModuleHandlerInterface $module_handler) {
    parent::__construct(
      'Plugin/CustomPlugin',
      $namespaces,
      $module_handler,
      'Drupal\custom_plugin\CustomPluginInterface',
      'Drupal\custom_plugin\Annotation\CustomPlugin'
    );
    $this->alterInfo('custom_plugin_info');
    $this->setCacheBackend($cache_backend, 'custom_plugin_plugins');
  }

  /**
   *  -> subdir 'Plugin/CustomPlugin' - вказує де шукати наш плагін
   *  -> $module_handle - вказує де шукати ( в нашому випадку в модулях), такoж
   * можна шукати в theme_handler або і там і там
   * ->'Drupal\custom_plugin\CustomPluginInterface' інтерфейс який наслідує наш
   * плагін Там вказуєм методи, які надаватиме наш плагін
   * -> 'Drupal\custom_plugin\Annotation\CustomPlugin' вказує на анотацію
   * плагіна
   * ->  $this->alterInfo('custom_plugin_info');  -дозволяє заальтерити список
   * плагінів function add_letters_service_info_alter(&$definitions)
   *
   */

}
