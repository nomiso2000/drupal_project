<?php

namespace Drupal\ex81\Plugin\Field\FieldFormatter;

use Drupal\Core\Field\FieldItemListInterface;
use Drupal\Core\Field\FormatterBase;

/**
 * Plugin implementation of the 'youtube_link' formatter.
 *
 * @FieldFormatter(
 *   id = "youtube_link",
 *   label = @Translation("YouTube Formatter"),
 *   field_types = {
 *     "link"
 *   }
 * )
 */
class YouTubeLinkFormatter extends FormatterBase {

  /**
   * Builds a renderable array for a field value.
   *
   * @param \Drupal\Core\Field\FieldItemListInterface $items
   *   The field values to be rendered.
   * @param string $langcode
   *   The language that should be used to render the field.
   *
   * @return array
   *   A renderable array for $items, as an array of child elements keyed by
   *   consecutive numeric indexes starting from 0.
   */
  public function viewElements(FieldItemListInterface $items, $langcode) {
    $elements = [];

    foreach ($items as $delta => $item) {
      $url = $item->getUrl();
      $elements[$delta] = [
        '#theme' => 'youtube_link_formatter',
        '#url' => $url,
      ];
    }

    return $elements;
  }

}
