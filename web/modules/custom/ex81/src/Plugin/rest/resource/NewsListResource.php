<?php

namespace Drupal\ex81\Plugin\rest\resource;

use Drupal\Component\Plugin\DependentPluginInterface;
use Drupal\Core\Cache\CacheableMetadata;
use Drupal\Core\Database\Connection;
use Drupal\Core\Routing\AccessAwareRouterInterface;
use Drupal\Core\Routing\BcRoute;
use Drupal\rest\ModifiedResourceResponse;
use Drupal\rest\Plugin\ResourceBase;
use Drupal\rest\ResourceResponse;
use Psr\Log\LoggerInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Represents News records as resources.
 *
 * @RestResource (
 *   id = "ex81_news_list",
 *   label = @Translation("News"),
 *   uri_paths = {
 *     "canonical" = "/api/news-list",
 *   }
 * )
 */
class NewsListResource extends ResourceBase {


  /**
   * Responds to GET requests.
   *
   * @return \Drupal\rest\ResourceResponse
   *   The response containing the record.
   *
   * @throws \Symfony\Component\HttpKernel\Exception\HttpException
   */
  public function get(Request $request) {
    $storage = \Drupal::entityTypeManager()->getStorage('node');
    $ids = $storage->getQuery()
      ->condition('status', 1)
      ->range(0, 10)
      ->execute();
    $data = [];
    $cache = new CacheableMetadata();
    if (!empty($ids)) {
      foreach ($storage->loadMultiple($ids) as $node) {
        $cache->addCacheableDependency($node);
        $url = $node->toUrl()->toString(TRUE);
        $cache->addCacheableDependency($url);
        $data[] = [
          'title' => $node->label(),
          'id' => $node->id(),
          'url' => $url->getGeneratedUrl(),
        ];
      }
    }
    $response = new ResourceResponse($data);
    $response->addCacheableDependency($cache);
    return $response;
  }

  /**
   * {@inheritDoc}
   */
  protected function getBaseRouteRequirements($method) {
    return [
      '_access' => 'TRUE',
    ];
  }

}
