<?php
namespace Elementor;
use WP_Query;

class Wpt_Package_Tab extends Widget_Base {

    public function get_name() {
        return 'wpt-package-tab-id';
    }

    public function get_title() {
        return esc_html__( 'Package Tab', 'wpt-addon' );
    }

    public function get_script_depends() {
        return [
            'wpt-category-js' // Enqueue the JS file for category functionality
        ];
    }

    public function get_icon() {
        return 'eicon-tabs';
    }

    public function get_categories() {
        return ['wpt-for-elementor'];
    }

    public function register_controls() {
        $this->start_controls_section(
            'wpt_pack_tab_content_section',
            [
                'label' => esc_html__( 'Package Tab', 'wpt-addon' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Get package type terms as select options
        $wpt_package_types = get_terms( array(
            'taxonomy'   => 'package-type',
            'hide_empty' => false,
        ) );
        $wpt_options = [ '' => __( 'All', 'wpt-addon' ) ];
        if ( ! is_wp_error( $wpt_package_types ) ) {
            foreach ( $wpt_package_types as $term ) {
                $wpt_options[ $term->slug ] = $term->name;
            }
        }

        $this->add_control(
            'wpt_package_type',
            [
                'label'   => __( 'Package Type', 'wpt-addon' ),
                'type'    => \Elementor\Controls_Manager::SELECT,
                'options' => $wpt_options,
                'default' => 'All',
            ]
        );

        $this->end_controls_section();

        // Style section
        $this->style_tab();
    }

    private function style_tab(){
        $this->start_controls_section(
            'wpt_pack_tab_style_section',
            [
                'label' => esc_html__( 'Package Tab Style', 'wpt-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        ?>
            <div class="wpt-package-wrap" data-package-type="<?php echo esc_attr( $settings['wpt_package_type'] ); ?>">
                <div class="wpt-package-tabs"></div>
                <div class="wpt-package-content"></div>
            </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Wpt_Package_Tab() );