<?php

namespace Drupal\ex81\Form;

use Drupal\Core\Form\FormStateInterface;

class SwitchThemeForm extends \Drupal\Core\Form\ConfigFormBase {

  /**
   * @inheritDoc
   */
  protected function getEditableConfigNames() {
    return ['ex81.switch_theme'];
  }


  /**
   * @inheritDoc
   */
  public function getFormId() {
    return 'switch_theme_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('ex81.switch_theme');
    $form['settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Switch Theme Form'),
      '#open' => TRUE,
    ];
    $form['settings']['theme'] = [
      '#type' => 'radios',
      '#title' => $this->t('Theme selection'),
      '#options' => [
        'light' => $this->t('Light'),
        'dark' => $this->t('Dark'),
      ],
      '#default_value' => $config->get('theme'),
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save configuration'),
      '#button_type' => 'primary',
    ];
    return parent::buildForm($form, $form_state);
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('ex81.switch_theme')
      ->set('theme', $form_state->getValue('theme'))
      ->save();

    parent::submitForm($form, $form_state);
  }


}
