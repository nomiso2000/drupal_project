<?php

namespace Drupal\custom_plugin\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBase;
use Drupal\custom_plugin\CustomPluginInterface;

/**
 * Defines the custom plugin entity type.
 *
 * @ConfigEntityType(
 *   id = "custom_plugin",
 *   label = @Translation("Custom plugin"),
 *   label_collection = @Translation("Custom plugins"),
 *   label_singular = @Translation("custom plugin"),
 *   label_plural = @Translation("custom plugins"),
 *   label_count = @PluralTranslation(
 *     singular = "@count custom plugin",
 *     plural = "@count custom plugins",
 *   ),
 *   handlers = {
 *     "list_builder" = "Drupal\custom_plugin\CustomPluginListBuilder",
 *     "form" = {
 *       "add" = "Drupal\custom_plugin\Form\CustomPluginForm",
 *       "edit" = "Drupal\custom_plugin\Form\CustomPluginForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm"
 *     }
 *   },
 *   config_prefix = "custom_plugin",
 *   admin_permission = "administer custom_plugin",
 *   links = {
 *     "collection" = "/admin/structure/custom-plugin",
 *     "add-form" = "/admin/structure/custom-plugin/add",
 *     "edit-form" = "/admin/structure/custom-plugin/{custom_plugin}",
 *     "delete-form" = "/admin/structure/custom-plugin/{custom_plugin}/delete"
 *   },
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "description",
 *     "plugins"
 *
 *   }
 * )
 */
class CustomPlugin extends ConfigEntityBase implements CustomPluginInterface {

  /**
   * The custom plugin ID.
   *
   * @var string
   */
  protected $id;

  /**
   * The custom plugin label.
   *
   * @var string
   */
  protected $label;


  /**
   * The custom_plugin description.
   *
   * @var string
   */
  protected $description;
  /**
   * The custom_plugin list of plugin.
   *
   * @var string
   */
  protected $plugins;

}
