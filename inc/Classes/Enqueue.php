<?php

namespace Wpt;

class Enqueue{
    public function __construct(){
        add_action( 'wp_enqueue_scripts', array( $this, 'scripts_styles' ) );
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
}