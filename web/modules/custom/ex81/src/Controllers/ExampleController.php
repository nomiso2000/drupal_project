<?php

namespace Drupal\ex81\Controllers;

use Drupal\Core\Render\RendererInterface;
use Drupal\node\Entity\Node;
use Laminas\Diactoros\Response\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ExampleController extends \Drupal\Core\Controller\ControllerBase {

  public function view() {

    //    return [
    //      '#markup' => $config->get('important_text'),
    //    ];

    //    $renderer = \Drupal::service('renderer');
    //    $el = [
    //      '#theme' => 'my_template_controller',
    //      '#test_var' => 'HELLO WORLDS',
    //    ];
    //    $renderer->render($el);
    //    return [
    //      '#theme' => 'my_template_controller',
    //      '#test_vars' => [
    //        [
    //          '#theme' => 'my_template',
    //          '#test_var' => 'HELLO WORLDS1',
    //        ],
    //        [
    //          '#theme' => 'my_template',
    //          '#test_var' => 'HELLO WORLDS2',
    //        ],
    //      ],
    //
    //    ];
    $config = \Drupal::config('ex81.settings');
    $nodes = Node::loadMultiple();
    $output = [];
    foreach ($nodes as $node) {
      $links = [];
      if ($node->hasField('field_neww_reference')) {
        /** @var  \Drupal\node\NodeInterface[] $related */
        $related = $node->get('field_neww_reference')->referencedEntities();

        foreach ($related as $item) {
          $links[] = [
            '#theme' => 'theme_template_link',
            '#title' => $item->label(),
            '#url' => $item->toUrl('canonical')->toString(),
          ];
        }
      }
      $output[] = [
        '#theme' => 'theme_template',
        '#title' => $node->label(),
        '#content' => $node->get('body')->view(['label' => 'hidden']),
        '#links' => $links,
        '#type' => $node->bundle(),
      ];
    }
    return $output;

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
