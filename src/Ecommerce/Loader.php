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

use Exception;
use ReflectionClass;
use _YabeUkiyo\Symfony\Component\Finder\Finder;
use _YabeUkiyo\YABE_UKIYO;
class Loader
{
    /**
     * List of Platforms services.
     *
     * @var PlatformInterface[]
     */
    private array $platforms = [];
    /**
     * Stores the instance, implementing a Singleton pattern.
     */
    private static self $instance;
    /**
     * The Singleton's constructor should always be private to prevent direct
     * construction calls with the `new` operator.
     */
    private function __construct()
    {
    }
    /**
     * Singletons should not be cloneable.
     */
    private function __clone()
    {
    }
    /**
     * Singletons should not be restorable from strings.
     *
     * @throws Exception Cannot unserialize a singleton.
     */
    public function __wakeup()
    {
        throw new Exception('Cannot unserialize a singleton.');
    }
    /**
     * This is the static method that controls the access to the singleton
     * instance. On the first run, it creates a singleton object and places it
     * into the static property. On subsequent runs, it returns the client existing
     * object stored in the static property.
     */
    public static function get_instance() : self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self();
            self::$instance->scan_platforms();
        }
        return self::$instance;
    }
    public function scan_platforms()
    {
        // Get cached Platforms
        $transient_name = 'ukiyo_scanned_platforms_' . YABE_UKIYO::VERSION;
        /** @var PlatformInterface[]|false $cached */
        $cached = \get_transient($transient_name);
        if (!\WP_DEBUG && $cached !== \false) {
            $this->platforms = $cached;
            return;
        }
        $finder = new Finder();
        $finder->files()->in(__DIR__ . '/Platform')->name('*.php');
        /**
         * Add additional places to scan for Platforms.
         *
         * @param Finder $finder The Finder instance.
         */
        \do_action('a!yabe/ukiyo/ecommerce/loader:scan_platforms.before_scan', $finder);
        foreach ($finder as $file) {
            $platform_file = $file->getPathname();
            if (!\is_readable($platform_file)) {
                continue;
            }
            require_once $platform_file;
        }
        // Find any Platforms that extends PlatformInterface class
        $declared_classes = \get_declared_classes();
        foreach ($declared_classes as $declared_class) {
            if (!\class_exists($declared_class)) {
                continue;
            }
            $reflector = new ReflectionClass($declared_class);
            if (!$reflector->isSubclassOf(\Yabe\Ukiyo\Ecommerce\PlatformInterface::class)) {
                continue;
            }
            // Get Platform detail and push to Router::$platforms to be register later
            /** @var PlatformInterface $platform */
            $platform = $reflector->newInstanceWithoutConstructor();
            $this->platforms[$platform->get_name()] = ['name' => $platform->get_name(), 'file_path' => $reflector->getFileName(), 'class_name' => $reflector->getName()];
        }
        // Cache the scanned Platforms
        \set_transient($transient_name, $this->platforms, \HOUR_IN_SECONDS);
    }
    /**
     * Register Platforms.
     */
    public function register_platforms() : void
    {
        /**
         * Filter the Platforms before register to WP Rest.
         *
         * @param PlatformInterface[] $platforms
         * @return PlatformInterface[]
         */
        /** @var PlatformInterface[] $platforms */
        $platforms = \apply_filters('f!yabe/ukiyo/ecommerce/loader:register_platforms', $this->platforms);
        foreach ($platforms as $platform) {
            // Create new instance of Platform class and register custom endpoints
            /** @var PlatformInterface $platformInstance */
            $platformInstance = new $platform['class_name']();
            $this->platforms[$platform['name']]['instance'] = $platformInstance;
        }
    }
    /**
     * Get the list of Platforms.
     *
     * @return PlatformInterface[]
     */
    public function get_platforms() : array
    {
        return $this->platforms;
    }
}
