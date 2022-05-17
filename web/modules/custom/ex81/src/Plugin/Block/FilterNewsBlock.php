<?php

namespace Drupal\ex81\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Displays block
 *
 * @Block (
 *  id = "ex81_news_block_block",
 *  admin_label = @Translation("Filter news block"),
 * )
 */
class FilterNewsBlock extends \Drupal\Core\Block\BlockBase {

  /**
   * @inheritDoc
   */
  public function build() {
    $form = \Drupal::formBuilder()
      ->getForm('\Drupal\ex81\Form\NewsForm');
    return $form;
  }


}
