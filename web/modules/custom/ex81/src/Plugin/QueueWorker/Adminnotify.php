<?php

namespace Drupal\ex81\Plugin\QueueWorker;

use Drupal\Core\Queue\QueueWorkerBase;
use Drupal\node\Entity\Node;
use Drupal\user\UserInterface;

/**
 * Defines 'ex81_adminnotify' queue worker.
 *
 * @QueueWorker(
 *   id = "ex81_adminnotify",
 *   title = @Translation("AdminNotify"),
 *   cron = {"time" = 60}
 * )
 */
class Adminnotify extends QueueWorkerBase {

  /**
   * {@inheritdoc}
   */
  public function processItem($data) {
    $user = Node::load($data);
    //Send email here
    $mailManager = \Drupal::service('plugin.manager.mail');
    $storage = \Drupal::entityTypeManager()->getStorage('user');
    /** @var \Drupal\user\UserInterface $users */
    $users = $storage->loadMultiple($storage->getQuery()
      ->condition('role', 'admin')
      ->execute());
    foreach ($users as $recipient) {
      $mailManager->mail('ex81', 'node_created', $recipient->getEmail(), 'en', ['new_user' => $user->label()]);
    }

  }

}
