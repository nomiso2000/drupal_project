<?php

namespace Drupal\custommodule\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\Core\Session\AccountInterface;

/**
 * Displays block
 *
 * @Block (
 *  id = "custommodule_first_block_block",
 *  admin_label = @Translation("My first block"),
 * )
 */
class FirstBlock extends BlockBase {

  /**
   * {@inheritDoc}
   */
  public function build() {
    $config = $this->getConfiguration();
    if (!empty($config['custommodule_first_block_settings'])) {
      $text = $this->t('Hello @name in block!', ['@name' => $config['custommodule_first_block_settings']]);
    }
    else {
      $text = $this->t('Hello world in block');
    }
    return [
      '#markup' => $text,
    ];
  }
  /**
   * {@inheritDoc}
   */
  //  protected function blockAccess(AccountInterface $account) {
  //    return AccessResult::allowedIfHasPermission($account, 'access content');
  //  }
  //
  //  /**
  //   * {@inheritDoc}
  //   */
  //  public function blockForm($form, FormStateInterface $form_state) {
  //    $config = $this->getConfiguration();
  //    $form ['custommodule_first_block_settings'] = [
  //      '#type' => 'textfield',
  //      '#title' => $this->t('Name'),
  //      '#description' => $this->t('Who do you want to say hello to?'),
  //      '#default_value' => !empty($config['custommodule_first_block_settings']) ? $config['custommodule_first_block_settings'] : '',
  //    ];
  //    return $form;
  //  }
  //   /**
  //   * {@inheritDoc}
  //   */
  //  public function blockSubmit($form, FormStateInterface $form_state) {
  //    $this->configuration['custommodule_first_block_settings'] = $form_state->getValue('custommodule_first_block_settings');
  //  }

}
