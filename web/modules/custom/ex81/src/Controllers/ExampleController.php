<?php

namespace Drupal\ex81\Controllers;

class ExampleController extends \Drupal\Core\Controller\ControllerBase {

  public function view() {
    $config = \Drupal::config('system.site');
    return [
      '#markup' => $config->get('name'),
    ];
  }

}
