<?php

namespace Drupal\ex81\Form;

use Drupal\Core\Form\FormStateInterface;

class ListOfSubWeb extends \Drupal\Core\Form\FormBase {

  /**
   * @inheritDoc
   */
  public function getFormId() {
    return 'ex81_ListOfWeb_form';
  }

  /**
   * @inheritDoc
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    $current_user = \Drupal::currentUser();
    $user_id = $current_user->id();
    $query = \Drupal::entityQuery('webform_submission')
      ->condition('webform_id', 'feedback')
      ->accessCheck(FALSE)
      ->execute();
    $webforms = [];
    foreach ($query as $item) {
      $submission = \Drupal\webform\Entity\WebformSubmission::load($item);
      if ($submission->getElementData('author_id') == $user_id) {
        $webforms[] = $submission;
      }
    }
    $output = [];
    foreach ($webforms as $item) {
      $output[$item->id()] = [
        'phone' => $item->getElementData('phone_number'),
        'email' => $item->getElementData('your_email'),
        'name' => $item->getElementData('your_name')['first'],
      ];
    }
    $header = [
      'phone' => $this->t('Phone number'),
      'email' => $this->t('User email'),
      'name' => $this->t('User name'),
    ];
    $form['table'] = [
      '#type' => 'tableselect',
      '#header' => $header,
      '#options' => $output,
      '#empty' => t('You have no suggestions'),
    ];
    $form['actions'] = [
      '#type' => 'actions',
    ];

    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Delete items'),
    ];

    return $form;
  }

  /**
   * @inheritDoc
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $webFormIds = array_keys($form['table']['#options']);
    $operations = [];
    foreach ($webFormIds as $id) {
      $operations[] = ['\Drupal\ex81\Form\ListOfSubWeb::deleteForms', [$id]];
    }
    batch_set([
      'title' => $this->t('Delete forms'),
      'operations' => $operations,
    ]);
  }

  public static function deleteForms($id) {
    \Drupal\webform\Entity\WebformSubmission::load($id)->delete();
    \Drupal::messenger()->addStatus('Form deleted');
  }

}




