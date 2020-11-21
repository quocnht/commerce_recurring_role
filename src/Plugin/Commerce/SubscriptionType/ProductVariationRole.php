<?php

namespace Drupal\commerce_recurring_role\Plugin\Commerce\SubscriptionType;

use Drupal\commerce_order\Entity\OrderInterface;
use Drupal\commerce_recurring\Entity\SubscriptionInterface;
use Drupal\commerce_recurring\Plugin\Commerce\SubscriptionType\SubscriptionTypeBase;

/**
 * Provides the product variation subscription type.
 *
 * @CommerceSubscriptionType(
 *   id = "product_variation_role",
 *   label = @Translation("Product variation role"),
 *   purchasable_entity_type = "commerce_product_variation",
 * )
 */
class ProductVariationRole extends SubscriptionTypeBase {

  /**
   * {@inheritdoc}
   */
  public function onSubscriptionTrialStart(SubscriptionInterface $subscription, OrderInterface $order) {
    $this->addRole($subscription);
  }

  /**
   * {@inheritdoc}
   */
  public function onSubscriptionTrialCancel(SubscriptionInterface $subscription) {
    $this->removeRole($subscription);
  }

  /**
   * {@inheritdoc}
   */
  public function onSubscriptionActivate(SubscriptionInterface $subscription, OrderInterface $order) {
    $this->addRole($subscription);
  }

  /**
   * {@inheritdoc}
   */
  public function onSubscriptionRenew(SubscriptionInterface $subscription, OrderInterface $order, OrderInterface $next_order) {
    $this->addRole($subscription);
  }

  /**
   * {@inheritdoc}
   */
  public function onSubscriptionCancel(SubscriptionInterface $subscription) {
    $this->removeRole($subscription);
  }

  /**
   * {@inheritdoc}
   */
  public function onSubscriptionExpire(SubscriptionInterface $subscription) {
    $this->removeRole($subscription);
  }

  /**
   * Add the user role to reflect the subscription.
   *
   * @param \Drupal\commerce_recurring\Entity\SubscriptionInterface $subscription
   *   The subscription.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  protected function addRole(SubscriptionInterface $subscription) {
    $user = $subscription->getCustomer();
    $role_id = $subscription->getPurchasedEntity()->get('role')->target_id;
    $user->addRole($role_id);
    $user->save();
  }

  /**
   * Remove the user role to reflect the subscription.
   *
   * @param \Drupal\commerce_recurring\Entity\SubscriptionInterface $subscription
   *   The subscription.
   *
   * @throws \Drupal\Core\Entity\EntityStorageException
   */
  protected function removeRole(SubscriptionInterface $subscription) {
    $user = $subscription->getCustomer();
    $role_id = $subscription->getPurchasedEntity()->get('role')->target_id;
    $user->removeRole($role_id);
    $user->save();
  }
}
