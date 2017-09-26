<?php
/**
 * Plugin Name: BuddyPress Notifications
 * Plugin URI:  https://mamaduka.com/
 * Description: More extendable replacement of default BuddyPress notifications.
 * Author:      George Mamadashvili
 * Author URI:  https://mamaduka.com/
 * Version:     0.1.0
 * License:     MIT
 * License URI: https://opensource.org/licenses/MIT
 */

namespace Mamaduka\BpNotifications;

require __DIR__ . '/vendor/autoload.php';

PluginFactory::create()->register();