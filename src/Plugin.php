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
namespace Yabe\Ukiyo;

use _YabeUkiyo\EDD_SL\PluginUpdater;
use Exception;
use _YabeUkiyo\YABE_UKIYO;
use WP_Upgrader;
use wpdb;
use Yabe\Ukiyo\Admin\AdminPage;
use Yabe\Ukiyo\Api\Router as ApiRouter;
use Yabe\Ukiyo\Core\Runtime;
use Yabe\Ukiyo\Ecommerce\Loader as PlatformLoader;
use Yabe\Ukiyo\Utils\Common;
use Yabe\Ukiyo\Utils\Debug;
use Yabe\Ukiyo\Utils\Notice;
/**
 * Manage the plugin lifecycle and provides a single point of entry to the plugin.
 *
 * @since 1.0.0
 */
final class Plugin
{
    /**
     * Easy Digital Downloads Software Licensing integration wrapper.
     * Pro version only.
     *
     * @var PluginUpdater|null
     */
    public $plugin_updater = null;
    /**
     * Stores the instance, implementing a Singleton pattern.
     */
    private static self $instance;
    /**
     * The Singleton's constructor should always be private to prevent direct
     * construction calls with the `new` operator.
     */
    private function __construct()
    {
    }
    /**
     * Singletons should not be cloneable.
     */
    private function __clone()
    {
    }
    /**
     * Singletons should not be restorable from strings.
     *
     * @throws Exception Cannot unserialize a singleton.
     */
    public function __wakeup()
    {
        throw new Exception('Cannot unserialize a singleton.');
    }
    /**
     * This is the static method that controls the access to the singleton
     * instance. On the first run, it creates a singleton object and places it
     * into the static property. On subsequent runs, it returns the client existing
     * object stored in the static property.
     */
    public static function get_instance() : self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    public function boot_debug()
    {
        if (!\WP_DEBUG) {
            return;
        }
        // if (class_exists(\Sentry\SentrySdk::class)) {
        // }
        // when php exits, call the shutdown function.
        \register_shutdown_function(static fn() => Debug::shutdown());
    }
    /**
     * Boot the plugin.
     *
     * @link https://codex.wordpress.org/Plugin_API/Action_Reference
     */
    public function boot() : void
    {
        \do_action('a!yabe/ukiyo/plugin:boot.start');
        $this->boot_migration();
        // (de)activation hooks.
        \register_activation_hook(YABE_UKIYO::FILE, fn() => $this->activate_plugin());
        \register_deactivation_hook(YABE_UKIYO::FILE, fn() => $this->deactivate_plugin());
        // upgrade hooks.
        \add_action('upgrader_process_complete', function (WP_Upgrader $wpUpgrader, array $options) : void {
            if ($options['action'] === 'update' && $options['type'] === 'plugin') {
                foreach ($options['plugins'] as $plugin) {
                    if ($plugin === \plugin_basename(YABE_UKIYO::FILE)) {
                        $this->upgrade_plugin();
                    }
                }
            }
        }, 10, 2);
        $this->maybe_update_plugin();
        \add_action('plugins_loaded', fn() => $this->plugins_loaded());
        \add_action('init', fn() => $this->init_plugin());
        \do_action('a!yabe/ukiyo/plugin:boot.end');
    }
    /**
     * Boot the database migration.
     *
     * Add the plugin's database table prefix to the global \wpdb object.
     * \wpdb class is marked with `#[\AllowDynamicProperties]` attribute
     * to allow dynamic properties to be added to the instance.
     */
    public function boot_migration()
    {
        \do_action('a!yabe/ukiyo/plugin:boot_migration.start');
        /** @var wpdb $wpdb */
        global $wpdb;
        $wpdb->yabe_ukiyo_prefix = YABE_UKIYO::DB_TABLE_PREFIX;
        new \Yabe\Ukiyo\Migration();
        \do_action('a!yabe/ukiyo/plugin:boot_migration.end');
    }
    /**
     * Initialize the plugin updater.
     * Pro version only.
     *
     * @return PluginUpdater
     */
    public function maybe_update_plugin()
    {
        if (!\class_exists(PluginUpdater::class)) {
            return null;
        }
        if ($this->plugin_updater instanceof \_YabeUkiyo\EDD_SL\PluginUpdater) {
            return $this->plugin_updater;
        }
        $license = \get_option(YABE_UKIYO::WP_OPTION . '_license', ['key' => '', 'opt_in_pre_release' => \false]);
        $this->plugin_updater = new PluginUpdater(YABE_UKIYO::WP_OPTION, ['version' => YABE_UKIYO::VERSION, 'license' => $license['key'] ? \trim($license['key']) : \false, 'beta' => $license['opt_in_pre_release'], 'plugin_file' => YABE_UKIYO::FILE, 'item_id' => YABE_UKIYO::EDD_STORE['item_id'], 'store_url' => YABE_UKIYO::EDD_STORE['store_url'], 'author' => YABE_UKIYO::EDD_STORE['author']]);
        return $this->plugin_updater;
    }
    /**
     * Handle the plugin's activation by (maybe) running database migrations
     * and initializing the plugin configuration.
     */
    private function activate_plugin() : void
    {
        \do_action('a!yabe/ukiyo/plugin:activate_plugin.start');
        \update_option(YABE_UKIYO::WP_OPTION . '_version', YABE_UKIYO::VERSION);
        $this->maybe_embedded_license();
        \do_action('a!yabe/ukiyo/plugin:activate_plugin.end');
    }
    /**
     * Handle plugin's deactivation by (maybe) cleaning up after ourselves.
     */
    private function deactivate_plugin() : void
    {
        \do_action('a!yabe/ukiyo/plugin:deactivate_plugin.start');
        \do_action('a!yabe/ukiyo/plugin:deactivate_plugin.end');
    }
    /**
     * Handle the plugin's upgrade by (maybe) running database migrations.
     */
    private function upgrade_plugin() : void
    {
        \do_action('a!yabe/ukiyo/plugin:upgrade_plugin.start');
        \do_action('a!yabe/ukiyo/plugin:upgrade_plugin.end');
    }
    /**
     * Initialize the plugin on WordPress' `init` hook.
     */
    private function init_plugin() : void
    {
        \do_action('a!yabe/ukiyo/plugin:init_plugin.start');
        // Load translations.
        \load_plugin_textdomain(YABE_UKIYO::TEXT_DOMAIN);
        // Instantiate the AdminPage class.
        new Runtime();
        new AdminPage();
        \do_action('a!yabe/ukiyo/plugin:init_plugin.end');
    }
    /**
     * Initialize the plugin on WordPress' `plugins_loaded` hook.
     */
    private function plugins_loaded() : void
    {
        \do_action('a!yabe/ukiyo/plugin:plugins_loaded.start');
        PlatformLoader::get_instance()->register_platforms();
        new ApiRouter();
        if (\is_admin()) {
            \add_action('admin_notices', static fn() => Notice::admin_notices());
            \add_filter('plugin_action_links_' . \plugin_basename(YABE_UKIYO::FILE), fn($links) => $this->plugin_action_links($links));
        }
        \do_action('a!yabe/ukiyo/plugin:plugins_loaded.end');
    }
    /**
     * Add plugin action links.
     *
     * @param array $links Plugin action links.
     * @return array Plugin action links.
     *
     * @todo Add settings link when the settings page is implemented.
     */
    private function plugin_action_links(array $links) : array
    {
        $base_url = AdminPage::get_page_url();
        \array_unshift($links, \sprintf('<a href="%s">%s</a>', \esc_url(\sprintf('%s#/settings', $base_url)), \esc_html__('Settings', 'yabe-ukiyo')));
        \array_unshift($links, \sprintf('<a href="%s">%s</a>', \esc_url(\sprintf('%s#/remotes/index', $base_url)), \esc_html__('Remote', 'yabe-ukiyo')));
        if (!\class_exists(PluginUpdater::class)) {
            \array_unshift($links, \sprintf('<a href="%s" style="color:#067b34;font-weight:600;" target="_blank">%s</a>', \esc_url(Common::plugin_data('PluginURI') . '?utm_source=WordPress&utm_campaign=liteplugin&utm_medium=plugin-action-links&utm_content=Upgrade#pricing'), \esc_html__('Upgrade to Pro', 'yabe-ukiyo')));
        }
        return $links;
    }
    /**
     * Check if the plugin distributed with an embedded license and activate the license.
     * Pro version only.
     */
    private function maybe_embedded_license() : void
    {
        if (!\class_exists(PluginUpdater::class)) {
            return;
        }
        $license_file = \dirname(YABE_UKIYO::FILE) . '/license-data.php';
        if (!\file_exists($license_file)) {
            return;
        }
        require_once $license_file;
        $const_name = 'ROSUA_EMBEDDED_LICENSE_KEY_' . YABE_UKIYO::EDD_STORE['item_id'];
        if (!\defined($const_name)) {
            return;
        }
        $license_key = \constant($const_name);
        \update_option(YABE_UKIYO::WP_OPTION . '_license', ['key' => $license_key, 'opt_in_pre_release' => \false]);
        \unlink($license_file);
        // activate the license.
        $this->maybe_update_plugin()->activate($license_key);
    }
}
