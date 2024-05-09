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
namespace Yabe\Ukiyo\Core;

use Bricks\Api as BricksApi;
use Bricks\Templates as BricksTemplates;
use Bricks\Theme_Styles as BricksThemeStyles;
use WP_REST_Request;
use wpdb;
use Yabe\Ukiyo\Utils\Common;
/**
 * The server-side runtime.
 *
 * @version 1.8.6
 */
class Server
{
    public function __construct()
    {
        \add_action('rest_api_init', fn() => $this->register_custom_endpoints(), 1000001);
    }
    /**
     * Get all templates data (templates, authors, bundles, tags etc.).
     * This endpoint is override the Bricks' endpoint.
     *
     * @see \Bricks\Api::get_templates_data()
     */
    public function register_custom_endpoints()
    {
        \register_rest_route(BricksApi::API_NAMESPACE, '/get-templates-data/', ['methods' => 'GET', 'callback' => fn(WP_REST_Request $wprestRequest): array => $this->get_templates_data($wprestRequest), 'permission_callback' => static fn() => \true], \true);
    }
    /**
     * Return all templates data in one call (templates, authors, bundles, tags, theme style)
     * Unmodified.
     *
     * @see \Bricks\Api::get_templates_data()
     */
    private function get_templates_data(WP_REST_Request $wprestRequest) : array
    {
        $templates_args = $wprestRequest['args'] ?? [];
        $templates = $this->get_templates($templates_args);
        // STEP: Check for template error
        if (isset($templates['error'])) {
            return $templates;
        }
        $theme_styles = \get_option(\BRICKS_DB_THEME_STYLES, \false);
        $global_classes = \get_option(\BRICKS_DB_GLOBAL_CLASSES, []);
        // STEP: Add theme style to template data to import when inserting a template (@since 1.3.2)
        foreach ($templates as $index => $template) {
            $theme_style_id = BricksThemeStyles::set_active_style($template['id'], \true);
            $theme_style = $theme_styles[$theme_style_id] ?? \false;
            if ($theme_style) {
                // Remove theme style conditions
                if (isset($theme_style['settings']['conditions'])) {
                    unset($theme_style['settings']['conditions']);
                }
                $theme_style['id'] = $theme_style_id;
                $templates[$index]['themeStyle'] = $theme_style;
            }
            /**
             * Loop over all template elements to add 'global_classes' data to remote template data
             *
             * To import global classes when importing remote template locally.
             *
             * @since 1.5
             */
            if ((\is_countable($global_classes) ? \count($global_classes) : 0) > 0) {
                $template_classes = [];
                $template_elements = [];
                if (!empty($template['content']) && \is_array($template['content'])) {
                    $template_elements = $template['content'];
                } elseif (!empty($template['header']) && \is_array($template['header'])) {
                    $template_elements = $template['header'];
                } elseif (!empty($template['footer']) && \is_array($template['footer'])) {
                    $template_elements = $template['footer'];
                }
                foreach ($template_elements as $template_element) {
                    if (!empty($template_element['settings']['_cssGlobalClasses'])) {
                        $template_classes = \array_unique(\array_merge($template_classes, $template_element['settings']['_cssGlobalClasses']));
                    }
                }
                if ($template_classes !== []) {
                    $templates[$index]['global_classes'] = [];
                    foreach ($template_classes as $template_class) {
                        foreach ($global_classes as $global_class) {
                            if ($global_class['id'] === $template_class) {
                                $templates[$index]['global_classes'][] = $global_class;
                            }
                        }
                    }
                }
            }
        }
        // Return all templates data
        $templates_data = ['timestamp' => \current_time('timestamp'), 'date' => \current_time(\get_option('date_format') . ' (' . \get_option('time_format') . ')'), 'templates' => $templates, 'authors' => BricksTemplates::get_template_authors(), 'bundles' => BricksTemplates::get_template_bundles(), 'tags' => BricksTemplates::get_template_tags()];
        $templates_data = \apply_filters('bricks/api/get_templates_data', $templates_data);
        // Remove 'get' data to avoid storing it in db
        unset($templates_data['get']);
        return $templates_data;
    }
    /**
     * Return templates array OR specific template by array index.
     * Check access with Yabe implementation.
     *
     * @see \Bricks\Api::get_templates()
     */
    private function get_templates($data)
    {
        $parameters = [];
        if (isset($_GET['site'])) {
            $parameters['site'] = \esc_url_raw($_GET['site']);
        }
        if (isset($_GET['password'])) {
            $parameters['password'] = \sanitize_text_field($_GET['password']);
        }
        if (isset($_GET['licenseKey'])) {
            $parameters['licenseKey'] = \sanitize_text_field($_GET['licenseKey']);
        }
        $templates_response = $this->can_get_templates($parameters);
        if ($templates_response === \false) {
            $templates_response = BricksTemplates::can_get_templates($parameters);
        }
        // Check for templates error (no site/password etc. provided)
        if (isset($templates_response['error'])) {
            return $templates_response;
        }
        $templates_args = $data['args'] ?? [];
        // Merge $parameters with $templates_response args
        $templates_args = \array_merge($templates_args, $templates_response);
        return BricksTemplates::get_templates($templates_args);
    }
    /**
     * Check if site can get templates (with Yabe Bricks implementation).
     * Register site if necessary.
     *
     * @return array|false False to use the default implementation. Array with 'error' key on error. Array with 'site' and 'password' on success.
     */
    private function can_get_templates(array $parameters)
    {
        /** @var wpdb $wpdb */
        global $wpdb;
        $site_url = isset($parameters['site']) && !empty($parameters['site']) ? \trailingslashit(\trim($parameters['site'])) : \false;
        $password = $parameters['password'] ?? \false;
        // no site or password provided, return false to use the default implementation
        if (!$site_url || !$password) {
            return \false;
        }
        $license = $wpdb->get_row($wpdb->prepare("\n                SELECT *\n                FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_licenses l\n                WHERE l.license_key = %s\n            ", $password));
        // license not found, return false to use the default implementation
        if (!$license) {
            return \false;
        }
        // license is disabled, return error
        if (!(bool) $license->status) {
            return ['error' => ['code' => 'license_disabled', 'message' => \__('Sorry, the license is disabled.', 'yabe-ukiyo')]];
        }
        // license is expired, return error
        if ($license->expired_at && $license->expired_at < \time()) {
            return ['error' => ['code' => 'license_expired', 'message' => \esc_html__('Your license has expired.', 'yabe-ukiyo')]];
        }
        $sites = $wpdb->get_results($wpdb->prepare("\n                SELECT *\n                FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_sites s\n                WHERE s.license_id = %d\n            ", $license->id), \OBJECT_K);
        $site = \false;
        // find site by url
        foreach ($sites as $s) {
            if (\trailingslashit(\trim($s->site_url)) === $site_url) {
                $site = $s;
                break;
            }
        }
        // site not found, register site
        if (!$site) {
            // max sites limit reached, return error
            if ($license->max_sites && $license->max_sites <= ($sites === null ? 0 : (\is_countable($sites) ? \count($sites) : 0))) {
                return ['error' => ['code' => 'license_max_sites_reached', 'message' => \esc_html__('You have reached the maximum number of sites for this license.', 'yabe-ukiyo')]];
            }
            // register site
            $wpdb->insert(\sprintf('%s%s_sites', $wpdb->prefix, $wpdb->yabe_ukiyo_prefix), ['uid' => Common::random_slug(10), 'status' => 1, 'license_id' => $license->id, 'site_url' => $site_url, 'created_at' => \time()], ['%s', '%d', '%d', '%s', '%d']);
            $site = $wpdb->get_row($wpdb->prepare("\n                    SELECT *\n                    FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_sites s\n                    WHERE s.id = %d\n                ", $wpdb->insert_id));
        }
        // site disabled, return error
        if (!(bool) $site->status) {
            return ['error' => ['code' => 'site_disabled', 'message' => \__('Sorry, your site is disabled.', 'yabe-ukiyo')]];
        }
        return ['site' => $site, 'password' => $password];
    }
}
