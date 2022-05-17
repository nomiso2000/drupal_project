<?php

namespace Drupal\ex81\Form;

use Drupal\Component\Utility\Random;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;

//FORM ELEMENTS Render/Element/  @annotationFormElement
//class FormElement - contains all additional fields
//NodeForm - contains a lot of elements
//VerticalTabs - also contains a lot of elements (used in edit Content Types)

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
    $form['container'] = [
      '#title' => $this->t('Container with title'),
      '#type' => 'fieldset',
    ];

    $form['container']['header'] = [
      '#type' => 'html_tag',
      '#tag' => 'h2',
      '#value' => $this->t('Header'),
      '#attributes' => [
        'class' => ['first', 'second'],
        'id' => 'some_id',
      ],
    ];
    $form['container']['description'] = [
      '#type' => 'item',
      '#markup' => $this->t('Please enter the title and accept the terms of use of the site.'),
    ];
    $form['container']['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#description' => $this->t('Enter the title of the book. Note that the title must be at least 10 characters in length.'),
      '#required' => TRUE,
      '#prefix' => $this->t('Some uniq title'),
      "#size" => 15,
      '#default_value' => 'Default value',
      //      '#disabled' => TRUE,
      '#title_display' => 'after',
      '#wrapper_attributes' => [
        'class' => ['custom_class_for_wrapper'],
      ],
      '#attributes' => [
        'class' => ['custom_class_for_input'],
        'id' => 'some_id_input',
      ],
    ];
    //    if ($form_state->has('text_len')) {
    //      $text_len = $form_state->get('text_len');
    //      $form['container']['title']['#suffix'] = $this->t('Your title len now is ', ['%len' => $text_len]);
    //    }
    $form['container']['group'] = [
      '#title' => $this->t('Group'),
      '#type' => 'details',
      '#open' => TRUE,
    ];
    $form['container']['group']['accept'] = [
      '#type' => 'checkbox',
      '#title' => $this
        ->t('I accept the terms of use of the site'),
      '#description' => $this->t('Please read and accept the terms of use'),
    ];
    $form['container']['group']['body'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Content'),
      '#default_value' => (new Random())->paragraphs(),

    ];
    $form['container']['category'] = [
      '#type' => 'select',
      '#title' => $this->t('Category'),
      '#options' => $cats,
    ];

    $form['actions'] = [
      '#type' => 'actions',
    ];

    // Add a submit button that handles the submission of the form.
    $form['actions']['submit'] = [
      '#type' => 'submit',
      '#value' => $this->t('Submit'),
    ];
    $form['actions']['preview'] = [
      '#type' => 'submit',
      '#value' => $this->t('Preview'),
    ];
    //    $form['submit'] = [
    //      '#type' => 'submit',
    //      '#value' => $this->t('Submit'),
    //    ];
    $form['information'] = [
      '#type' => 'vertical_tabs',
      '#default_tab' => 'edit-publication',
    ];

    $form['author'] = [
      '#type' => 'details',
      '#title' => $this->t('Author'),
      '#group' => 'information',
    ];

    $form['author']['name'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Name'),
    ];

    $form['publication'] = [
      '#type' => 'details',
      '#title' => $this->t('Publication'),
      '#group' => 'information',
    ];

    $form['publication']['publisher'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Publisher'),
    ];

    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
    xdebug_break();
    parent::validateForm($form, $form_state);

    $title = $form_state->getValue('title');
    $accept = $form_state->getValue('accept');
    $body = $form_state->getValue('body');

    if (strlen($title) < 10) {
      $form_state->setErrorByName('title', $this->t('The title must be at least 10 characters long'));
      //      $form_state->set('text_len', strlen($title));
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
    //    class Node route_provider
    //    class NodeRouteProvider
    $form_state->setRedirect('entity.node.canonical', ['node' => $createNode->id()]);
    // Display the results.

    // Call the Static Service Container wrapper
    // We should inject the messenger service, but its beyond the scope of this example.
    $messenger = \Drupal::messenger();
    $messenger->addMessage('News with id ' . $createNode->id() . ' was created and now waiting for publishing');

    // Redirect to home
    //  $form_state->setRedirect('<front>');
    //    $form_state->setRedirect('example_route_news');


  }

}
