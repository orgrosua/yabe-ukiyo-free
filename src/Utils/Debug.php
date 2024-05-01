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

use _YabeUkiyo\Symfony\Component\Stopwatch\Stopwatch;
use Throwable;
/**
 * Debug tools for the plugin.
 *
 * @since 1.0.0
 */
class Debug
{
    /**
     * The stopwatch instance.
     */
    private static Stopwatch $stopwatch_instance;
    /**
     * Get the stopwatch instance.
     */
    public static function stopwatch() : Stopwatch
    {
        if (!isset(self::$stopwatch_instance)) {
            self::$stopwatch_instance = new Stopwatch(\true);
        }
        return self::$stopwatch_instance;
    }
    public static function shutdown()
    {
        if (isset(self::$stopwatch_instance)) {
            self::shutdown_stopwatch();
        }
    }
    public static function shutdown_stopwatch()
    {
        $stopwatchEvent = self::stopwatch()->getSectionEvents('__root__');
        if ($stopwatchEvent === []) {
            return;
        }
        $log = '=== ' . \date('Y-m-d H:i:s', \time()) . ' ===' . \PHP_EOL;
        foreach ($stopwatchEvent as $ev) {
            $log .= (string) $ev . \PHP_EOL;
        }
        $log .= \PHP_EOL;
        $path = \wp_upload_dir()['basedir'] . '/ukiyo/debug/stopwatch.log';
        try {
            \Yabe\Ukiyo\Utils\Common::save_file($log, $path, \FILE_APPEND);
        } catch (Throwable $throwable) {
        }
    }
    public static function log(string $message, string $type = 'info')
    {
        if (!\defined('WP_DEBUG') || \WP_DEBUG === \false) {
            return;
        }
        $log = '[' . \date('d-M-Y H:i:s e') . '] [' . \strtoupper($type) . '] ' . $message . \PHP_EOL;
        $path = \wp_upload_dir()['basedir'] . '/ukiyo/debug/log.log';
        try {
            \Yabe\Ukiyo\Utils\Common::save_file($log, $path, \FILE_APPEND);
        } catch (Throwable $throwable) {
        }
    }
}
