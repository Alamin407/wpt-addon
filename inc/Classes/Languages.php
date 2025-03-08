<?php
namespace Wpt;

class Languages{
    public function __construct() {
        add_action( 'init', array($this, 'i18n') );
    }

    /**
    * Load Text Domain
    * @since 1.0.0
    */
    public function i18n() {
        load_plugin_textdomain( 'wpt-addon', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
     }
}