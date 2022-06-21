<?php

namespace Drupal\custom_plugin\Plugin\CustomPlugin;

/**
 * Plugin add letters to the title.
 *
 * @CustomPlugin(
 *   id = "AddA",
 *   label = @Translation("AddA"),
 *   description = @Translation("Add A to the title")
 * )
 */
class AddA extends \Drupal\custom_plugin\CustomPluginPluginBase {

  public function title($value) {
    $changed = $this->customFunction($value);
    return $changed;

  }

  private function customFunction($value) {
    $words = explode(' ', $value);
    foreach ($words as &$word) {
      $word .= 'A';
    }
    return implode(' ', $words);
  }

}
