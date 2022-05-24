<?php

namespace Drupal\ex81\Plugin\TextCleanup;

use Drupal\ex81\TextCleanupPluginBase;

/**
 * Plugin implementation of the text_cleanup.
 *
 * @TextCleanup(
 *   id = "uc_first",
 *   label = @Translation("UC first"),
 *   description = @Translation("UC first")
 * )
 */
class UcFirst extends TextCleanupPluginBase {

  /**
   * @inheritdoc
   */
  public function cleanUp(string $text): string {
    $lines = explode("\n", $text);
    foreach ($lines as &$line) {
      $line = ucfirst($line);
    }
    return implode('\n', $lines);
  }

}
