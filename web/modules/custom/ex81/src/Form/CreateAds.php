<?php

namespace Drupal\ex81\Form;

use Drupal\Component\Utility\Random;
use Drupal\Core\Form\FormStateInterface;
use Drupal\file\Entity\File;
use Drupal\node\Entity\Node;
use Drupal\paragraphs\Entity\Paragraph;

class CreateAds extends \Drupal\Core\Form\FormBase {

  /**
   * @inheritDoc
   */
  public function getFormId() {
    return 'ex81_create_ads';
  }

  /**
   * @inheritDoc
   */
  public function buildForm(array $form, FormStateInterface $form_state) {

    $cities = $this->getTaxTerm('city');
    $rooms = $this->getTaxTerm('kimnat');
    $form['title'] = [
      '#type' => 'textfield',
      '#title' => $this->t('Title'),
      '#description' => $this->t('The title of ads'),
      '#required' => TRUE,
      //      "#size" => 15,
      //      '#title_display' => 'after',
      '#wrapper_attributes' => [
        'class' => ['custom_class_for_wrapper'],
      ],
      '#attributes' => [
        'class' => ['custom_class_for_input'],
        'id' => 'some_id_input',
      ],
      '#autocomplete_route_name' => 'ex81.route_with_autocomplete',
    ];
    $form['images'] = [
      '#type' => 'managed_file',
      '#multiple' => TRUE,
      '#title' => $this->t('Imagefile'),
      '#upload_location' => 'private://images/',
      '#required' => TRUE,
      //      '#upload_location' => 'public://images/redaktion/',
      //      '#default_value' => $this->configuration['imagefile'],
    ];
    $form['flat_description'] = [
      '#type' => 'text_format',
      '#title' => $this->t('Content'),
      '#default_value' => (new Random())->paragraphs(1),
    ];
    $form['price'] = [
      '#title' => $this->t('The price of the monthly payment for the apartment'),
      '#type' => 'number',
      '#min' => 1,
      '#required' => TRUE,
    ];
    $form['cities'] = [
      '#type' => 'select',
      '#title' => $this->t('Choose city where flat located'),
      '#options' => $cities,
      '#required' => TRUE,
    ];
    $form['rooms'] = [
      '#type' => 'select',
      '#title' => $this->t('Number of rooms in the apartment'),
      '#options' => $rooms,
      '#required' => TRUE,
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
    $files = $this->createImageFiles($form_state);
    $para = $this->createParaForImageSlider($files);
    $createNode = Node::create([
      'type' => 'advertisement',
      'title' => $form_state->getValue('title'),
      'uid' => \Drupal::currentUser()->id(),
      'field_city' => $form_state->getValue('cities'),
      'field_rooms' => $form_state->getValue('rooms'),
      'field_month_price' => $form_state->getValue('price'),
      'field_flat_description' => $form_state->getValue('flat_description'),
      'field_ad_image_carrusel' => $para,
    ]);
    $createNode->save();

    $form_state->setRedirect('entity.node.canonical', ['node' => $createNode->id()]);
    $messenger = \Drupal::messenger();
    $messenger->addMessage('News with id ' . $createNode->id() . ' was created and now waiting for publishing');

  }

  public function createImageFiles(FormStateInterface $form_state) {
    $fids = $form_state->getValue('images');
    $arrOfFileDescription = [];
    foreach (File::loadMultiple($fids) as $file) {
      $file->setPermanent();
      $file->save();
      $arrOfFileDescription[] = [
        'target_id' => $file->id(),
        'alt' => 'Alt text for the image',
        'title' => 'Title for the image',
      ];
    }
    return $arrOfFileDescription;
  }

  public function createParaForImageSlider(array $fileId) {
    $paraData = [];
    foreach ($fileId as $id) {
      $paragraph = Paragraph::create([
        'type' => 'slider',
        'field_sup_image' => [
          'target_id' => $id['target_id'],
        ],
      ]);
      $paragraph->save();
      $paraData[] = [
        'target_id' => $paragraph->id(),
        'target_revision_id' => $paragraph->getRevisionId(),
      ];
    }
    return $paraData;
  }

  public function getTaxTerm(string $vocabluaryName) {
    $termStorage = \Drupal::entityTypeManager()->getStorage('taxonomy_term');
    $ids = $termStorage->getQuery()
      ->condition('vid', $vocabluaryName)
      ->execute();
    $items = [];
    foreach ($termStorage->loadMultiple($ids) as $item) {
      $items[$item->id()] = $item->label();
    }
    return $items;
  }

}
