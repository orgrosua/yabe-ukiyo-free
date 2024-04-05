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
namespace Yabe\Ukiyo\Utils;

/**
 * Central Management utility functions for the plugin.
 *
 * @since 1.0.0
 */
class CentralManagement
{
    public static function validate_permission($secret_key) : bool
    {
        $is_enabled = \Yabe\Ukiyo\Utils\Config::get('central_management.enabled', \false);
        if (!$is_enabled) {
            return \false;
        }
        $key = \Yabe\Ukiyo\Utils\Config::get('central_management.secret_key', null);
        if ($key === null) {
            return \false;
        }
        return $key === $secret_key;
    }
}
