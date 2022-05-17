<?php

namespace Drupal\ex81\Controllers;

class News {

  public function view() {
    $config = \Drupal::config('ex81.settings_news');

    $em = \Drupal::entityTypeManager();
    $storage = $em->getStorage('node');
    $builder = $em->getViewBuilder('node');
    $ids = $storage->getQuery()
      ->condition('status', 1)
      ->condition('type', 'news')
      ->sort($config->get('sorted'), 'DESC')
      ->execute();
    $nodes = [];
    foreach ($storage->loadMultiple($ids) as $node) {
      $nodes[] = $node;
    }
    return $builder->viewMultiple($nodes, 'teaser');
  }

}
