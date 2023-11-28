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

use _YabeUkiyo\YABE_UKIYO;
class AbstractApi
{
    /**
     * @var string
     */
    public const API_NAMESPACE = YABE_UKIYO::REST_NAMESPACE;
}
