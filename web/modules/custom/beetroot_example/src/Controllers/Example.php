<?php

namespace Drupal\beetroot_example\Controllers;

//use Drupal\Core\Controller\ControllerBase;

// class Example extends ControllerBase {
//   public function view () {
//     $users = $this->entityTypeManager()->getStorage('user')->loadMultiple();
//     $names = [];
//     foreach($users as $user){
//       $names[] = $user->label();
//     }
//     return ['#markup' => $names[0]];
//   }
// }

class Example {

  /** @var \Drupal\Core\Database\Connection */
  // private $database;

  // public function __construct(\Drupal\Core\Database\Connection $database) {
  //   $this->database = $database;
  // }

  public function view() {
    $entity_type = 'node';
    $view_mode = 'teaser';
    $view_builder = \Drupal::entityTypeManager()->getViewBuilder($entity_type);
    $storage = \Drupal::entityTypeManager()->getStorage($entity_type);
    //    $createNode = $storage->create([
    //      'type' => 'article',
    //      'title' => 'Test node',
    //      'body' => [
    //        'value' => 'Some text',
    //        'format' => 'basic_html',
    //      ],
    //    ])->save();
    $ids = $storage->getQuery()
      ->condition('status', 1)
      ->condition('type', 'article') // type = bundle id (machine name)
      ->sort('created', 'DESC') // sorted by time of creation
      ->pager(1) // limit 15 items
      ->execute();
    $node = $storage->load(reset($ids));
    $build = $view_builder->view($node, $view_mode);
    //    return array('#markup' => $build);
    return $build;
  }

  public function viewId($id) {
    $em = \Drupal::entityTypeManager();
    $storage = $em->getStorage('node');
    $builder = $em->getViewBuilder('node');
    $newsids = $storage->getQuery()
      ->condition('status', '1')
      ->condition('type', 'news')
      ->condition('field_category', $id)
      ->sort('created', 'DESC')
      //      ->range(0, 10)
      ->execute();
    $nodes = [];
    foreach ($storage->loadMultiple($newsids) as $item) {
      $nodes[] = $item;
    }
    $build = $builder->viewMultiple($nodes, 'teaser');
    return $build;

  }

}



// class Example {
//   /** @var \Drupal\Core\Database\Connection */
//   private $database;

//   public function __construct(\Drupal\Core\Database\Connection $database) {
//     $this->database = $database;
//   }

//   public function view () {

//     return ['#markup' => "Hello world"];
//   }
// }
