<?php
namespace Wpt;
use WP_Query;

class Package_Ajax{
    public function __construct(){
        // Package Tab Ajax Query
        add_action( 'wp_ajax_load_package_tabs', [ $this, 'load_package_tabs_callback' ] );
        add_action( 'wp_ajax_nopriv_load_package_tabs', [ $this, 'load_package_tabs_callback' ] );
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

        // Capture the widget instance ID
        $wpt_instance_id = ! empty( $_POST['wpt_instance_id'] ) ? sanitize_text_field( $_POST['wpt_instance_id'] ) : '';
        $id_suffix       = $wpt_instance_id ? '-' . $wpt_instance_id : '';

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
                $tabs .= '<div class="wpt-tab-item" data-package="' . get_the_ID() . $id_suffix . '">';
                $tabs .= '<h3>' . esc_html( $package_name ) . '</h3>';
                $tabs .= '<h4>' . esc_html( $price ) . '</h4>';
                $tabs .= '<a href="' . esc_url( $button_url ) . '" class="wpt-btn" target="_blank">' . esc_html($button_title) . '</a>';
                $tabs .= '</div>';

                // Build the content item; hide by default
                $content .= '<div class="wpt-package-content-item" id="package-' . get_the_ID() . $id_suffix . '" style="display:none;">';
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