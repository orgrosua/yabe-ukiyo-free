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
namespace Yabe\Ukiyo\Api\Admin;

use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;
use wpdb;
use Yabe\Ukiyo\Api\AbstractApi;
use Yabe\Ukiyo\Api\ApiInterface;
/**
 * @since 1.0.0
 */
class Site extends AbstractApi implements ApiInterface
{
    public function __construct()
    {
    }
    public function get_prefix() : string
    {
        return 'admin/sites';
    }
    public function register_custom_endpoints() : void
    {
        \register_rest_route(self::API_NAMESPACE, $this->get_prefix() . '/update-status/(?P<id>\\d+)', ['methods' => WP_REST_Server::EDITABLE, 'callback' => fn(WP_REST_Request $wprestRequest): WP_REST_Response => $this->update_status($wprestRequest), 'permission_callback' => fn(WP_REST_Request $wprestRequest): bool => $this->centralable_permission_callback($wprestRequest), 'args' => ['status' => ['required' => \true, 'validate_callback' => static fn($param): bool => \is_bool($param)]]]);
        \register_rest_route(self::API_NAMESPACE, $this->get_prefix() . '/delete/(?P<id>\\d+)', [
            // 'methods' => WP_REST_Server::DELETABLE, // not working on IIS server without further configuration
            'methods' => 'POST, DELETE',
            'callback' => fn(WP_REST_Request $wprestRequest): WP_REST_Response => $this->destroy($wprestRequest),
            'permission_callback' => fn(WP_REST_Request $wprestRequest): bool => $this->centralable_permission_callback($wprestRequest),
        ]);
    }
    private function update_status(WP_REST_Request $wprestRequest) : WP_REST_Response
    {
        /** @var wpdb $wpdb */
        global $wpdb;
        $url_params = $wprestRequest->get_url_params();
        $payload = $wprestRequest->get_json_params();
        $id = (int) $url_params['id'];
        $status = (bool) $payload['status'];
        $count = (int) $wpdb->get_var($wpdb->prepare("\n                SELECT COUNT(*)\n                FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_sites s\n                WHERE id = %d\n            ", $id));
        if ($count === 0) {
            return new WP_REST_Response(['message' => \__('Site not found', 'yabe-ukiyo')], 404, []);
        }
        $wpdb->update(\sprintf('%s%s_sites', $wpdb->prefix, $wpdb->yabe_ukiyo_prefix), ['status' => $status], ['id' => $id], ['%d'], ['%d']);
        \do_action('a!yabe/ukiyo/api/admin/site:update_status', $id);
        return new WP_REST_Response(['id' => $id, 'status' => $status], 200, []);
    }
    private function destroy(WP_REST_Request $wprestRequest) : WP_REST_Response
    {
        /** @var wpdb $wpdb */
        global $wpdb;
        $url_params = $wprestRequest->get_url_params();
        $id = (int) $url_params['id'];
        $item = $wpdb->get_row($wpdb->prepare("\n                SELECT *\n                FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_sites s\n                WHERE id = %d\n            ", $id));
        if (!$item) {
            return new WP_REST_Response(['message' => \__('License not found', 'yabe-ukiyo')], 404, []);
        }
        $wpdb->delete(\sprintf('%s%s_sites', $wpdb->prefix, $wpdb->yabe_ukiyo_prefix), ['id' => $id], ['%d']);
        \do_action('a!yabe/ukiyo/api/admin/site:destroy', $item);
        return new WP_REST_Response(null, 200, []);
    }
}
