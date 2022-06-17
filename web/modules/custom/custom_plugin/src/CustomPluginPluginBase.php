<?php

namespace Drupal\custom_plugin;

use Drupal\Component\Plugin\PluginBase;

/**
 * Base class for custom_plugin plugins.
 */
abstract class CustomPluginPluginBase extends PluginBase implements CustomPluginInterface {

  /**
   * {@inheritdoc}
   */
  public function label() {
    // Cast the label to a string since it is a TranslatableMarkup object.
    return (string) $this->pluginDefinition['label'];
  }

}
