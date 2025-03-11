<?php

final class Init {
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
        $this->load_classes();
    }

    /**
    * Load Classes
    * @since 1.0.0
    */

    public function load_classes(){
        require_once WPT_PLUGIN_PATH . '/inc/Classes/Enqueue.php';
        require_once WPT_PLUGIN_PATH . '/inc/Classes/Languages.php';
        require_once WPT_PLUGIN_PATH . '/inc/Classes/Plugin_Loaded.php';
        require_once WPT_PLUGIN_PATH . '/inc/Classes/Speaker_Ajax.php';
        require_once WPT_PLUGIN_PATH . '/inc/Classes/Package_Ajax.php';
        require_once WPT_PLUGIN_PATH . '/inc/Classes/Upload_Day_Ajax.php';

        new Wpt\Enqueue();
        new Wpt\Languages();
        new Wpt\Plugin_Loaded();
        new Wpt\Speaker_Ajax();
        new Wpt\Package_Ajax();
        new Wpt\Upload_Day_Ajax();
    }
}
