<?php
namespace Wpt;
use Elementor;

class Plugin_Loaded{
    // Plugin version
    const VERSION = '1.0.3';

    // Minimum Elementor Version
    const MINIMUM_ELEMENTOR_VERSION = '3.0.0';

    // Minimum PHP Version
    const MINIMUM_PHP_VERSION = '7.5';

    public function __construct() {
        add_action( 'plugin_loaded', array($this, 'init') );
    }

    /**
    * Initialize the plugin
    * @since 1.0.3
    */
    public function init() {
        if( ! did_action( 'elementor/loaded' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_missing_main_plugin' ] );
            return;
        }
        if( ! version_compare( ELEMENTOR_VERSION, self::MINIMUM_ELEMENTOR_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_elementor_version' ] );
            return;
        }

        if( ! version_compare( PHP_VERSION, self::MINIMUM_PHP_VERSION, '>=' ) ) {
            add_action( 'admin_notices', [ $this, 'admin_notice_minimum_php_version' ] );
            return;
        }

        add_action( 'elementor/init', [ $this, 'init_category' ] );
        add_action( 'elementor/widgets/widgets_registered', [ $this, 'init_widgets' ] );
    }

    /**
    * Init Widgets
    * @since 1.0.3
    */
    public function init_widgets() {
        require_once WPT_PLUGIN_PATH . '/widgets/wpt-coverflow-slider.php';
        require_once WPT_PLUGIN_PATH . '/widgets/wpt-accordion.php';
        require_once WPT_PLUGIN_PATH . '/widgets/wpt-team-card.php';
        require_once WPT_PLUGIN_PATH . '/widgets/wpt-package-tab.php';
    }

    /**
    * Init Category Section
    * @since 1.0.3
    */
    public function init_category() {
        Elementor\Plugin::instance()->elements_manager->add_category(
            'wpt-for-elementor',
            [
                'title' => 'Wpt Addon'
            ],
            1
        );
    }

    /**
    * Admin Notice for Missing Main Plugin
    * @since 1.0.3
    */
    public function admin_notice_missing_main_plugin() {
        if( isset( $_GET[ 'activate' ] ) ) unset( $_GET[ 'activate' ] );
        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" to be installed and activated', 'wpt-addon' ),
            '<strong>'.esc_html__( 'WPT Addon', 'wpt-addon' ).'</strong>',
            '<strong>'.esc_html__( 'Elementor', 'wpt-addon' ).'</strong>'
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
    * Admin Notice for Minimum Elementor Version
    * @since 1.0.3
    */
    public function admin_notice_minimum_elementor_version() {
        if( isset( $_GET[ 'activate' ] ) ) unset( $_GET[ 'activate' ] );
        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater', 'wpt-addon' ),
            '<strong>'.esc_html__( 'WPT Addon', 'wpt-addon' ).'</strong>',
            '<strong>'.esc_html__( 'Elementor', 'wpt-addon' ).'</strong>',
            self::MINIMUM_ELEMENTOR_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }

    /**
    * Admin Notice for Minimum PHP Version
    * @since 1.0.3
    */
    public function admin_notice_minimum_php_version() {
        if( isset( $_GET[ 'activate' ] ) ) unset( $_GET[ 'activate' ] );
        $message = sprintf(
            esc_html__( '"%1$s" requires "%2$s" version %3$s or greater', 'wpt-addon' ),
            '<strong>'.esc_html__( 'WPT Addon', 'wpt-addon' ).'</strong>',
            '<strong>'.esc_html__( 'PHP', 'wpt-addon' ).'</strong>',
            self::MINIMUM_PHP_VERSION
        );

        printf( '<div class="notice notice-warning is-dismissible"><p>%1$s</p></div>', $message );
    }
}