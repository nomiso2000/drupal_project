<?php

namespace Drupal\ex81\Services;

use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\ex81\TextCleanupPluginManager;

class TextCleanupServices {

  /** @var \Drupal\ex81\TextCleanupPluginManager */
  private TextCleanupPluginManager $manager;

  /**
   * @var \Drupal\Core\Config\ConfigFactoryInterface
   */
  private ConfigFactoryInterface $config;

  public function __construct(TextCleanupPluginManager $manager, ConfigFactoryInterface $config) {
    $this->manager = $manager;
    $this->config = $config;
  }

  /**
   *Clean up the text
   *
   * @param string $text
   *
   * @return string
   * @throw \Drupal\Component\Plugin\Exception\PluginException
   *
   */
  public function cleanUp(string $text): string {
    $pluginDefinitions = $this->manager->getDefinitions();
    $enabledPlugins = $this->config->get('ex81.text_cleanup.settings')
      ->get('plugins');
    if ($enabledPlugins) {
      foreach (array_filter($enabledPlugins) as $pluginId) {
        /** @var \Drupal\ex81\TextCleanupInterface $plugin */
        $plugin = $this->manager->createInstance($pluginId, $pluginDefinitions[$pluginId]);
        $text = $plugin->cleanUp($text);
      }
    }

    return $text;
  }

  //  public function addDots(string $text) {
  //    $lines = explode("\r\n", $text);
  //    foreach ($lines as $line) {
  //      if (!str_ends_with($line, '.')) {
  //        $line = $line . '.';
  //      }
  //    }
  //    return implode("\r\n", $lines);
  //  }
  //
  //  public function ucFirst(string $text) {
  //    $lines = explode("\n", $text);
  //    xdebug_break();
  //    foreach ($lines as $line) {
  //
  //      $line = ucfirst($line);
  //
  //    }
  //    return implode('\n', $lines);
  //  }

}
