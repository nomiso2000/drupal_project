<?php


/**
 * Implements hook_post_update_NAME().
 */
function ex81_content_post_update_create_content(&$sandbox) {
  \Drupal\node\Entity\Node::create([
    'type' => 'news',
    'title' => "First Create Custom From Code",
    'status' => 1,
  ])->save();
  \Drupal::messenger('Created custom page');
}

function ex81_content_post_update_set_flag(&$sandbox) {
  $storage = \Drupal::entityTypeManager()->getStorage('node');
  $ids = $storage->getQuery()
    ->condition('type', 'example_ex81_content')
    ->execute();

  $nodes = \Drupal\node\Entity\Node::loadMultiple($ids);
  foreach ($nodes as $node) {
    $node->set('flag', FALSE);
    $node->save();
  }
}
