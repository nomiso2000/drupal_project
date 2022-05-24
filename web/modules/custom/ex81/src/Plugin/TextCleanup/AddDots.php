<?php

namespace Drupal\ex81\Plugin\TextCleanup;

use Drupal\ex81\TextCleanupPluginBase;

/**
 * Plugin implementation of the text_cleanup.
 *
 * @TextCleanup(
 *   id = "add_dots",
 *   label = @Translation("Add dots"),
 *   description = @Translation("Adding dots.")
 * )
 */
class AddDots extends TextCleanupPluginBase {

  /**
   * @inheritdoc
   */
  public function cleanUp(string $text): string {
    $lines = explode("\r\n", $text);
    foreach ($lines as &$line) {
      if (!str_ends_with($line, '.')) {
        $line .= '.';
      }
    }
    return implode("\r\n", $lines);
  }

}
