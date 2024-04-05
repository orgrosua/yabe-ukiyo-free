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

use Throwable;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;
use wpdb;
use Yabe\Ukiyo\Api\AbstractApi;
use Yabe\Ukiyo\Api\ApiInterface;
use Yabe\Ukiyo\Utils\Common;
/**
 * @since 1.0.0
 */
class Remote extends AbstractApi implements ApiInterface
{
    public function __construct()
    {
    }
    public function get_prefix() : string
    {
        return 'admin/remotes';
    }
    public function register_custom_endpoints() : void
    {
        \register_rest_route(self::API_NAMESPACE, $this->get_prefix() . '/check-connection', ['methods' => WP_REST_Server::CREATABLE, 'callback' => fn(WP_REST_Request $wprestRequest): WP_REST_Response => $this->check_connection($wprestRequest), 'permission_callback' => fn(WP_REST_Request $wprestRequest): bool => $this->centralable_permission_callback($wprestRequest)]);
        \register_rest_route(self::API_NAMESPACE, $this->get_prefix() . '/index', ['methods' => WP_REST_Server::READABLE, 'callback' => fn(WP_REST_Request $wprestRequest): WP_REST_Response => $this->index($wprestRequest), 'permission_callback' => fn(WP_REST_Request $wprestRequest): bool => $this->centralable_permission_callback($wprestRequest)]);
        \register_rest_route(self::API_NAMESPACE, $this->get_prefix() . '/store', ['methods' => WP_REST_Server::CREATABLE, 'callback' => fn(WP_REST_Request $wprestRequest): WP_REST_Response => $this->store($wprestRequest), 'permission_callback' => fn(WP_REST_Request $wprestRequest): bool => $this->centralable_permission_callback($wprestRequest)]);
        \register_rest_route(self::API_NAMESPACE, $this->get_prefix() . '/update-status/(?P<id>\\d+)', ['methods' => WP_REST_Server::EDITABLE, 'callback' => fn(WP_REST_Request $wprestRequest): WP_REST_Response => $this->update_status($wprestRequest), 'permission_callback' => fn(WP_REST_Request $wprestRequest): bool => $this->centralable_permission_callback($wprestRequest), 'args' => ['status' => ['required' => \true, 'validate_callback' => static fn($param): bool => \is_bool($param)]]]);
        \register_rest_route(self::API_NAMESPACE, $this->get_prefix() . '/delete/(?P<id>\\d+)', [
            // 'methods' => WP_REST_Server::DELETABLE, // not working on IIS server without further configuration
            'methods' => 'POST, DELETE',
            'callback' => fn(WP_REST_Request $wprestRequest): WP_REST_Response => $this->destroy($wprestRequest),
            'permission_callback' => fn(WP_REST_Request $wprestRequest): bool => $this->centralable_permission_callback($wprestRequest),
        ]);
        \register_rest_route(self::API_NAMESPACE, $this->get_prefix() . '/detail/(?P<id>\\d+)', ['methods' => WP_REST_Server::READABLE, 'callback' => fn(WP_REST_Request $wprestRequest): WP_REST_Response => $this->detail($wprestRequest), 'permission_callback' => fn(WP_REST_Request $wprestRequest): bool => $this->centralable_permission_callback($wprestRequest)]);
        \register_rest_route(self::API_NAMESPACE, $this->get_prefix() . '/update/(?P<id>\\d+)', ['methods' => WP_REST_Server::EDITABLE, 'callback' => fn(WP_REST_Request $wprestRequest): WP_REST_Response => $this->update($wprestRequest), 'permission_callback' => fn(WP_REST_Request $wprestRequest): bool => $this->centralable_permission_callback($wprestRequest)]);
    }
    /**
     * Workaround to overcome the CORS issue.
     */
    private function check_connection(WP_REST_Request $wprestRequest) : WP_REST_Response
    {
        $payload = $wprestRequest->get_json_params();
        $remote_url = $payload['remote_url'];
        $resp = \wp_remote_get(\sprintf('%s/wp-json', $remote_url));
        if (\is_wp_error($resp)) {
            return new WP_REST_Response($resp->get_error_message(), 500);
        }
        $body = $resp['body'];
        if ($resp['response']['code'] === 200 && !\is_array($body)) {
            try {
                $body = \json_decode($body, null, 512, \JSON_THROW_ON_ERROR);
            } catch (Throwable $throwable) {
            }
        }
        // forward the response.
        return new WP_REST_Response($body, $resp['response']['code']);
    }
    private function index(WP_REST_Request $wprestRequest) : WP_REST_Response
    {
        /** @var wpdb $wpdb */
        global $wpdb;
        $page = $wprestRequest->get_param('page') ? (int) \sanitize_text_field($wprestRequest->get_param('page')) : 1;
        $per_page = $wprestRequest->get_param('per_page') ? (int) \sanitize_text_field($wprestRequest->get_param('per_page')) : 20;
        $offset = $page * $per_page - $per_page;
        $search = $wprestRequest->get_param('search') ? \sanitize_text_field($wprestRequest->get_param('search')) : null;
        $items = [];
        $where_clause = [];
        if ($search) {
            $escaped_search = '%' . $wpdb->esc_like($search) . '%';
            $where_clause[] = $wpdb->prepare("( r.title LIKE %s OR r.remote_url LIKE %s OR r.license_key LIKE %s )", $escaped_search, $escaped_search, $escaped_search);
        }
        $where_clause = $where_clause !== [] ? 'WHERE ' . \implode(' AND ', $where_clause) : '';
        $result = $wpdb->get_results(
            //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
            $wpdb->prepare("SELECT r.* FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_remotes r {$where_clause} LIMIT %d OFFSET %d", $per_page, $offset)
        );
        foreach ($result as $row) {
            $items[] = ['id' => (int) $row->id, 'status' => (bool) $row->status, 'title' => $row->title, 'remote_url' => $row->remote_url, 'license_key' => $row->license_key, 'created_at' => (int) $row->created_at, 'updated_at' => (int) $row->updated_at];
        }
        $total_exists = (int) $wpdb->get_var("\n            SELECT COUNT(*)\n            FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_remotes r\n        ");
        //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        $total_filtered = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_remotes r {$where_clause}");
        $total_pages = \ceil($total_filtered / $per_page);
        $from = $items !== [] ? ($page - 1) * $per_page + 1 : null;
        $to = $items !== [] ? $from + \count($items) - 1 : null;
        return new WP_REST_Response(['data' => $items, 'meta' => ['page' => $page, 'per_page' => $per_page, 'search' => $search, 'total_pages' => $total_pages, 'from' => $from, 'to' => $to, 'total_filtered' => $total_filtered, 'total_exists' => $total_exists]], 200, ['X-WP-Total' => $total_filtered, 'X-WP-TotalPages' => $total_pages]);
    }
    private function store(WP_REST_Request $wprestRequest) : WP_REST_Response
    {
        /** @var wpdb $wpdb */
        global $wpdb;
        $payload = $wprestRequest->get_json_params();
        $title = $payload['title'];
        $license_key = $payload['license_key'];
        $status = (bool) $payload['status'];
        $remote_url = $payload['remote_url'];
        $wpdb->insert(\sprintf('%s%s_remotes', $wpdb->prefix, $wpdb->yabe_ukiyo_prefix), ['uid' => Common::random_slug(10), 'title' => $title, 'license_key' => $license_key, 'remote_url' => $remote_url, 'status' => $status, 'created_at' => \time(), 'updated_at' => \time()], ['%s', '%s', '%s', '%s', '%d', '%d', '%d']);
        $id = $wpdb->insert_id;
        \do_action('a!yabe/ukiyo/api/admin/remote:store', $id);
        return new WP_REST_Response(['id' => $id], 200, []);
    }
    private function update_status(WP_REST_Request $wprestRequest) : WP_REST_Response
    {
        /** @var wpdb $wpdb */
        global $wpdb;
        $url_params = $wprestRequest->get_url_params();
        $payload = $wprestRequest->get_json_params();
        $id = (int) $url_params['id'];
        $status = (bool) $payload['status'];
        $count = (int) $wpdb->get_var($wpdb->prepare("\n                SELECT COUNT(*)\n                FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_remotes r\n                WHERE id = %d\n            ", $id));
        if ($count === 0) {
            return new WP_REST_Response(['message' => \__('Remote not found', 'yabe-ukiyo')], 404, []);
        }
        $wpdb->update(\sprintf('%s%s_remotes', $wpdb->prefix, $wpdb->yabe_ukiyo_prefix), ['status' => $status], ['id' => $id], ['%d'], ['%d']);
        \do_action('a!yabe/ukiyo/api/admin/remote:update_status', $id);
        return new WP_REST_Response(['id' => $id, 'status' => $status], 200, []);
    }
    private function destroy(WP_REST_Request $wprestRequest) : WP_REST_Response
    {
        /** @var wpdb $wpdb */
        global $wpdb;
        $url_params = $wprestRequest->get_url_params();
        $id = (int) $url_params['id'];
        $item = $wpdb->get_row($wpdb->prepare("\n                SELECT *\n                FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_remotes r\n                WHERE id = %d\n            ", $id));
        if (!$item) {
            return new WP_REST_Response(['message' => \__('Remote not found', 'yabe-ukiyo')], 404, []);
        }
        $wpdb->delete(\sprintf('%s%s_remotes', $wpdb->prefix, $wpdb->yabe_ukiyo_prefix), ['id' => $id], ['%d']);
        \do_action('a!yabe/ukiyo/api/admin/remote:destroy', $item);
        return new WP_REST_Response(null, 200, []);
    }
    private function detail(WP_REST_Request $wprestRequest) : WP_REST_Response
    {
        /** @var wpdb $wpdb */
        global $wpdb;
        $url_params = $wprestRequest->get_url_params();
        $id = (int) $url_params['id'];
        $row = $wpdb->get_row($wpdb->prepare("\n                SELECT *\n                FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_remotes r\n                WHERE id = %d\n            ", $id));
        if (!$row) {
            return new WP_REST_Response(['message' => \__('Remote not found', 'yabe-ukiyo')], 404, []);
        }
        $payload = ['id' => (int) $row->id, 'status' => (bool) $row->status, 'license_key' => $row->license_key, 'title' => $row->title, 'remote_url' => $row->remote_url, 'created_at' => (int) $row->created_at, 'updated_at' => (int) $row->updated_at];
        return new WP_REST_Response($payload, 200, []);
    }
    private function update(WP_REST_Request $wprestRequest) : WP_REST_Response
    {
        /** @var wpdb $wpdb */
        global $wpdb;
        $url_params = $wprestRequest->get_url_params();
        $payload = $wprestRequest->get_json_params();
        $id = (int) $url_params['id'];
        $count = (int) $wpdb->get_var($wpdb->prepare("\n                SELECT COUNT(*)\n                FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_remotes r\n                WHERE id = %d\n            ", $id));
        if ($count === 0) {
            return new WP_REST_Response(['message' => \__('Remote not found', 'yabe-ukiyo')], 404, []);
        }
        $title = $payload['title'];
        $license_key = $payload['license_key'];
        $remote_url = $payload['remote_url'];
        $status = (bool) $payload['status'];
        $wpdb->update(\sprintf('%s%s_remotes', $wpdb->prefix, $wpdb->yabe_ukiyo_prefix), ['title' => $title, 'license_key' => $license_key, 'remote_url' => $remote_url, 'status' => $status, 'updated_at' => \time()], ['id' => $id], ['%s', '%s', '%s', '%d', '%d'], ['%d']);
        \do_action('a!yabe/ukiyo/api/admin/remote:update', $id);
        return new WP_REST_Response(['id' => $id], 200, []);
    }
}
