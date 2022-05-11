<?php

/**
 * @file
 * Contains \Drupal\custommodule\Controller\DisplayNode 
 */

namespace Drupal\custommodule\Controller;

use Drupal\Core\Access\AccessResult;
use Drupal\node\NodeInterface;

/**
 * Provides route responses for the custommodule module.
 */

class DisplayNode {
  /**
   * Returns a simple page. 
   * @return array
   *  A siple renderable array.
   */
  public function content(NodeInterface $node) {
    $element = array(
      '#markup' => $node->body->value,
    );
    return $element;
  }

  /**
   * Checks access for this controller.
   */

   public function access(NodeInterface $node) {
    $user = \Drupal::currentUser();
    if($node->getType() === 'article' && !in_array('authenticated', $user->getRoles())) {
      return AccessResult::forbidden();
    }
    return AccessResult::allowed();
   }

   /**
    * Return a page titile.
    */
   public function getTitle (NodeInterface $node) {
     return $node->getTitle().'by '. date('Y-m-d');
   }


}