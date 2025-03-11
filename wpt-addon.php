<?php
/**
 * Plugin Name: Wpt Addon
 * Plugin URI: https://wpthinkers.com
 * Description: W-Pro Themes addon for elementor. This plugin develop by MD AL AMIN ISLAM. You can add extra functionality using this plugin.
 * Version: 1.0.3
 * Author: Md. Al-Amin Islam
 * Author URI: https://wpthinkers.com
 * Text Domain: wpt-addon
 */

if( ! defined( 'ABSPATH' ) ) exit();

define( 'WPT_PLUGIN_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );
define( 'WPT_PLUGIN_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );

require_once WPT_PLUGIN_PATH . '/inc/Classes/Activate.php';

register_activation_hook( 'Activate', 'activate' );

require_once WPT_PLUGIN_PATH . '/inc/Classes/Deactivate.php';

register_deactivation_hook( 'Deactivate', 'deactivate' );


require_once WPT_PLUGIN_PATH . '/inc/init.php';

// Initialize the plugin
Init::instance();

