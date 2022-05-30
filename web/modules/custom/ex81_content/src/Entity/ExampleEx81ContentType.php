<?php

namespace Drupal\ex81_content\Entity;

use Drupal\Core\Config\Entity\ConfigEntityBundleBase;

/**
 * Defines the Example ex81 Content type configuration entity.
 *
 * @ConfigEntityType(
 *   id = "example_ex81_content_type",
 *   label = @Translation("Example ex81 Content type"),
 *   label_collection = @Translation("Example ex81 Content types"),
 *   label_singular = @Translation("example ex81 content type"),
 *   label_plural = @Translation("example ex81 contents types"),
 *   label_count = @PluralTranslation(
 *     singular = "@count example ex81 contents type",
 *     plural = "@count example ex81 contents types",
 *   ),
 *   handlers = {
 *     "form" = {
 *       "add" = "Drupal\ex81_content\Form\ExampleEx81ContentTypeForm",
 *       "edit" = "Drupal\ex81_content\Form\ExampleEx81ContentTypeForm",
 *       "delete" = "Drupal\Core\Entity\EntityDeleteForm",
 *     },
 *     "list_builder" = "Drupal\ex81_content\ExampleEx81ContentTypeListBuilder",
 *     "route_provider" = {
 *       "html" = "Drupal\Core\Entity\Routing\AdminHtmlRouteProvider",
 *     }
 *   },
 *   admin_permission = "administer example ex81 content types",
 *   bundle_of = "example_ex81_content",
 *   config_prefix = "example_ex81_content_type",
 *   entity_keys = {
 *     "id" = "id",
 *     "label" = "label",
 *     "uuid" = "uuid"
 *   },
 *   links = {
 *     "add-form" = "/admin/structure/example_ex81_content_types/add",
 *     "edit-form" = "/admin/structure/example_ex81_content_types/manage/{example_ex81_content_type}",
 *     "delete-form" = "/admin/structure/example_ex81_content_types/manage/{example_ex81_content_type}/delete",
 *     "collection" = "/admin/structure/example_ex81_content_types"
 *   },
 *   config_export = {
 *     "id",
 *     "label",
 *     "uuid",
 *   }
 * )
 */
class ExampleEx81ContentType extends ConfigEntityBundleBase {

  /**
   * The machine name of this example ex81 content type.
   *
   * @var string
   */
  protected $id;

  /**
   * The human-readable name of the example ex81 content type.
   *
   * @var string
   */
  protected $label;

}
