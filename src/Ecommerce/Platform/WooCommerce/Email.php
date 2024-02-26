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
use function wc_get_product;
/**
 * @since 1.0.0
 */
class Email
{
    public function __construct()
    {
        /**
         * @package WooCommerce
         * @link https://woocommerce.github.io/code-reference/files/woocommerce-templates-emails-email-order-details.html#source-view.90
         */
        \add_action('woocommerce_email_after_order_table', fn(WC_Abstract_Order $wcAbstractOrder, $sent_to_admin, $plain_text, $email) => $this->email_after_order_table($wcAbstractOrder, $sent_to_admin, $plain_text, $email), 1000001, 4);
    }
    private function is_order_complete(int $post_id) : bool
    {
        return (bool) \get_post_meta($post_id, 'ukiyo_order_complete', \true);
    }
    private function email_after_order_table(WC_Abstract_Order $wcAbstractOrder, $sent_to_admin, $plain_text, $email)
    {
        if (!$wcAbstractOrder) {
            return;
        }
        if (!$this->is_order_complete($wcAbstractOrder->get_id())) {
            return;
        }
        /** @var wpdb $wpdb */
        global $wpdb;
        $licenseOrders = $wpdb->get_results($wpdb->prepare("\n                SELECT *\n                FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_orders o\n                WHERE \n                    o.vendor = 'woocommerce'\n                    AND o.order_id = %d\n            ", $wcAbstractOrder->get_id()));
        $site_url = \get_site_url();
        $site_name = \get_bloginfo('name');
        $licenseItems = [];
        foreach ($licenseOrders as $licenseOrder) {
            $row = $wpdb->get_row($wpdb->prepare("\n                    SELECT *\n                    FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_licenses l\n                    WHERE l.id = %d\n                ", $licenseOrder->license_id));
            if (!$row) {
                continue;
            }
            $licenseItems[] = ['product_name' => wc_get_product($licenseOrder->product_id) ? wc_get_product($licenseOrder->product_id)->get_name() : null, 'expired_at' => $row->expired_at, 'license_key' => $row->license_key, 'token' => \base64_encode("{$site_url}\n{$site_name}\n{$row->license_key}")];
        }
        \do_action('f!yabe/ukiyo/ecommerce/platform/woocommerce/email:email_after_order_table', $licenseItems, $wcAbstractOrder, $plain_text, $email);
        if (!Config::get('ecommerce.woocommerce.print_receipt_email', \false)) {
            return;
        }
        $block_title = \apply_filters('f!yabe/ukiyo/ecommerce/platform/woocommerce/receipt.block_head', 'Bricks Template Licenses');
        ?>
        <table width="100%" border="0" cellpadding="0" cellspacing="0" style="width: 100%; vertical-align: top; margin-bottom: 40px; padding: 0;">
            <tbody>
                <tr>
                    <td style="text-align: left; border: 0; padding: 0;" valign="top">
                        <h2 style="color: #7f54b3; display: block; font-size: 18px; font-weight: bold; line-height: 130%; margin: 0 0 18px; text-align: left;"><?php 
        echo \esc_html($block_title);
        ?></h2>
                        <div style="padding: 12px; color: #636363; border: 1px solid #e5e5e5;">
                            <?php 
        foreach ($licenseItems as $licenseItem) {
            if ($licenseItem['product_name']) {
                ?>
                                    <br><b>Product:</b> <?php 
                echo \esc_html(wc_get_product($licenseOrder->product_id)->get_name());
                ?>
                                <?php 
            }
            if ($licenseItem['expired_at']) {
                ?>
                                    <br><b>Expire at:</b> <?php 
                echo \esc_html(\date('M d, Y', (int) $licenseItem['expired_at']));
                ?>
                                <?php 
            }
            ?>
                                <br><b>License Key:</b> <code><?php 
            echo \esc_html($licenseItem['license_key']);
            ?></code>
                                <br><b>Token:</b> <code><?php 
            echo \esc_html($licenseItem['token']);
            ?></code>
                                <br><br>
                            <?php 
        }
        ?>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>

<?php 
    }
}
