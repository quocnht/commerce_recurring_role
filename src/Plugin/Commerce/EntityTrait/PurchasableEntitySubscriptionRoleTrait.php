<?php

namespace Drupal\commerce_recurring_role\Plugin\Commerce\EntityTrait;

use Drupal\entity\BundleFieldDefinition;
use Drupal\commerce\Plugin\Commerce\EntityTrait\EntityTraitBase;

/**
 * Provides a trait to enable purchasing role of subscriptions.
 *
 * @CommerceEntityTrait(
 *   id = "purchasable_entity_subscription_role",
 *   label = @Translation("Allow subscriptions with role"),
 *   entity_types = {"commerce_product_variation"}
 * )
 */
class PurchasableEntitySubscriptionRoleTrait extends EntityTraitBase {

  /**
   * {@inheritdoc}
   */
  public function buildFieldDefinitions() {
    $fields = [];
    $fields['role'] = BundleFieldDefinition::create('entity_reference')
      ->setLabel(t('Role'))
      ->setRequired(TRUE)
      ->setSetting('target_type', 'user_role')
      ->setDisplayOptions('form', [
        'type' => 'options_select',
      ])
      ->setDisplayConfigurable('form', TRUE);

    return $fields;
  }

}
