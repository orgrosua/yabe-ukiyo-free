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
namespace Yabe\Ukiyo\Admin;

use _YabeUkiyo\EDD_SL\PluginUpdater;
use _YabeUkiyo\YABE_UKIYO;
use Yabe\Ukiyo\Ecommerce\Loader as PlatformLoader;
use Yabe\Ukiyo\Utils\Asset;
use Yabe\Ukiyo\Utils\AssetVite;
class AdminPage
{
    public function __construct()
    {
        \add_action('admin_menu', fn() => $this->add_admin_menu(), 1000001);
    }
    public static function get_page_url() : string
    {
        return \add_query_arg(['page' => YABE_UKIYO::WP_OPTION], \admin_url('admin.php'));
    }
    public function add_admin_menu()
    {
        $hook = \add_submenu_page('bricks', \__('Yabe Ukiyo', 'yabe-ukiyo'), \__('Yabe Ukiyo', 'yabe-ukiyo'), 'manage_options', YABE_UKIYO::WP_OPTION, fn() => $this->render(), 1000001);
        \add_action('load-' . $hook, fn() => $this->init_hooks());
    }
    private function render()
    {
        \add_filter('admin_footer_text', static fn($text) => 'Thank you for using <b>Ukiyo</b>! Join us on the <a href="https://www.facebook.com/groups/1142662969627943" target="_blank">Facebook Group</a>.', 1000001);
        \add_filter('update_footer', static fn($text) => $text . ' | Ukiyo ' . YABE_UKIYO::VERSION, 1000001);
        echo '<div id="ukiyo-app" class=""></div>';
    }
    private function init_hooks()
    {
        \add_action('admin_head', static fn() => \remove_action('admin_notices', 'update_nag', 3), 1);
        \add_action('admin_enqueue_scripts', fn() => $this->enqueue_scripts(), 1000001);
    }
    private function enqueue_scripts()
    {
        $handle = YABE_UKIYO::WP_OPTION . ':app';
        AssetVite::get_instance()->enqueue_asset('assets/app.js', ['handle' => $handle, 'in_footer' => \true]);
        \wp_set_script_translations($handle, 'yabe-ukiyo');
        \wp_localize_script($handle, 'ukiyo', ['_version' => YABE_UKIYO::VERSION, '_wpnonce' => \wp_create_nonce(YABE_UKIYO::WP_OPTION), 'web_history' => self::get_page_url(), 'rest_api' => ['nonce' => \wp_create_nonce('wp_rest'), 'root' => \esc_url_raw(\rest_url()), 'namespace' => YABE_UKIYO::REST_NAMESPACE, 'url' => \esc_url_raw(\rest_url(YABE_UKIYO::REST_NAMESPACE))], 'assets' => ['url' => AssetVite::asset_base_url()], 'site_meta' => ['name' => \get_bloginfo('name'), 'site_url' => \get_site_url()], 'lite_edition' => !\class_exists(PluginUpdater::class), 'ecommerce' => ['platforms' => \array_keys(PlatformLoader::get_instance()->get_platforms())]]);
    }
}
