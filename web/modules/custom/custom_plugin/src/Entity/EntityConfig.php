<?php

namespace Drupal\custom_plugin\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\custom_plugin\EntityConfigInterface;

/**
 * Defines the entity_config entity type.
 *
 * @ConfigEntityType(
 *   id = "entity_config",
 *   label = @Translation("entity_config"),
 *   label_collection = @Translation("entity_configs"),
 *   label_singular = @Translation("entity_config"),
 *   label_plural = @Translation("entity_configs"),
 *   label_count = @PluralTranslation(
 *     singular = "@count entity_config",
 *     plural = "@count entity_configs",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\custom_plugin\EntityConfigListBuilder",
 *     "form" = {
 *       "add" = "Drupal\custom_plugin\Form\EntityConfigForm",
 *       "edit" = "Drupal\custom_plugin\Form\EntityConfigForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm"
 *     }
 *   },
 *   config_prefix = "entity_config",
 *   admin_permission = "administer entity_config",
 *   links = {
 *     "collection" = "/admin/structure/entity-config",
 *     "add-form" = "/admin/structure/entity-config/add",
 *     "edit-form" = "/admin/structure/entity-config/{entity_config}",
 *     "delete-form" = "/admin/structure/entity-config/{entity_config}/delete"
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "plugins",
 * "type"
 *   }
 * )
 */
class EntityConfig extends ConfigEntityBase implements EntityConfigInterface {

  /**
   * The entity_config ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The entity_config label.
   *
   * @var string
   */
  protected $label;

  /**
   * The entity_config $type.
   *
   * @var string
   */
  protected $type;
  protected $plugins;
  public function getPlugins() {
    return $this->plugins;
  }

}
