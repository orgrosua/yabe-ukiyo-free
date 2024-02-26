<?php

/*
 * This file is part of the Yabe package.
 *
 * (c) Joshua Gugun Siagian <suabahasa@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
declare (strict_types=1);
namespace Yabe\Ukiyo\Ecommerce\Platform\WooCommerce;

use WC_Order;
use WC_Product;
use WC_Subscription;
use wpdb;
use Yabe\Ukiyo\Utils\Common;
use Yabe\Ukiyo\Utils\Config;
use function wc_get_order;
/**
 * @since 1.0.0
 */
class Payment
{
    public function __construct()
    {
        /**
         * Generates and creates licenses when payment status is completed
         * 
         * @package WooCommerce
         * @link https://woocommerce.github.io/code-reference/hooks/hooks.html
         */
        \add_action('woocommerce_order_status_completed', fn(int $order_id) => $this->order_status_completed($order_id), 10, 1);
        /**
         * Revokes and deactivates licenses when payment status is updated
         * 
         * @package WooCommerce
         * @link https://woocommerce.github.io/code-reference/hooks/hooks.html
         */
        \add_action('woocommerce_order_status_changed', fn(int $order_id, string $old_status, string $new_status) => $this->order_status_changed($order_id, $old_status, $new_status), 10, 3);
        /**
         * @package WooCommerce Subscriptions
         * @link https://woocommerce.com/document/subscriptions/develop/action-reference/
         */
        \add_action('woocommerce_subscription_status_updated', fn(WC_Subscription $wcSubscription, string $old_status, string $new_status) => $this->subscription_status_updated($wcSubscription, $old_status, $new_status), 10, 3);
    }
    private function is_order_complete(int $post_id) : bool
    {
        return (bool) \get_post_meta($post_id, 'ukiyo_order_complete', \true);
    }
    private function is_renewal_complete(int $post_id) : bool
    {
        return (bool) \get_post_meta($post_id, 'ukiyo_renewal_complete', \true);
    }
    private function is_should_generate(int $post_id) : bool
    {
        return (bool) \get_post_meta($post_id, 'ukiyo_should_generate', \true);
    }
    private function is_should_renewal(int $post_id) : bool
    {
        return (bool) \get_post_meta($post_id, 'ukiyo_should_renewal', \true);
    }
    private function number_active_duration(int $post_id) : int
    {
        return (int) \get_post_meta($post_id, 'ukiyo_active_duration', \true);
    }
    private function number_max_sites(int $post_id) : int
    {
        return (int) \get_post_meta($post_id, 'ukiyo_max_sites', \true);
    }
    private function order_status_completed(int $order_id) : void
    {
        $order = wc_get_order($order_id);
        if (!$order) {
            return;
        }
        $this->when_payment_status_completed($order);
    }
    private function order_status_changed(int $order_id, string $old_status, string $new_status) : void
    {
        $order = wc_get_order($order_id);
        if (!$order) {
            return;
        }
        if ($new_status !== 'completed') {
            $this->when_payment_status_canceled($order, $old_status, $new_status);
        }
    }
    private function when_payment_status_completed(WC_Order $wcOrder) : void
    {
        if ($this->is_order_complete($wcOrder->get_id())) {
            $this->refresh_order($wcOrder->get_id());
        } else {
            $this->fresh_order($wcOrder);
        }
    }
    /**
     * A new order was created, let's create the license
     */
    private function fresh_order(WC_Order $wcOrder) : void
    {
        /** @var wpdb $wpdb */
        global $wpdb;
        foreach ($wcOrder->get_items() as $orderItem) {
            /** @var WC_Product $product */
            $product = $orderItem->get_product();
            if (!$this->is_should_generate((int) $product->get_id())) {
                continue;
            }
            for ($iQty = 0; $iQty < $orderItem->get_quantity(); ++$iQty) {
                // create license
                $active_duration = $this->number_active_duration((int) $product->get_id());
                $wpdb->insert(\sprintf('%s%s_licenses', $wpdb->prefix, $wpdb->yabe_ukiyo_prefix), ['uid' => Common::random_slug(10), 'title' => \sprintf('[WC] #%d %s', $wcOrder->get_id(), $product->get_name()), 'license_key' => Common::random_slug(), 'status' => \true, 'expired_at' => $active_duration > 0 ? \strtotime(\sprintf('+%d days', $active_duration)) : null, 'max_sites' => $this->number_max_sites((int) $product->get_id()) > 0 ? $this->number_max_sites((int) $product->get_id()) : null, 'user_id' => $wcOrder->get_user_id(), 'created_at' => \time(), 'updated_at' => \time()], ['%s', '%s', '%s', '%d', '%d', '%d', '%d', '%d', '%d']);
                $license_id = $wpdb->insert_id;
                // create license order
                $wpdb->insert(\sprintf('%s%s_orders', $wpdb->prefix, $wpdb->yabe_ukiyo_prefix), ['created_at' => \time(), 'updated_at' => \time(), 'uid' => Common::random_slug(10), 'vendor' => 'woocommerce', 'order_id' => $wcOrder->get_id(), 'order_type' => 'shop_order', 'product_id' => (int) $product->get_id(), 'product_type' => 'product', 'order_status' => 'completed', 'customer_id' => $wcOrder->get_user_id(), 'license_id' => $license_id], ['%d', '%d', '%s', '%s', '%d', '%s', '%d', '%s', '%s', '%d', '%d']);
            }
        }
        \update_post_meta($wcOrder->get_id(), 'ukiyo_order_complete', \true);
    }
    /**
     * An completed order's status was updated, let's update the license
     */
    private function refresh_order(int $order_id) : void
    {
        /** @var wpdb $wpdb */
        global $wpdb;
        $licenseOrders = $wpdb->get_results($wpdb->prepare("\n                SELECT *\n                FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_orders o\n                WHERE \n                    o.vendor = 'woocommerce'\n                    AND o.order_id = %d\n            ", $order_id));
        foreach ($licenseOrders as $licenseOrder) {
            $row = $wpdb->get_row($sql = $wpdb->prepare("\n                    SELECT *\n                    FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_licenses l\n                    WHERE l.id = %d\n                ", $licenseOrder->license_id));
            if (!$row) {
                continue;
            }
            $wpdb->update(\sprintf('%s%s_licenses', $wpdb->prefix, $wpdb->yabe_ukiyo_prefix), ['status' => \true], ['id' => $row->id], ['%d'], ['%d']);
        }
    }
    private function when_payment_status_canceled(WC_Order $wcOrder, string $old_status, string $new_status) : void
    {
        $revokes = Config::get('ecommerce.woocommerce.revoke_when_payment_status', []);
        $deactivates = Config::get('ecommerce.woocommerce.deactivate_when_payment_status', []);
        if (!\in_array($new_status, $revokes, \true) && !\in_array($new_status, $deactivates, \true)) {
            return;
        }
        if (!$this->is_order_complete((int) $wcOrder->get_id())) {
            return;
        }
        /** @var wpdb $wpdb */
        global $wpdb;
        $licenseOrders = $wpdb->get_results($wpdb->prepare("\n                SELECT *\n                FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_orders o\n                WHERE \n                    o.vendor = 'woocommerce'\n                    AND o.order_id = %d\n            ", $wcOrder->get_id()));
        foreach ($licenseOrders as $licenseOrder) {
            $row = $wpdb->get_row($wpdb->prepare("\n                    SELECT *\n                    FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_licenses l\n                    WHERE l.id = %d\n                ", $licenseOrder->license_id));
            if (!$row) {
                continue;
            }
            if (\in_array($new_status, $revokes, \true)) {
                $this->revoke((int) $wcOrder->get_id(), (int) $licenseOrder->id, (int) $row->id);
            } elseif (\in_array($new_status, $deactivates, \true)) {
                $this->deactivate((int) $licenseOrder->id, (int) $row->id, $new_status);
            }
        }
    }
    private function revoke(int $payment_id, int $order_id, int $license_id)
    {
        $this->revoke_license($license_id);
        $this->revoke_order($order_id);
        \delete_post_meta($payment_id, 'ukiyo_order_complete');
    }
    private function revoke_license(int $license_id)
    {
        /** @var wpdb $wpdb */
        global $wpdb;
        $wpdb->delete(\sprintf('%s%s_licenses', $wpdb->prefix, $wpdb->yabe_ukiyo_prefix), ['id' => $license_id], ['%d']);
    }
    private function revoke_order(int $order_id)
    {
        /** @var wpdb $wpdb */
        global $wpdb;
        $wpdb->delete(\sprintf('%s%s_orders', $wpdb->prefix, $wpdb->yabe_ukiyo_prefix), ['id' => $order_id, 'vendor' => 'woocommerce'], ['%d', '%s']);
    }
    private function deactivate(int $order_id, int $license_id, string $new_status)
    {
        /** @var wpdb $wpdb */
        global $wpdb;
        $wpdb->update(\sprintf('%s%s_licenses', $wpdb->prefix, $wpdb->yabe_ukiyo_prefix), ['status' => \false], ['id' => $license_id], ['%d'], ['%d']);
        $wpdb->update(\sprintf('%s%s_orders', $wpdb->prefix, $wpdb->yabe_ukiyo_prefix), ['order_status' => $new_status], ['id' => $order_id, 'vendor' => 'woocommerce'], ['%s'], ['%d', '%s']);
    }
    private function subscription_status_updated(WC_Subscription $wcSubscription, string $old_status, string $new_status) : void
    {
        $wcSubscription = wc_get_order($wcSubscription->get_id());
        if (!$wcSubscription) {
            return;
        }
        if (!$wcSubscription->get_parent_id()) {
            return;
        }
        if ($new_status === 'active') {
            $this->when_subscription_status_completed($wcSubscription, $old_status, $new_status);
        }
    }
    private function when_subscription_status_completed(WC_Subscription $wcSubscription, string $old_status, string $new_status) : void
    {
        if (!$wcSubscription->get_parent_id() || !$this->is_order_complete((int) $wcSubscription->get_parent_id()) || $this->is_renewal_complete((int) $wcSubscription->get_id())) {
            return;
        }
        $order = wc_get_order($wcSubscription->get_parent_id());
        foreach ($order->get_items() as $orderItem) {
            /** @var WC_Product $product */
            $product = $orderItem->get_product();
            if (!$this->is_should_renewal((int) $product->get_id())) {
                continue;
            }
            if (!$this->is_should_generate((int) $product->get_id())) {
                continue;
            }
            /** @var wpdb $wpdb */
            global $wpdb;
            $licenseOrders = $wpdb->get_results($wpdb->prepare("\n                    SELECT *\n                    FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_orders o\n                    WHERE \n                        o.vendor = 'woocommerce'\n                        AND o.order_id = %d\n                        AND o.product_id = %d\n                ", $order->get_id(), (int) $product->get_id()));
            foreach ($licenseOrders as $licenseOrder) {
                $row = $wpdb->get_row($wpdb->prepare("\n                        SELECT *\n                        FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_licenses l\n                        WHERE l.id = %d\n                    ", $licenseOrder->license_id));
                if (!$row) {
                    continue;
                }
                if ($row->expired_at === null) {
                    continue;
                }
                $expired_at = $row->expired_at ? (int) $row->expired_at : null;
                $active_duration = $this->number_active_duration((int) $product->get_id());
                $wpdb->update(\sprintf('%s%s_licenses', $wpdb->prefix, $wpdb->yabe_ukiyo_prefix), ['expired_at' => $active_duration > 0 ? \strtotime(\sprintf('+%d days', $active_duration), $expired_at) : null], ['id' => $row->id], ['%d'], ['%d']);
                // replicate license order
                $wpdb->insert(\sprintf('%s%s_orders', $wpdb->prefix, $wpdb->yabe_ukiyo_prefix), ['created_at' => \time(), 'updated_at' => \time(), 'uid' => Common::random_slug(10), 'vendor' => 'woocommerce', 'order_id' => $wcSubscription->get_id(), 'order_type' => 'shop_order', 'product_id' => (int) $product->get_id(), 'product_type' => 'product', 'order_status' => $new_status, 'customer_id' => $wcSubscription->get_user_id(), 'license_id' => $licenseOrder->license_id], ['%d', '%d', '%s', '%s', '%d', '%s', '%d', '%s', '%s', '%d', '%d']);
            }
        }
        \update_post_meta($wcSubscription->get_id(), 'ukiyo_renewal_complete', \true);
    }
}
