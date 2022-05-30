<?php

namespace Drupal\ex81_content;

use Drupal\Core\Config\Entity\ConfigEntityListBuilder;
use Drupal\Core\Entity\EntityInterface;
use Drupal\Core\Url;

/**
 * Defines a class to build a listing of example ex81 content type entities.
 *
 * @see \Drupal\ex81_content\Entity\ExampleEx81ContentType
 */
class ExampleEx81ContentTypeListBuilder extends ConfigEntityListBuilder {

  /**
   * {@inheritdoc}
   */
  public function buildHeader() {
    $header['title'] = $this->t('Label');

    return $header + parent::buildHeader();
  }

  /**
   * {@inheritdoc}
   */
  public function buildRow(EntityInterface $entity) {
    $row['title'] = [
      'data' => $entity->label(),
      'class' => ['menu-label'],
    ];

    return $row + parent::buildRow($entity);
  }

  /**
   * {@inheritdoc}
   */
  public function render() {
    $build = parent::render();

    $build['table']['#empty'] = $this->t(
      'No example ex81 content types available. <a href=":link">Add example ex81 content type</a>.',
      [':link' => Url::fromRoute('entity.example_ex81_content_type.add_form')->toString()]
    );

    return $build;
  }

}
