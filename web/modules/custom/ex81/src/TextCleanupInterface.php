<?php

namespace Drupal\ex81;

/**
 * Interface for text_cleanup plugins.
 */
interface TextCleanupInterface {

  /**
   * Returns the translated plugin label.
   *
   * @return string
   *   The translated title.
   */
  public function label();

  /**
   * Clean up the text
   *
   * @param string $text
   * Target text.
   *
   * @return string
   * Resulted cleaned
   */
  public function cleanUp(string $text): string;

}
