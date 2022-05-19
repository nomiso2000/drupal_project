<?php

namespace Drupal\ex81\Plugin\Block;

/**
 * Provides a 'My Template' block.
 *
 * @Block(
 *   id = "my_template_block",
 *   admin_label = @Translation("My Template")
 * )
 */
class MyTemplateBlock extends \Drupal\Core\Block\BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['label_display' => FALSE];
  }

  /**
   * @inheritDoc
   */
  public function build() {
    $renderable = [
      '#theme' => 'my_template',
      '#test_var' => 'test variable',
    ];

    return $renderable;
  }

}
