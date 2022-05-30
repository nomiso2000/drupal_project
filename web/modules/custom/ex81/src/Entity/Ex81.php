<?php

namespace Drupal\ex81\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\ex81\Ex81Interface;

/**
 * Defines the ex81 entity type.
 *
 * @ConfigEntityType(
 *   id = "ex81",
 *   label = @Translation("ex81"),
 *   label_collection = @Translation("ex81s"),
 *   label_singular = @Translation("ex81"),
 *   label_plural = @Translation("ex81s"),
 *   label_count = @PluralTranslation(
 *     singular = "@count ex81",
 *     plural = "@count ex81s",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\ex81\Ex81ListBuilder",
 *     "form" = {
 *       "add" = "Drupal\ex81\Form\Ex81Form",
 *       "edit" = "Drupal\ex81\Form\Ex81Form",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm"
 *     }
 *   },
 *   config_prefix = "ex81",
 *   admin_permission = "administer ex81",
 *   links = {
 *     "collection" = "/admin/structure/ex81",
 *     "add-form" = "/admin/structure/ex81/add",
 *     "edit-form" = "/admin/structure/ex81/{ex81}",
 *     "delete-form" = "/admin/structure/ex81/{ex81}/delete"
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "text",
 *     "type",
 *     "plugins"
 *   }
 * )
 */
class Ex81 extends ConfigEntityBase implements Ex81Interface {

  /**
   * The ex81 ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The ex81 label.
   *
   * @var string
   */
  protected $label;

  /**
   * The ex81 text.
   *
   * @var string
   */
  protected $text;


  protected $type;

  protected $plugins;

  public function getType(): string {
    return $this->type;

  }

  public function getPlugins(): array {
    if (isset($this->plugins)) {
      return array_filter($this->plugins);
    }
    return [];
  }

}
