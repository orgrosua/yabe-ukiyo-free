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

use WC_Abstract_Order;
use wpdb;
use Yabe\Ukiyo\Utils\Config;
/**
 * @since 1.0.0
 */
class ReceiptBlock
{
    public function __construct()
    {
        /**
         * @package WooCommerce
         * @link https://woocommerce.github.io/code-reference/files/woocommerce-templates-order-order-details.html
         */
        \add_action('woocommerce_order_details_after_order_table', fn(WC_Abstract_Order $wcAbstractOrder) => $this->payment_receipt_after_table($wcAbstractOrder), 1000001, 1);
    }
    private function payment_receipt_after_table(WC_Abstract_Order $wcAbstractOrder) : void
    {
        if (!Config::get('ecommerce.woocommerce.print_purchase_page', \false)) {
            return;
        }
        if (!$wcAbstractOrder) {
            return;
        }
        if (!$this->is_order_complete($wcAbstractOrder->get_id())) {
            return;
        }
        $table_body = '';
        $row_template = '
            <tbody>
                <tr>
                    <td class="yabe-ukiyo_cel_name">
                        <span class="yabe-ukiyo_name">%s</span>
                    </td>
                    <td class="yabe-ukiyo_cel_status">
                        <span class="yabe-ukiyo_status">%s</span>
                    </td>
                    <td class="yabe-ukiyo_cel_activation">
                        <span class="yabe-ukiyo_activation">%s</span>
                    </td>
                    <td class="yabe-ukiyo_cel_expire">
                        <span class="yabe-ukiyo_expire">%s</span>
                    </td>
                    <td class="yabe-ukiyo_cel_license_key">
                        <span class="yabe-ukiyo_license_key"><code>%s</code></span>
                    </td>
                    <td class="yabe-ukiyo_cel_token">
                        <span class="yabe-ukiyo_token"><code>%s</code></span>
                    </td>
                </tr>
            </tbody>
        ';
        /** @var wpdb $wpdb */
        global $wpdb;
        $licenseOrders = $wpdb->get_results($wpdb->prepare("\n                SELECT *\n                FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_orders o\n                WHERE \n                    o.vendor = 'woocommerce'\n                    AND o.order_id = %d\n            ", (int) $wcAbstractOrder->get_id()));
        $site_url = \get_site_url();
        $site_name = \get_bloginfo('name');
        foreach ($licenseOrders as $licenseOrder) {
            $row = $wpdb->get_row($wpdb->prepare("\n                    SELECT \n                        l.*,\n                        COUNT(s.id) AS sites_count\n                    FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_licenses l\n                    LEFT JOIN {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_sites s ON s.license_id = l.id\n                    WHERE l.id = %d\n                    GROUP BY l.id\n                ", $licenseOrder->license_id));
            if (!$row) {
                continue;
            }
            $max_sites = $row->max_sites ?: \__('Unlimited', 'yabe-ukiyo');
            $total_activation = $row->sites_count;
            $table_body .= \sprintf($row_template, \esc_html(\get_post($licenseOrder->product_id)->post_title), $row->status ? 'Active' : 'Deactive', \esc_html($total_activation . ' / ' . $max_sites), $row->expired_at ? \date('M d, Y', (int) $row->expired_at) : '', \esc_html($row->license_key), \base64_encode("{$site_url}\n{$site_name}\n!ukiyo:{$row->license_key}"));
        }
        ?>
            <h3><?php 
        \_e('Yabe Ukiyo License', 'yabe-ukiyo');
        ?></h3>
            <table id="yabe-ukiyo_receipt" class="yabe-ukiyo_receipt">
                <thead>
                    <tr>
                        <th class="yabe-ukiyo_header_name"><?php 
        \_e('Product', 'yabe-ukiyo');
        ?></th>
                        <th><?php 
        \_e('Status', 'yabe-ukiyo');
        ?></th>
                        <th><?php 
        \_e('Activation', 'yabe-ukiyo');
        ?></th>
                        <th><?php 
        \_e('Expired at', 'yabe-ukiyo');
        ?></th>
                        <th><?php 
        \_e('License Key', 'yabe-ukiyo');
        ?></th>
                        <th><?php 
        \_e('Token', 'yabe-ukiyo');
        ?></th>
                    </tr>
                </thead>
                <?php 
        echo $table_body;
        ?>
            </table>

            <style>
                .yabe-ukiyo_receipt {
                    width: 100%;
                    table-layout: auto;
                }

                .yabe-ukiyo_receipt .yabe-ukiyo_header_name {
                    text-align: left;
                }

                .yabe-ukiyo_receipt .yabe-ukiyo_cel_status,
                .yabe-ukiyo_receipt .yabe-ukiyo_cel_activation,
                .yabe-ukiyo_receipt .yabe-ukiyo_cel_expire {
                    text-align: center;
                }

                .yabe-ukiyo_receipt .yabe-ukiyo_cel_license_key,
                .yabe-ukiyo_receipt .yabe-ukiyo_cel_token {
                    overflow-wrap: anywhere;
                }
            </style>
        <?php 
    }
    private function is_order_complete(int $post_id) : bool
    {
        return (bool) \get_post_meta($post_id, 'ukiyo_order_complete', \true);
    }
}
