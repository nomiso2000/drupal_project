<?php

namespace Drupal\custom_plugin\Form;

use Drupal\Core\Entity\EntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * entity_config form.
 *
 * @property \Drupal\custom_plugin\EntityConfigInterface $entity
 */
class EntityConfigForm extends EntityForm {

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
      '#description' => $this->t('Label for the entity_config.'),
      '#required' => TRUE,
    ];

    $form['id'] = [
      '#type' => 'machine_name',
      '#default_value' => $this->entity->id(),
      '#machine_name' => [
        'exists' => '\Drupal\custom_plugin\Entity\EntityConfig::load',
      ],
      '#disabled' => !$this->entity->isNew(),
    ];

    $form['type'] = [
      '#type' =>'select',
      '#title' => $this->t('Choose type of node'),
      '#options' => node_type_get_names(),
    ];
    $options = [];
    /** @var \Drupal\custom_plugin\CustomPluginPluginManager $manager */
    $manager = \Drupal::service('plugin.manager.custom_plugin');
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
      ? $this->t('Created new entity_config %label.', $message_args)
      : $this->t('Updated entity_config %label.', $message_args);
    $this->messenger()->addStatus($message);
    $form_state->setRedirectUrl($this->entity->toUrl('collection'));
    return $result;
  }

}
