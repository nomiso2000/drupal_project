<?php

namespace Drupal\ex81\Form;

//SiteInformationForm
use Drupal\Core\Form\FormStateInterface;

class SettingsForm extends \Drupal\Core\Form\ConfigFormBase {

  /**
   * @inheritDoc
   */
  protected function getEditableConfigNames() {
    // TODO: Implement getEditableConfigNames() method.
    return ['ex81.settings'];


  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $config = $this->config('ex81.settings');
    //    $this->configFactory()->getEditable('system.site')
    $form['enabled'] = [
      '#type' => 'checkbox',
      '#title' => $this->t('Enable Exanple Form Functions'),
      '#default_value' => $config->get('enabled'),
    ];
    $form['settings'] = [
      '#type' => 'details',
      '#title' => $this->t('Form Example Settings'),
      '#open' => TRUE,
      '#states' => [
        //FORM CONDITION
        //show this textfield only if the radio 'other' is selected above
        'visible' => [
          // Don't mistake :input for the type of field -- it's just a css selector.
          // You can always use :input or any other css selector here, no matter
          // whether your source is a select, radio or checkbox element.
          ':input[name="enabled"]' => ['checked' => TRUE],
        ],
      ],
    ];
    //    $form['settings']['enabled'] = [
    //      '#type' => 'checkbox',
    //      '#title' => $this->t('Enable Exanple Form Functions'),
    //      '#default_value' => $config->get('enabled'),
    //    ];
    $form['settings']['important_number'] = [
      '#type' => 'number',
      '#title' => $this->t('Some important number'),
      '#min' => 1,
      '#max' => 15,
      '#step' => 1,
      '#default_value' => $config->get('important_number'),
    ];
    $form['settings']['important_text'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Some text'),
      '#default_value' => $config->get('important_text'),
    ];


    return parent::buildForm($form, $form_state);
  }

  /**
   * @inheritDoc
   */
  public function getFormId() {
    // TODO: Implement getFormId() method.
    return 'ex81_example_settings';
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    $this->config('ex81.settings')
      ->set('enabled', $form_state->getValue('enabled'))
      ->set('important_number', $form_state->getValue('important_number'))
      ->set('important_text', $form_state->getValue('important_text'))
      ->save();

    parent::submitForm($form, $form_state);
    //    $this->messenger()
    //      ->addStatus($this->t('The configuration options have been saved.'));
  }

}
