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
namespace _YabeUkiyo;

/**
 * Plugin constants.
 *
 * @since 1.0.0
 */
class YABE_UKIYO
{
    /**
     * @var string
     */
    public const FILE = __DIR__ . '/yabe-ukiyo.php';
    /**
     * @var string
     */
    public const VERSION = '2.0.7';
    /**
     * @var int
     */
    public const VERSION_ID = 20007;
    /**
     * @var int
     */
    public const MAJOR_VERSION = 2;
    /**
     * @var int
     */
    public const MINOR_VERSION = 0;
    /**
     * @var int
     */
    public const RELEASE_VERSION = 7;
    /**
     * @var string
     */
    public const EXTRA_VERSION = '';
    /**
     * @var string
     */
    public const WP_OPTION = 'ukiyo';
    /**
     * @var string
     */
    public const DB_TABLE_PREFIX = 'ukiyo';
    /**
     * The text domain should use the literal string 'yabe-ukiyo' as the text domain.
     * This constant is used for reference only and should not be used as the actual text domain.
     * 
     * @var string
     */
    public const TEXT_DOMAIN = 'yabe-ukiyo';
    /**
     * @var string
     */
    public const REST_NAMESPACE = 'yabe-ukiyo/v1';
    /**
     * @var array
     */
    public const EDD_STORE = ['store_url' => 'https://rosua.org', 'item_id' => 1404, 'author' => 'idrosua'];
}
/**
 * Plugin constants.
 *
 * @since 1.0.0
 */
\class_alias('_YabeUkiyo\\YABE_UKIYO', 'YABE_UKIYO', \false);
