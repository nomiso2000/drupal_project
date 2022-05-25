<?php

namespace Drupal\ex81\Controllers;

use Drupal\node\Entity\Node;

class News {

  //  public function view() {
  //    $config = \Drupal::config('ex81.settings_news');
  //
  //    $em = \Drupal::entityTypeManager();
  //    $storage = $em->getStorage('node');
  //    $builder = $em->getViewBuilder('node');
  //    $ids = $storage->getQuery()
  //      ->condition('status', 1)
  //      ->condition('type', 'news')
  //      ->sort($config->get('sorted'), 'DESC')
  //      ->execute();
  //    $nodes = [];
  //    foreach ($storage->loadMultiple($ids) as $node) {
  //      $nodes[] = $node;
  //    }
  //    return $builder->viewMultiple($nodes, 'teaser');
  //  }
  public function view(): array {
    $nodes = Node::loadMultiple();
    $output = [];
    foreach ($nodes as $node) {
      if ($node->hasField('field_category')) {
        $output[] = [
          '#theme' => 'theme_template',
          '#title' => $node->label(),
          '#content' => $node->get('body')->view(['label' => 'hidden']),
          '#category' => $node->get('field_category')
            ->view(['label' => 'hidden']),

        ];
      }
      else {
        $output[] = [
          '#theme' => 'theme_template',
          '#title' => $node->label(),
          '#content' => $node->get('body')->view(['label' => 'hidden']),
          '#attributes' => ['class' => ['foobar']],
          '#attached' => [
            'library' => [
              'ex81/custom',
            ],
          ],
        ];
      }

    }
    return $output;
  }

}
