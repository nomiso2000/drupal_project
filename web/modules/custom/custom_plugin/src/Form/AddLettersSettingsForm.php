<?php

namespace Drupal\custom_plugin\Form;

use Drupal\Core\Form\ConfigFormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Configure custom_plugin settings for this site.
 */
class AddLettersSettingsForm extends ConfigFormBase {

  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'custom_plugin_add_letters_settings';
  }

  /**
   * {@inheritdoc}
   */
  protected function getEditableConfigNames() {
    return ['custom_plugin.settings'];
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $options = [];
    /** @var \Drupal\custom_plugin\CustomPluginPluginManager $manager */
    $manager = \Drupal::service('plugin.manager.custom_plugin');
    foreach ($manager->getDefinitions() as $pluginId => $pluginDefinition) {
      $options[$pluginId] = $pluginDefinition['label'];
    }
    $form['plugins'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Plugins'),
      '#default_value' => $this->config('custom_plugin.settings')
        ->get('plugins'),
      '#options' => $options,
    ];
    return parent::buildForm($form, $form_state);
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('custom_plugin.settings')
      ->set('plugins', $form_state->getValue('plugins'))
      ->save();
    parent::submitForm($form, $form_state);
  }

}
