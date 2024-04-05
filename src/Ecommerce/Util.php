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
namespace Yabe\Ukiyo\Ecommerce;

use wpdb;
/**
 * @since 1.0.0
 */
class Util
{
    /**
     * @param int $id The ID of the managed site
     * @return array|false
     */
    public static function find_managed_site(int $id)
    {
        if ($id === 0) {
            return \false;
        }
        /** @var wpdb $wpdb */
        global $wpdb;
        $row = $wpdb->get_row($wpdb->prepare("\n                SELECT *\n                FROM {$wpdb->prefix}{$wpdb->yabe_ukiyo_prefix}_central c\n                WHERE id = %d AND status = 1\n            ", $id));
        if (!$row) {
            return \false;
        }
        return ['id' => (int) $row->id, 'secret_key' => $row->secret_key, 'title' => $row->title, 'url' => $row->url];
    }
}
