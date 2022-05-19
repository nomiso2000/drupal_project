<?php

namespace Drupal\ex81\Controllers;

use Drupal\Core\Render\RendererInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ExampleController extends \Drupal\Core\Controller\ControllerBase {

  public function view() {
    $config = \Drupal::config('ex81.settings');
    //    return [
    //      '#markup' => $config->get('important_text'),
    //    ];

    //    $renderer = \Drupal::service('renderer');
    //    $el = [
    //      '#theme' => 'my_template_controller',
    //      '#test_var' => 'HELLO WORLDS',
    //    ];
    //    $renderer->render($el);
    return [
      '#theme' => 'my_template_controller',
      '#test_vars' => [
        [
          '#theme' => 'my_template',
          '#test_var' => 'HELLO WORLDS1',
        ],
        [
          '#theme' => 'my_template',
          '#test_var' => 'HELLO WORLDS2',
        ],
      ],

    ];
  }

  public function autocomplete(Request $request) {
    $q = $request->query->get('q');
    $storage = $this->entityTypeManager()->getStorage('node');
    $ids = $storage->getQuery()
      ->condition('title', "%{$q}%", "LIKE")
      ->condition('status', 1)
      ->execute();
    if (empty($ids)) {
      return new JsonResponse([]);
    }
    $nodes = $storage->loadMultiple($ids);
    $results = [];
    foreach ($nodes as $node) {
      $results[] = $node->label() . '(' . $node->id() . ')';
    }
    return new JsonResponse($results);
  }

}
