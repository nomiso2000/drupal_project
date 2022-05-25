<?php

namespace Drupal\ex81\Plugin\Block;

/**
 * Displays block
 *
 * @Block (
 *  id = "ex81_switch_theme_block",
 *  admin_label = @Translation("Switch theme block"),
 * )
 */
class SwitchThemeBlock extends \Drupal\Core\Block\BlockBase {

  /**
   * @inheritDoc
   */
  public function build() {
    $form = \Drupal::formBuilder()
      ->getForm('\Drupal\ex81\Form\SwitchThemeForm');
    return $form;
  }

}

