<?php

namespace Drupal\ex81\Controllers;

use Drupal\Component\Serialization\Json;
use Drupal\Component\Utility\Html;
use Drupal\Core\Ajax\AjaxResponse;
use Drupal\Core\Ajax\HtmlCommand;
use Drupal\Core\Ajax\MessageCommand;
use Drupal\Core\Ajax\RedirectCommand;
use Drupal\Core\Ajax\SettingsCommand;
use Drupal\Core\Controller\ControllerBase;
use Drupal\Core\Form\FormState;
use Drupal\Core\Security\TrustedCallbackInterface;
use Drupal\Core\Url;
use Drupal\node\Entity\Node;
use Drupal\node\Entity\NodeType;
use Drupal\node\NodeTypeInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;


class ExampleAjax {

  public function api(Request $request) {
    //ajax.js
    $response = new AjaxResponse();
    //    $element = [
    //      '#theme' => 'item_list',
    //      '#items' => ['first', 'second', 'add text with styles dynamic'],
    //      '#attributes' => ['id' => Html::getUniqueId('id-with-unique-hash')],
    //      '#attached' => [
    //        'library' => ['ex81/custom'],
    //        'drupalSettings' => [
    //          'foo' => 'bar',
    //        ],
    //      ],
    //    ];
    $links = array_map(function (NodeTypeInterface $type) {
      return [
        '#type' => 'link',
        '#title' => 'Node add' . $type->label(),
        '#url' => Url::fromRoute('node.add', ['node_type' => $type->id()]),
        '#attributes' => [
          'class' => ['use-ajax'],
          'data-dialog-type' => 'modal',
          'data-dialog-options' => Json::encode([
            'width' => 'wide',
          ]),
        ],
      ];
    }, NodeType::loadMultiple());
    $links[] = [
      '#type' => 'link',
      '#title' => 'Custom form',
      '#url' => Url::fromRoute('ex81.hello_form'),
      '#attributes' => [
        'class' => ['use-ajax'],
        'data-dialog-type' => 'modal',
        'data-dialog-options' => Json::encode([
          'width' => 'wide',
        ]),
      ],
    ];

    $element = [
      '#theme' => 'item_list',
      '#items' => $links,
      '#attributes' => ['id' => Html::getUniqueId('id-with-unique-hash')],
      '#attached' => [
        'library' => ['ex81/custom'],
        'drupalSettings' => [
          'foo' => 'bar',
        ],
      ],
    ];
    //    $renderer = \Drupal::service('renderer');
    $response->addCommand(new HtmlCommand('#ajax-wrapper', $element));
    //    $response->addCommand(new RedirectCommand('/'));
    //    $response->addCommand(new MessageCommand('You are clickng on the link'));
    return $response;
  }

  public function ajaxLink() {
    //ajax.js
    return [
      [
        '#theme' => 'container',
        '#attributes' => ['id' => 'ajax-wrapper'],
      ],
      [
        '#type' => 'link',
        '#title' => 'Link to All News HERE',
        '#url' => Url::fromRoute('ex81.example_api'),
        '#attributes' => ['class' => ['use-ajax']],
      ],
    ];
  }

}
