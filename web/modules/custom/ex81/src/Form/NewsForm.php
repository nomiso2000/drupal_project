<?php

namespace Drupal\ex81\Form;

use Drupal\Core\Form\FormStateInterface;

class NewsForm extends \Drupal\Core\Form\ConfigFormBase {

  /**
   * @inheritDoc
   */
  protected function getEditableConfigNames() {
    // TODO: Implement getEditableConfigNames() method.
    return ['ex81.settings_news'];
  }

  /**
   * @inheritDoc
   */
  public function getFormId() {
    // TODO: Implement getFormId() method.
    return 'ex81.settings_news';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('ex81.settings_news');
    $form['settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Form Example Settings'),
      '#open' => TRUE,
    ];
    $form['settings']['sorted'] = [
      '#type' => 'radios',
      '#title' => $this->t('News sorting'),
      '#default_value' => 'created',
      '#options' => [
        'created' => $this->t('Sorted by created'),
        'changed' => $this->t('Sorted by update'),
      ],
    ];
    $form['actions']['#type'] = 'actions';
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Save configuration'),
      '#button_type' => 'primary',
    ];

    // By default, render the form using system-config-form.html.twig.
    $form['#theme'] = 'system_config_form';

    return $form;
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $config = $this->config('ex81.settings_news')
      ->set('sorted', $form_state->getValue('sorted'))
      ->save();

    parent::submitForm($form, $form_state);
  }


}
