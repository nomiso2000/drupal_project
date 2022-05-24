<?php

namespace Drupal\ex81\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * OptionsDefaultFormatter.php
 *
 * @FieldFormatter(
 *   id = "test_list",
 *   label = @Translation("Test List"),
 *   field_types = {
 *     "list_integer",
 *     "list_float",
 *     "list_string",
 *   }
 * )
 */
class TestListFormatter extends FormatterBase {


  public function viewElements(FieldItemListInterface $items, $langcode) {
    $output = [];
    foreach ($items as $item) {
      $output[] = ['#markup' => $item->value];
    }
    return $output;
    //    return [
    //      '#markup' => 'Test values for firld' . $items->getFieldDefinition()
    //          ->getName(),
    //    ];
  }

}
