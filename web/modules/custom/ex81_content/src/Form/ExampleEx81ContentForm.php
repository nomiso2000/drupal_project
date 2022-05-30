<?php

namespace Drupal\ex81_content\Form;

use Drupal\Core\Entity\ContentEntityForm;
use Drupal\Core\Form\FormStateInterface;

/**
 * Form controller for the example ex81 content entity edit forms.
 */
class ExampleEx81ContentForm extends ContentEntityForm {

  /**
   * {@inheritdoc}
   */
  public function save(array $form, FormStateInterface $form_state) {
    $result = parent::save($form, $form_state);

    $entity = $this->getEntity();

    $message_arguments = ['%label' => $entity->toLink()->toString()];
    $logger_arguments = [
      '%label' => $entity->label(),
      'link' => $entity->toLink($this->t('View'))->toString(),
    ];

    switch ($result) {
      case SAVED_NEW:
        $this->messenger()->addStatus($this->t('New example ex81 content %label has been created.', $message_arguments));
        $this->logger('ex81_content')->notice('Created new example ex81 content %label', $logger_arguments);
        break;

      case SAVED_UPDATED:
        $this->messenger()->addStatus($this->t('The example ex81 content %label has been updated.', $message_arguments));
        $this->logger('ex81_content')->notice('Updated example ex81 content %label.', $logger_arguments);
        break;
    }

    $form_state->setRedirect('entity.example_ex81_content.canonical', ['example_ex81_content' => $entity->id()]);

    return $result;
  }

}
