<?php

namespace Drupal\ex81\Form;

use Drupal\Core\Form\FormStateInterface;

class ListOfNews extends \Drupal\Core\Form\FormBase {

  /**
   * @inheritDoc
   */
  public function getFormId() {
    return 'ex81_ListOfNews_form';
  }

  /**
   * @inheritDoc
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $storage = \Drupal::entityTypeManager()->getStorage('node');
    $nodeIds = $storage->getQuery()
      ->condition('type', 'news')
      ->condition('field_archive', 0)
      ->execute();
    $nodes = $storage->loadMultiple($nodeIds);
    $output = [];
    foreach ($nodes as $node) {
      $output[] = [
        'id' => $node->id(),
        'title' => $node->label(),
      ];
    }
    $header = [
      'title' => $this->t('Node`s title'),
    ];
    $form['table'] = [
      '#type' => 'tableselect',
      '#header' => $header,
      '#options' => $output,
      '#empty' => t('No Node`s found'),
    ];
    $form['actions'] = [
      '#type' => 'actions',
    ];

    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * @inheritDoc
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $nodes = $form['table']['#options'];
    $selectdVariablesIds = $form_state->getValue('table');
    $i = 0;
    $operations = [];
    foreach ($nodes as $node) {
      if (is_string($selectdVariablesIds[$i])) {
        $operations[] = [
          '\Drupal\ex81\Form\ListOfNews::toArchive',
          [$node['id']],
        ];
      }
      $i++;
    }
    batch_set([
      'title' => $this->t('Archive selected News'),
      'operations' => $operations,
    ]);
  }

  public static function toArchive($params) {
    $nodeStorage = \Drupal::entityTypeManager()->getStorage('node');
    $node = $nodeStorage->load($params);
    $node->set('field_archive', 1);
    $node->save();
  }


}




