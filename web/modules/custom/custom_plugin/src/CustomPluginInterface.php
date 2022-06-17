<?php

namespace Drupal\custom_plugin;

/**
 * Interface for custom_plugin plugins.
 */
interface CustomPluginInterface {

  /**
   * Returns the translated plugin label.
   *
   * @return string
   *   The translated title.
   */
  public function label();

  public function title($value);

}
