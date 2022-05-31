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
    $nodeIds = $storage->getQuery()->condition('type', 'news')->execute();
    $nodes = $storage->loadMultiple($nodeIds);
    $output = [];
    foreach ($nodes as $node) {
      $output[] = [
        'title' => $node->get('title')->value,
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
    $selected = $form_state->getValue('table');
    $selectedIds = [];
    $operations = [];
    foreach ($selected as $nid) {
      if (is_string($nid)) {
        $selectedIds[] = $nid;
        $operations[] = [
          '\Drupal\ex81\Form\ListOfNews::toArchive',
          [$selectedIds],
        ];
      }
    }
    batch_set([
      'title' => $this->t('Archive selected News'),
      'operations' => $operations,
    ]);
    //    foreach (range(1, $number) as $i) {
    //      $operations[] = ['\Drupal\ex81\Form\ListOfNews::createNode', [$arg]];
  }

  public static function toArchive($params) {
    $nodeStorage = \Drupal::entityTypeManager()->getStorage('node');
    $node = $nodeStorage->load($params[0]);
    $node->set('field_archive', 1);
    $node->save();
  }


}




