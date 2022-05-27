<?php

namespace Drupal\ex81;

use Drupal\Core\Config\Entity\ConfigEntityInterface;

/**
 * Provides an interface defining an ex81 entity type.
 */
interface Ex81Interface extends ConfigEntityInterface {

  public function getType(): string;

  public function getPlugins(): array;

}
