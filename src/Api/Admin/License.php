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
use Yabe\Ukiyo\Utils\Common;
/**
 * @since 1.0.0
 */
class License extends AbstractApi implements ApiInterface
{
    public function __construct()
    {
    }
    public function get_prefix() : string
    {
        return 'admin/licenses';
    }
    public function register_custom_endpoints() : void
    {
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
        \register_rest_route(self::API_NAMESPACE, $this->get_prefix() . '/search_user', ['methods' => WP_REST_Server::READABLE, 'callback' => fn(WP_REST_Request $wprestRequest): WP_REST_Response => $this->search_user($wprestRequest), 'permission_callback' => fn(WP_REST_Request $wprestRequest): bool => $this->centralable_permission_callback($wprestRequest)]);
        \register_rest_route(self::API_NAMESPACE, $this->get_prefix() . '/sites/(?P<id>\\d+)', ['methods' => WP_REST_Server::READABLE, 'callback' => fn(WP_REST_Request $wprestRequest): WP_REST_Response => $this->sites($wprestRequest), 'permission_callback' => fn(WP_REST_Request $wprestRequest): bool => $this->centralable_permission_callback($wprestRequest)]);
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
            $where_clause[] = $wpdb->prepare("( l.title LIKE %s OR l.license_key LIKE %s )", $escaped_search, $escaped_search);
        }
        $where_clause = $where_clause !== [] ? 'WHERE ' . \implode(' AND ', $where_clause) : '';
        //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        $result = $wpdb->get_results($wpdb->prepare("SELECT l.*, COUNT(s.id) AS sites_count FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_licenses l LEFT JOIN {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_sites s ON s.license_id = l.id {$where_clause} GROUP BY l.id LIMIT %d OFFSET %d", $per_page, $offset));
        foreach ($result as $row) {
            $user = null;
            if ($row->user_id) {
                $found_user = \get_user_by('id', $row->user_id);
                if ($found_user) {
                    $user = (object) ['id' => (int) $found_user->ID, 'name' => $found_user->display_name, 'email' => $found_user->user_email];
                }
            }
            $items[] = ['id' => (int) $row->id, 'uid' => $row->uid, 'status' => (bool) $row->status, 'license_key' => $row->license_key, 'title' => $row->title, 'max_sites' => $row->max_sites ? (int) $row->max_sites : null, 'expired_at' => $row->expired_at ? (int) $row->expired_at : null, 'created_at' => (int) $row->created_at, 'updated_at' => (int) $row->updated_at, 'sites_count' => (int) $row->sites_count, 'user' => $user];
        }
        $total_exists = (int) $wpdb->get_var("\n            SELECT COUNT(*)\n            FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_licenses l\n        ");
        //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        $total_filtered = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_licenses l {$where_clause}");
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
        $expired_at = $payload['expired_at'] && \strtotime($payload['expired_at']) !== \false ? \strtotime($payload['expired_at']) : null;
        $max_sites = $payload['max_sites'] && (int) $payload['max_sites'] > 0 ? (int) $payload['max_sites'] : null;
        $user_id = isset($payload['user_id']) ? (int) $payload['user_id'] : null;
        $wpdb->insert(\sprintf('%s%s_licenses', $wpdb->prefix, $wpdb->yabe_ukiyo_prefix), ['uid' => Common::random_slug(10), 'title' => $title, 'license_key' => $license_key, 'status' => $status, 'expired_at' => $expired_at, 'max_sites' => $max_sites, 'user_id' => $user_id, 'created_at' => \time(), 'updated_at' => \time()], ['%s', '%s', '%s', '%d', '%d', '%d', '%d', '%d', '%d']);
        $id = $wpdb->insert_id;
        \do_action('a!yabe/ukiyo/api/admin/license:store', $id);
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
        $count = (int) $wpdb->get_var($wpdb->prepare("\n                SELECT COUNT(*)\n                FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_licenses l\n                WHERE id = %d\n            ", $id));
        if ($count === 0) {
            return new WP_REST_Response(['message' => \__('License not found', 'yabe-ukiyo')], 404, []);
        }
        $wpdb->update(\sprintf('%s%s_licenses', $wpdb->prefix, $wpdb->yabe_ukiyo_prefix), ['status' => $status], ['id' => $id], ['%d'], ['%d']);
        \do_action('a!yabe/ukiyo/api/admin/license:update_status', $id);
        return new WP_REST_Response(['id' => $id, 'status' => $status], 200, []);
    }
    private function destroy(WP_REST_Request $wprestRequest) : WP_REST_Response
    {
        /** @var wpdb $wpdb */
        global $wpdb;
        $url_params = $wprestRequest->get_url_params();
        $id = (int) $url_params['id'];
        $item = $wpdb->get_row($wpdb->prepare("\n                SELECT *\n                FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_licenses\n                WHERE id = %d\n            ", $id));
        if (!$item) {
            return new WP_REST_Response(['message' => \__('License not found', 'yabe-ukiyo')], 404, []);
        }
        $wpdb->delete(\sprintf('%s%s_licenses', $wpdb->prefix, $wpdb->yabe_ukiyo_prefix), ['id' => $id], ['%d']);
        \do_action('a!yabe/ukiyo/api/admin/license:destroy', $item);
        return new WP_REST_Response(null, 200, []);
    }
    private function detail(WP_REST_Request $wprestRequest) : WP_REST_Response
    {
        /** @var wpdb $wpdb */
        global $wpdb;
        $url_params = $wprestRequest->get_url_params();
        $id = (int) $url_params['id'];
        $row = $wpdb->get_row($wpdb->prepare("\n                SELECT \n                    l.*,\n                    COUNT(s.id) AS sites_count\n                FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_licenses l\n                LEFT JOIN {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_sites s ON s.license_id = l.id\n                WHERE l.id = %d\n                GROUP BY l.id\n            ", $id));
        if (!$row) {
            return new WP_REST_Response(['message' => \__('License not found', 'yabe-ukiyo')], 404, []);
        }
        $user = null;
        if ($row->user_id) {
            $found_user = \get_user_by('id', $row->user_id);
            if ($found_user) {
                $user = (object) ['id' => (int) $found_user->ID, 'name' => $found_user->display_name, 'email' => $found_user->user_email];
            }
        }
        $payload = ['id' => (int) $row->id, 'uid' => $row->uid, 'status' => (bool) $row->status, 'license_key' => $row->license_key, 'title' => $row->title, 'max_sites' => $row->max_sites ? (int) $row->max_sites : null, 'expired_at' => $row->expired_at ? (int) $row->expired_at : null, 'created_at' => (int) $row->created_at, 'updated_at' => (int) $row->updated_at, 'user' => $user, 'sites_count' => (int) $row->sites_count];
        return new WP_REST_Response($payload, 200, []);
    }
    private function update(WP_REST_Request $wprestRequest) : WP_REST_Response
    {
        /** @var wpdb $wpdb */
        global $wpdb;
        $url_params = $wprestRequest->get_url_params();
        $payload = $wprestRequest->get_json_params();
        $id = (int) $url_params['id'];
        $count = (int) $wpdb->get_var($wpdb->prepare("\n                SELECT COUNT(*)\n                FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_licenses l\n                WHERE id = %d\n            ", $id));
        if ($count === 0) {
            return new WP_REST_Response(['message' => \__('License not found', 'yabe-ukiyo')], 404, []);
        }
        $title = $payload['title'];
        $license_key = $payload['license_key'];
        $status = (bool) $payload['status'];
        $expired_at = $payload['expired_at'] && \strtotime($payload['expired_at']) !== \false ? \strtotime($payload['expired_at']) : null;
        $max_sites = $payload['max_sites'] && (int) $payload['max_sites'] > 0 ? (int) $payload['max_sites'] : null;
        $user_id = isset($payload['user_id']) ? (int) $payload['user_id'] : null;
        $wpdb->update(\sprintf('%s%s_licenses', $wpdb->prefix, $wpdb->yabe_ukiyo_prefix), ['title' => $title, 'license_key' => $license_key, 'status' => $status, 'expired_at' => $expired_at, 'max_sites' => $max_sites, 'user_id' => $user_id, 'updated_at' => \time()], ['id' => $id], ['%s', '%s', '%d', '%d', '%d', '%d', '%d'], ['%d']);
        \do_action('a!yabe/ukiyo/api/admin/license:update', $id);
        return new WP_REST_Response(['id' => $id], 200, []);
    }
    private function search_user(WP_REST_Request $wprestRequest) : WP_REST_Response
    {
        $url_params = $wprestRequest->get_params();
        $s = $url_params['s'];
        $args = ['search' => '*' . $s . '*', 'fields' => ['ID', 'user_login', 'user_email', 'user_nicename', 'display_name'], 'number' => 10];
        $users = \get_users($args);
        $items = [];
        foreach ($users as $user) {
            $items[] = ['id' => $user->ID, 'name' => $user->display_name, 'email' => $user->user_email];
        }
        return new WP_REST_Response(['data' => $items], 200, []);
    }
    private function sites(WP_REST_Request $wprestRequest) : WP_REST_Response
    {
        /** @var wpdb $wpdb */
        global $wpdb;
        $page = $wprestRequest->get_param('page') ? (int) \sanitize_text_field($wprestRequest->get_param('page')) : 1;
        $per_page = $wprestRequest->get_param('per_page') ? (int) \sanitize_text_field($wprestRequest->get_param('per_page')) : 20;
        $offset = $page * $per_page - $per_page;
        $search = $wprestRequest->get_param('search') ? \sanitize_text_field($wprestRequest->get_param('search')) : null;
        $id = (int) $wprestRequest->get_param('id');
        $where_clause = [];
        $where_clause[] = $wpdb->prepare('( s.license_id = %d )', $id);
        if ($search) {
            $escaped_search = '%' . $wpdb->esc_like($search) . '%';
            $where_clause[] = $wpdb->prepare("( s.site_url LIKE %s )", $escaped_search);
        }
        $where_clause = $where_clause !== [] ? 'WHERE ' . \implode(' AND ', $where_clause) : '';
        //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        $result = $wpdb->get_results($wpdb->prepare("SELECT s.* FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_sites s LEFT JOIN {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_licenses l ON l.id = s.license_id {$where_clause} GROUP BY s.id LIMIT %d OFFSET %d", $per_page, $offset));
        $items = [];
        foreach ($result as $row) {
            $items[] = ['id' => (int) $row->id, 'status' => (bool) $row->status, 'license_id' => (int) $row->license_id, 'site_url' => $row->site_url, 'created_at' => $row->created_at];
        }
        $total_exists = (int) $wpdb->get_var("\n            SELECT COUNT(*)\n            FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_sites s\n        ");
        //phpcs:ignore WordPress.DB.PreparedSQL.InterpolatedNotPrepared
        $total_filtered = (int) $wpdb->get_var("SELECT COUNT(*) FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_sites s {$where_clause}");
        $total_pages = \ceil($total_filtered / $per_page);
        $from = $items !== [] ? ($page - 1) * $per_page + 1 : null;
        $to = $items !== [] ? $from + \count($items) - 1 : null;
        return new WP_REST_Response(['data' => $items, 'meta' => ['page' => $page, 'per_page' => $per_page, 'search' => $search, 'total_pages' => $total_pages, 'from' => $from, 'to' => $to, 'total_filtered' => $total_filtered, 'total_exists' => $total_exists]], 200, ['X-WP-Total' => $total_filtered, 'X-WP-TotalPages' => $total_pages]);
    }
}
