<?php

/**
 * Yabe Ukiyo - Bricks remote templates manager
 *
 * @wordpress-plugin
 * Plugin Name:         Yabe Ukiyo
 * Plugin URI:          https://ukiyo.yabe.land
 * Description:         Bricks remote templates manager
 * Version:             2.0.7
 * Requires at least:   6.0
 * Requires PHP:        7.4
 * Author:              Rosua
 * Author URI:          https://rosua.org
 * License:             GPLv3
 * License URI:         https://www.gnu.org/licenses/gpl-3.0.html
 * Donate link:         https://ko-fi.com/Q5Q75XSF7
 * Text Domain:         yabe-ukiyo
 * Domain Path:         /languages
 *
 * @package             Yabe
 * @author              Joshua Gugun Siagian <suabahasa@gmail.com>
 */
declare (strict_types=1);
namespace _YabeUkiyo;

use Yabe\Ukiyo\Plugin;
use Yabe\Ukiyo\Utils\Requirement;
\defined('ABSPATH') || exit;
if (\file_exists(__DIR__ . '/vendor/scoper-autoload.php')) {
    require_once __DIR__ . '/vendor/scoper-autoload.php';
} else {
    require_once __DIR__ . '/vendor/autoload.php';
}
$requirement = new Requirement();
$requirement->php('7.4')->wp('6.0')->theme('bricks', '1.8.6');
if ($requirement->met()) {
    Plugin::get_instance()->boot();
} else {
    \add_action('admin_notices', fn() => $requirement->printNotice(), 0, 0);
}
