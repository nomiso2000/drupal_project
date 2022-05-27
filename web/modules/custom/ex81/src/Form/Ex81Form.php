<?php

namespace Drupal\ex81\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * ex81 form.
 *
 * @property \Drupal\ex81\Ex81Interface $entity
 */
class Ex81Form extends EntityForm {

  /**
   * {@inheritdoc}
   */
  public function form(array $form, FormStateInterface $form_state) {

    $form = parent::form($form, $form_state);

    $form['label'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Label'),
      '#maxlength' => 255,
      '#default_value' => $this->entity->label(),
      '#description' => $this->t('Label for the ex81.'),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $this->entity->id(),
      '#machine_name' => [
        'exists' => '\Drupal\ex81\Entity\Ex81::load',
      ],
      '#disabled' => !$this->entity->isNew(),
    ];

    //    $form['status'] = [
    //      '#type' => 'checkbox',
    //      '#title' => $this->t('Enabled'),
    //      '#default_value' => $this->entity->status(),
    //    ];

    $form['text'] = [
      '#type' => 'textarea',
      '#title' => $this->t('Text'),
      '#default_value' => $this->entity->get('text'),
      '#description' => $this->t('Description of the ex81.'),
    ];
    $form['type'] = [
      '#type' => 'select',
      '#title' => $this->t('type'),
      '#default_value' => $this->entity->get('type'),
      '#options' => node_type_get_names(),
    ];
    $options = [];
    /** @var \Drupal\ex81\TextCleanupPluginManager $manager */
    $manager = \Drupal::service('plugin.manager.text_cleanup');
    foreach ($manager->getDefinitions() as $pluginId => $pluginDefinition) {
      $options[$pluginId] = $pluginDefinition['label'];
    }
    $isPluginChoosed = $this->entity->get('plugins');
    $form['plugins'] = [
      '#type' => 'checkboxes',
      '#title' => $this->t('Plugins'),
      '#default_value' => isset($isPluginChoosed) ? $isPluginChoosed : [],
      '#options' => $options,
    ];

    return $form;
  }

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);
    $message_args = ['%label' => $this->entity->label()];
    $message = $result == SAVED_NEW
      ? $this->t('Created new ex81 %label.', $message_args)
      : $this->t('Updated ex81 %label.', $message_args);
    $this->messenger()->addStatus($message);
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));
    return $result;
  }

}
