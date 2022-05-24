<?php

namespace Drupal\ex81\Plugin\Block;

use Drupal\Core\Access\AccessResult;
use Drupal\Core\Block\BlockBase;
use Drupal\Core\Session\AccountInterface;

/**
 * Provides a 'My Template' block.
 *
 * @Block(
 *   id = "my_template_block",
 *   admin_label = @Translation("My Template")
 * )
 */
//class MyTemplateBlock extends \Drupal\Core\Block\BlockBase {
//
//  /**
//   * {@inheritdoc}
//   */
//  public function defaultConfiguration() {
//    return ['label_display' => FALSE];
//  }
//
//  /**
//   * @inheritDoc
//   */
//  public function build() {
//    $renderable = [
//      '#theme' => 'my_template',
//      '#test_var' => 'test variable',
//    ];
//
//    return $renderable;
//  }
//
//}
class MyTemplateBlock extends BlockBase {

  /**
   * {@inheritdoc}
   */
  public function defaultConfiguration() {
    return ['some_config' => ''];
  }

  /**
   * {@inheritdoc}
   */
  public function buildConfigurationForm(array $form, FormStateInterface|\Drupal\Core\Form\FormStateInterface $form_state) {
    $form['some_config'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Some config'),
      '#default_value' => $this->configuration['some_config'],
      '#description' => $this->t("Some text to show in block."),
      '#weight' => 50,
    ];
    return parent::buildConfigurationForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitConfigurationForm(array &$form, FormStateInterface|\Drupal\Core\Form\FormStateInterface $form_state) {
    $this->configuration['some_config'] = $form_state->getValue('some_config');
    parent::submitConfigurationForm($form, $form_state);
  }

  /**
   * @inheritDoc
   */
  public function build() {
    return ['#markup' => $this->configuration['some_config']];
  }

  protected function blockAccess(AccountInterface $account) {
    return AccessResult::allowedIfHasPermission($account, 'view custom block');
  }

}
