<?php

/**
 * @file
 * Containts \Drupal\custommodule\Controller\FirstModule
 */

 namespace Drupal\custommodule\Controller;

/**
 * Provides route for our custom module.
 */
 class FirstModule {

  /**
   * Displays simple page
   */
   public function content(){
     return array(
       '#markup' => 'Hello, World!', 
     );
   }

   /**
    * Dispays private page
    */
   public function privateContent() {
    return array(
      '#markup' => 'Private page!',
    );
   }
 }