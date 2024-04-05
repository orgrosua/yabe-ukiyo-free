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
namespace Yabe\Ukiyo\Api;

use WP_REST_Request;
use Yabe\Ukiyo\Utils\CentralManagement;
use _YabeUkiyo\YABE_UKIYO;
class AbstractApi
{
    /**
     * @var string
     */
    public const API_NAMESPACE = YABE_UKIYO::REST_NAMESPACE;
    public function permission_callback(WP_REST_Request $wprestRequest) : bool
    {
        return \wp_verify_nonce(\sanitize_text_field(\wp_unslash($wprestRequest->get_header('X-WP-Nonce'))), 'wp_rest') && \current_user_can('manage_options');
    }
    public function centralable_permission_callback(WP_REST_Request $wprestRequest) : bool
    {
        // if header X-Ukiyo-Central is set, then it's from the central server
        if ($wprestRequest->get_header('X-Ukiyo-Central')) {
            return CentralManagement::validate_permission($wprestRequest->get_header('X-Ukiyo-Central'));
        }
        return $this->permission_callback($wprestRequest);
    }
}
