<?php

namespace Drupal\ex81\Services;

use Drupal;
use Drupal\Core\Config\ConfigFactoryInterface;
use Drupal\Core\Entity\FieldableEntityInterface;
use Drupal\ex81\TextCleanupPluginManager;
use Drupal\paragraphs\Plugin\migrate\source\d7\FieldableEntity;

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

  public function cleanUpEntity(FieldableEntityInterface $entity) {
    $storage = Drupal::entityTypeManager()->getStorage('ex81');
    $configs = $storage->loadByProperties(['type' => $entity->bundle()]);
    if (empty($configs)) {
      return;
    }
    /** @var Drupal\ex81\Entity\Ex81 $config */
    $config = reset($configs);
    $plugins = $config->getPlugins();
    $pluginDefinitions = $this->manager->getDefinitions();
    foreach ($entity->getFields() as $field) {
      if ($field->getName() === 'field_plain_text') {
        $value = $entity->get($field->getName())->value;
        foreach (array_filter($plugins) as $pluginId) {
          /** @var Drupal\ex81\TextCleanupInterface $plugin */
          $plugin = $this->manager->createInstance($pluginId, $pluginDefinitions[$pluginId]);
          $value = $plugin->cleanUp($value);
        }
        $entity->set($field->getName(), $value);
      }
    }
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
