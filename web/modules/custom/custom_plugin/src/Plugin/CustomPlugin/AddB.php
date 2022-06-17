<?php

namespace Drupal\custom_plugin\Plugin\CustomPlugin;

/**
 * Plugin add letters to the title.
 *
 * @CustomPlugin(
 *   id = "AddB",
 *   label = @Translation("AddB"),
 *   description = @Translation("Add B to the title")
 * )
 */
class AddB extends \Drupal\custom_plugin\CustomPluginPluginBase {

  public function title($value) {
    $changed = $this->customFunction($value);
    return $changed;

  }

  private function customFunction($value) {
    $words = explode(' ', $value);
    foreach ($words as &$word) {
      $word .= 'B';
    }
    return implode(' ', $words);
  }


}
