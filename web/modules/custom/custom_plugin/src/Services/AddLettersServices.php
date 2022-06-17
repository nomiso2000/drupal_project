<?php

namespace Drupal\custom_plugin\Services;

use Drupal\Core\Config\ConfigFactoryInterface;
use \Drupal\custom_plugin\CustomPluginPluginManager;

class AddLettersServices {

  private CustomPluginPluginManager $manager;

  private ConfigFactoryInterface $config;

  public function __construct(CustomPluginPluginManager $manager, ConfigFactoryInterface $config) {
    $this->manager = $manager;
    $this->config = $config;
  }

  public function title($value) {
    $pluginDefinitions = $this->manager->getDefinitions();
    $enabledPlugins = $this->config->get('custom_plugin.settings')
      ->get('plugins');
    foreach (array_filter($enabledPlugins) as $pluginId) {
      /** @var \Drupal\custom_plugin\CustomPluginInterface $plugin */
      $plugin = $this->manager->createInstance($pluginId, $pluginDefinitions[$pluginId]);
      $value = $plugin->title($value);
    }

    return $value;
  }

}
