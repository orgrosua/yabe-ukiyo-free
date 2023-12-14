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

use _YabeUkiyo\YABE_UKIYO;
use WP_Post;
/**
 * @since 1.0.0
 */
class Metabox
{
    public function __construct()
    {
        \add_action('add_meta_boxes', fn() => $this->register_metabox(), 1000001);
        \add_action('save_post', fn(int $postId) => $this->save_post($postId), 1000001);
    }
    public function register_metabox() : void
    {
        \add_meta_box('ukiyo_metabox_wc', 'Yabe Ukiyo', fn(WP_Post $wpPost) => $this->render_metabox($wpPost), 'product', 'side', 'default');
    }
    public function save_post(int $postId) : void
    {
        if (!\array_key_exists('post_type', $_POST) || $_POST['post_type'] !== 'product' || !\array_key_exists('ukiyo_wpnonce', $_POST) || !\wp_verify_nonce(\sanitize_text_field(\wp_unslash($_POST['ukiyo_wpnonce'])), YABE_UKIYO::WP_OPTION)) {
            return;
        }
        \update_post_meta($postId, 'ukiyo_should_generate', (int) \array_key_exists('ukiyo_should_generate', $_POST));
        \update_post_meta($postId, 'ukiyo_should_renewal', (int) \array_key_exists('ukiyo_should_renewal', $_POST));
        \update_post_meta($postId, 'ukiyo_max_sites', (int) isset($_POST['ukiyo_max_sites']) && \sanitize_text_field($_POST['ukiyo_max_sites']) > 0 ? \sanitize_text_field($_POST['ukiyo_max_sites']) : 0);
        \update_post_meta($postId, 'ukiyo_active_duration', (int) isset($_POST['ukiyo_active_duration']) && \sanitize_text_field($_POST['ukiyo_active_duration']) > 0 ? \sanitize_text_field($_POST['ukiyo_active_duration']) : 0);
    }
    private function render_metabox(WP_Post $wpPost) : void
    {
        $should_generate = \get_post_meta($wpPost->ID, 'ukiyo_should_generate', \true) ? 'checked' : '';
        $should_renewal = \get_post_meta($wpPost->ID, 'ukiyo_should_renewal', \true) ? 'checked' : '';
        $max_sites = (int) \get_post_meta($wpPost->ID, 'ukiyo_max_sites', \true);
        $active_duration = (int) \get_post_meta($wpPost->ID, 'ukiyo_active_duration', \true);
        ?>
            <div class="ukiyo-container">
                <?php 
        \wp_nonce_field(YABE_UKIYO::WP_OPTION, 'ukiyo_wpnonce', \false);
        ?>
                <div>
                    <p><strong>Generate?</strong></p>
                    <label for="ukiyo_should_generate">
                        <input type="checkbox" name="ukiyo_should_generate" id="ukiyo_should_generate" <?php 
        echo \esc_html($should_generate);
        ?>>
                        Generate the license automatically
                    </label>
                </div>

                <div>
                    <p><strong>Renewal?</strong></p>
                    <label for="ukiyo_should_renewal">
                        <input type="checkbox" name="ukiyo_should_renewal" id="ukiyo_should_renewal" <?php 
        echo \esc_html($should_renewal);
        ?>>
                        Allow license renewal
                        <span class="dashicons dashicons-editor-help" title="Extend the expiry date for the existing license for the renewal order."></span>
                    </label>
                </div>

                <div>
                    <p>
                        <strong>Max Activations</strong>
                        <span class="dashicons dashicons-editor-help" title="Keep empty or 0 to allow unlimited activations."></span>
                    </p>
                    <input type="number" name="ukiyo_max_sites" id="ukiyo_max_sites" value="<?php 
        echo \esc_attr($max_sites);
        ?>" min="0">
                </div>

                <div>
                    <p>
                        <strong>Duration</strong>
                        <span class="dashicons dashicons-editor-help" title="The duration of the license is in days. Keep empty or 0 to have no expiration date."></span>
                    </p>
                    <div>
                        <input type="number" name="ukiyo_active_duration" id="ukiyo_active_duration" value="<?php 
        echo \esc_attr($active_duration);
        ?>" min="0">
                         days
                    </div>
                    </label>
                </div>
            </div>

            <style>
                .ukiyo-container {
                    display: grid;
                    grid-template-columns: repeat(1, 1fr);
                    gap: 10px;
                }

                #ukiyo_max_sites,
                #ukiyo_active_duration {
                    max-width: 100%;
                }

                /* revert Oxygen style */
                #editor .postbox > .postbox-header:hover {
                    background: transparent !important;
                }
            </style>

        <?php 
    }
}
