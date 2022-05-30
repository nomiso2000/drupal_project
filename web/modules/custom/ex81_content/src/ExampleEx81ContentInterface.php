<?php

namespace Drupal\ex81_content;

use Drupal\Core\Entity\ContentEntityInterface;
use Drupal\Core\Entity\EntityChangedInterface;
use Drupal\user\EntityOwnerInterface;

/**
 * Provides an interface defining an example ex81 content entity type.
 */
interface ExampleEx81ContentInterface extends ContentEntityInterface, EntityOwnerInterface, EntityChangedInterface {

}
