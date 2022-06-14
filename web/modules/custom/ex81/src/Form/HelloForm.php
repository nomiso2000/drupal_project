<?php

namespace Drupal\ex81\Form;

use Drupal\Component\Utility\Random;
use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\node\Entity\Node;
use Drupal\node\NodeInterface;
use Drupal\paragraphs\Entity\Paragraph;
use Symfony\Component\DependencyInjection\ContainerInterface;

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
    $form['number'] = [
      '#title' => $this->t('Number of entity'),
      '#type' => 'number',
      '#min' => 1,
      '#max' => 10,
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
      //      '#default_value' => 'Default value',
      //      '#disabled' => TRUE,
      '#title_display' => 'after',
      '#wrapper_attributes' => [
        'class' => ['custom_class_for_wrapper'],
      ],
      '#attributes' => [
        'class' => ['custom_class_for_input'],
        'id' => 'some_id_input',
      ],
      '#autocomplete_route_name' => 'ex81.route_with_autocomplete',
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
    // The #ajax attribute used in the temperature input element defines an ajax
    // callback that will invoke the 'updateColor' method on this form object.
    // Whenever the temperature element changes, it will invoke this callback
    // and replace the contents of the 'color_wrapper' container with the
    // results of this method call.
    $form['temperature'] = [
      '#title' => $this->t('Temperature'),
      '#type' => 'select',
      '#options' => range(0, 4),
      '#empty_option' => $this->t('- Select a color temperature -'),
      '#ajax' => [
        // Could also use [get_class($this), 'updateColor'].
        'callback' => '::updateColor',
        'wrapper' => 'color-wrapper',
      ],
    ];

    // Add a wrapper that can be replaced with new HTML by the ajax callback.
    // This is given the ID that was passed to the ajax callback in the '#ajax'
    // element above.
    $form['color_wrapper'] = [
      '#type' => 'container',
      '#attributes' => ['id' => 'color-wrapper'],
    ];
    $temperature = $form_state->getValue('temperature');
    if (!empty($temperature)) {
      $form['color_wrapper']['color'] = [
        '#type' => 'select',
        '#title' => $this->t('Color'),
        '#options' => range(5, 10),
      ];
    }


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
    $form['images'] = [
      '#type' => 'managed_file',
      '#multiple' => TRUE,
      '#title' => $this->t('Imagefile'),
      '#upload_location' => 'private://images/',
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
    $form['#attached']['library'][] = 'ex81/custom';
    return $form;
  }

  public function validateForm(array &$form, FormStateInterface $form_state) {
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
    $number = $form_state->getValue('number');
    $params = [
      'type' => 'news',
      'title' => $form_state->getValue('title'),
      'body' => $form_state->getValue('body'),
    ];
    $operations = [];
    foreach (range(1, $number) as $i) {
      $arg = $params;
      $arg['title'] .= ' - ' . $i;
      $operations[] = ['\Drupal\ex81\Form\HelloForm::createNode', [$arg]];
    }
    batch_set([
      'title' => $this->t('Node creation'),
      'operations' => $operations,
    ]);

    $createNode = Node::create([
      'type' => 'news',
      'title' => $form_state->getValue('title'),
      'body' => $form_state->getValue('body'),
      'field_category' => $form_state->getValue('category'),
      'uid' => \Drupal::currentUser()->id(),
    ]);
    $createNode->setUnpublished();
    $createNode->save();
    //////////////////////////////////////////////
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

  /**
   * Ajax callback for the color dropdown.
   */
  public function updateColor(array $form, FormStateInterface $form_state) {
    return $form['color_wrapper'];
  }

  public static function createNode(array $params) {
    $node = Node::create($params);
    $node->save();
    \Drupal::messenger()->addStatus('Node added');
  }


}
