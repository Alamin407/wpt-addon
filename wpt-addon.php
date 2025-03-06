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

final class Wpt_Addon {

    // Plugin version
    const VERSION = '1.0.0';

    // Minimum Elementor Version
    const MINIMUM_ELEMENTOR_VERSION = '2.0.0';

    // Minimum PHP Version
    const MINIMUM_PHP_VERSION = '7.0';

    // Instance
    private static $_instance = null;

    /**
    * Singleton Instance Method
    * @since 1.0.0
    */
    public static function instance() {
        if( is_null( self::$_instance ) ) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
    * Constructor Method
    * @since 1.0.0
    */
    public function __construct() {
        // Call Constants Method
        $this->define_constants();
        add_action( 'wp_enqueue_scripts', [ $this, 'scripts_styles' ] );
        add_action( 'init', [ $this, 'i18n' ] );
        add_action( 'plugins_loaded', [ $this, 'init' ] );

        // Team Ajax Query
        add_action( 'wp_ajax_load_speaker_details', [ $this, 'load_speaker_details' ] );
        add_action( 'wp_ajax_nopriv_load_speaker_details', [ $this, 'load_speaker_details' ] );

        // Package Tab Ajax Query
        add_action( 'wp_ajax_load_package_tabs', [ $this, 'load_package_tabs_callback' ] );
        add_action( 'wp_ajax_nopriv_load_package_tabs', [ $this, 'load_package_tabs_callback' ] );
    }

    /**
    * Define Plugin Constants
    * @since 1.0.0
    */
    public function define_constants() {
        define( 'WPT_PLUGIN_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );
        define( 'WPT_PLUGIN_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
    }

    /**
    * Load Scripts & Styles
    * @since 1.0.0
    */
    public function scripts_styles() {
        // Register Styles
        wp_register_style( 'wpt-fontawesome', WPT_PLUGIN_URL . 'assets/css/all.min.css', [], rand(), 'all' );
        wp_register_style( 'wpt-swipper-bundle-css', WPT_PLUGIN_URL . 'assets/css/swiper-bundle.min.css', [], rand(), 'all' );
        wp_register_style( 'wpt-style', WPT_PLUGIN_URL . 'assets/css/public.min.css', [], rand(), 'all' );

        // Register Scripts
        wp_register_script( 'wpt-swipper-bundle-js', WPT_PLUGIN_URL . 'assets/js/swiper-bundle.min.js', [ 'jquery' ], rand(), true );
        wp_register_script( 'wpt-main-js', WPT_PLUGIN_URL . 'assets/js/public.min.js', [ 'wpt-swipper-bundle-js' ], rand(), true );

        // Enqueue Styles
        wp_enqueue_style( 'wpt-fontawesome' );
        wp_enqueue_style( 'wpt-swipper-bundle-css' );
        wp_enqueue_style( 'wpt-style' );

        // Enqueue Scripts
        wp_enqueue_script( 'wpt-swipper-bundle-js' );
        wp_enqueue_script( 'wpt-main-js' );

        wp_localize_script( 'wpt-main-js', 'speakerGrid', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
        ] );

        wp_localize_script( 'wpt-main-js', 'packageTabObj', [
            'ajax_url' => admin_url( 'admin-ajax.php' ),
        ] );
    }

    /**
    * Load Text Domain
    * @since 1.0.0
    */
    public function i18n() {
       load_plugin_textdomain( 'wpt-addon', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
    }

    /**
    * Initialize the plugin
    * @since 1.0.0
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
    * @since 1.0.0
    */
    public function init_widgets() {
        require_once WPT_PLUGIN_PATH . '/widgets/wpt-coverflow-slider.php';
        require_once WPT_PLUGIN_PATH . '/widgets/wpt-accordion.php';
        require_once WPT_PLUGIN_PATH . '/widgets/wpt-team-card.php';
        require_once WPT_PLUGIN_PATH . '/widgets/wpt-package-tab.php';
    }

    /**
    * Init Category Section
    * @since 1.0.0
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
    * @since 1.0.0
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
    * @since 1.0.0
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
    * @since 1.0.0
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

    // Ajax Query
    public function load_speaker_details(){
        $speaker_id = isset( $_POST['speaker_id'] ) ? intval( $_POST['speaker_id'] ) : 0;
        if ( $speaker_id ) {
            $speaker_name  = get_field( 'speaker_name', $speaker_id );
            $description   = get_field( 'description', $speaker_id );
            $speaker_image = get_field( 'speaker_image', $speaker_id );
            $speaker_logo = get_field( 'speaker_logo', $speaker_id );

            ob_start();
            ?>
            <div class="speaker-detail">
                <div class="wpt-head">
                    <h2><?php echo esc_html( $speaker_name ); ?></h2>
                </div>
                <div class="wpt-row">
                    <div class="speak-img">
                        <?php if ( $speaker_image ) : ?>
                            <img src="<?php echo esc_url( $speaker_image['url'] ); ?>" class="speakprof" alt="<?php echo esc_attr( $speaker_image['alt'] ); ?>">
                        <?php endif; ?>
                        <?php if($speaker_logo) : ?>
                            <img src="<?php echo esc_url( $speaker_logo['url'] ); ?>" class="speak-logo" alt="<?php echo esc_attr( $speaker_image['alt'] ); ?>">
                        <?php endif; ?>
                    </div>
                    <div class="speaker-description">
                        <?php echo wp_kses_post( $description ); ?>
                    </div>
                </div>
            </div>
            <?php
            $content = ob_get_clean();
            wp_send_json_success( $content );
        } else {
            wp_send_json_error( __( 'Speaker not found', 'text-domain' ) );
        }
    }

    public function load_package_tabs_callback(){
        // Base query arguments
        $args = array(
            'post_type'      => 'package',
            'posts_per_page' => -1,
            'order'  => 'ASC',
        );

        // Check if a package type is provided
        if ( ! empty( $_POST['package_type'] ) ) {
            $args['tax_query'] = array(
                array(
                    'taxonomy' => 'package-type',
                    'field'    => 'slug',
                    'terms'    => sanitize_text_field( $_POST['package_type'] ),
                ),
            );
        }

        $query = new WP_Query( $args );
        
        $tabs = '';
        $content = '';

        if ( $query->have_posts() ) {
            while ( $query->have_posts() ) {
                $query->the_post();
                
                // Get custom fields
                $package_name    = get_post_meta( get_the_ID(), 'package_name', true );
                $price           = get_post_meta( get_the_ID(), 'price', true );
                $package_details = get_post_meta( get_the_ID(), 'package_details', true );
                $button_title = get_post_meta( get_the_ID(), 'button_title', true );
                $button_url = get_post_meta( get_the_ID(), 'button_url', true );

                // Build the tab item
                $tabs .= '<div class="wpt-tab-item" data-package="' . get_the_ID() . '">';
                $tabs .= '<h3>' . esc_html( $package_name ) . '</h3>';
                $tabs .= '<h4>' . esc_html( $price ) . '</h4>';
                $tabs .= '<a href="' . esc_url( $button_url ) . '" class="wpt-btn" target="_blank">' . esc_html($button_title) . '</a>';
                $tabs .= '</div>';

                // Build the content item; hide by default
                $content .= '<div class="wpt-package-content-item" id="package-' . get_the_ID() . '" style="display:none;">';
                $content .= '<div class="wpt-content-head">';
                $content .= '<h3>' . get_the_title() . '</h3>';
                $content .= '</div>';
                $content .= wp_kses_post( $package_details );
                $content .= '</div>';
            }
            wp_reset_postdata();
        }

        wp_send_json_success( array(
            'tabs'    => $tabs,
            'content' => $content,
        ) );
    }

}

// Initialize the plugin
Wpt_Addon::instance();
