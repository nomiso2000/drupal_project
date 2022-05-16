<?php

namespace Drupal\ex81\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;

class HelloForm extends FormBase {

  public function getFormId() {
    return 'ex81_hello_form';
  }

  public function buildForm(array $form, FormStateInterface $form_state) {
    $termStorage = \Drupal::entityTypeManager()->getStorage('taxonomy_term');
    $ids = $termStorage->getQuery()
      ->condition('vid', 'category')
      ->execute();
    $cats = [];
    foreach ($termStorage->loadMultiple($ids) as $item) {
      $cats[$item->id()] = $item->label();
    }

    $form['description'] = [
      '#type' => 'item',
      '#markup' => $this->t('Please enter the title and accept the terms of use of the site.'),
    ];
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#description' => $this->t('Enter the title of the book. Note that the title must be at least 10 characters in length.'),
      '#required' => TRUE,
    ];
    $form['accept'] = [
      '#type' => 'checkbox',
      '#title' => $this
        ->t('I accept the terms of use of the site'),
      '#description' => $this->t('Please read and accept the terms of use'),
    ];
    $form['body'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Content'),

    ];
    $form['category'] = [
      '#type' => 'select',
      '#title' => $this->t('Category'),
      '#options' => $cats,
    ];

    //    $form['actions'] = [
    //      '#type' => 'actions',
    //    ];
    //
    //    // Add a submit button that handles the submission of the form.
    //    $form['actions']['submit'] = [
    //      '#type' => 'submit',
    //      '#value' => $this->t('Submit'),
    //    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    parent::validateForm($form, $form_state);

    $title = $form_state->getValue('title');
    $accept = $form_state->getValue('accept');
    $body = $form_state->getValue('body');

    if (strlen($title) < 10) {
      $form_state->setErrorByName('title', $this->t('The title must be at least 10 characters long'));
    }
    //    if (strlen($body) < 10) {
    //      $form_state->setErrorByName('body', $this->t('The body must be at least 10 characters long'));
    //    }

    if (empty($accept)) {
      $form_state->setErrorByName('accept', $this->t('You must accept the terms of use to continue'));
    }
  }

  public function submitForm(array &$form, FormStateInterface $form_state) {
    //    $storage = \Drupal::entityTypeManager()->getStorage('node');
    $createNode = Node::create([
      'type' => 'news',
      'title' => $form_state->getValue('title'),
      'body' => $form_state->getValue('body'),
      'field_category' => $form_state->getValue('category'),
      'uid' => \Drupal::currentUser()->id(),
    ]);
    $createNode->setUnpublished();
    $createNode->save();
    // Display the results.

    // Call the Static Service Container wrapper
    // We should inject the messenger service, but its beyond the scope of this example.
    $messenger = \Drupal::messenger();
    $messenger->addMessage('News with id ' . $createNode->id() . ' was created and now waiting for publishing');

    // Redirect to home
    $form_state->setRedirect('<front>');

  }

}
