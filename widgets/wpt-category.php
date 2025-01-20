<?php
namespace Elementor;

class Wpt_Category extends Widget_Base {

    public function get_name() {
        return 'wpt-category-id';
    }

    public function get_title() {
        return esc_html__( 'Category Grid', 'wpt-addon' );
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
            'wpt_cat_content_section',
            [
                'label' => esc_html__( 'Category', 'wpt-addon' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        // Taxonomy control
        $this->add_control(
            'wpt_cat_taxonomy',
            [
                'label' => __( 'Taxonomy', 'wpt-addon' ),
                'type' => Controls_Manager::TEXT,
                'default' => 'machine_category',
                'description' => __( 'Enter the custom taxonomy to fetch categories from.', 'wpt-addon' ),
            ]
        );

        $this->end_controls_section();

        // Style section
        $this->style_tab();
    }

    private function style_tab(){
        $this->start_controls_section(
            'wpt_cat_style_section',
            [
                'label' => esc_html__( 'Style', 'wpt-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );

        // Add styling controls for the grid here if needed

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $taxonomy = $settings['wpt_cat_taxonomy'];

        // Fetch parent terms (top-level) from the custom taxonomy
        $terms = get_terms( [
            'taxonomy' => $taxonomy,
            'hide_empty' => true,
            'parent' => 0, // Only get parent terms
        ] );

        if ( empty( $terms ) || is_wp_error( $terms ) ) {
            echo '<p>' . __( 'No categories found.', 'wpt-addon' ) . '</p>';
            return;
        }

        ?>
        <div class="machine-category-grid">
            <?php foreach ( $terms as $term ) : 
                $thumbnail_id = get_term_meta( $term->term_id, 'thumbnail_id', true );
                $thumbnail_url = $thumbnail_id ? wp_get_attachment_url( $thumbnail_id ) : 'https://via.placeholder.com/150';
            ?>
                <div class="machine-category-item" data-term-id="<?php echo esc_attr( $term->term_id ); ?>">
                    <a href="javascript:void(0);" class="load-child-categories" data-term-id="<?php echo esc_attr( $term->term_id ); ?>">
                        <div class="mec-thumb">
                            <img src="<?php echo esc_url( $thumbnail_url ); ?>" alt="<?php echo esc_attr( $term->name ); ?>">
                        </div>
                        <div class="content">
                            <h3><?php echo esc_html( $term->name ); ?></h3>
                            <p><?php echo esc_html( $term->description ); ?></p>
                        </div>
                    </a>
                    <div class="child-categories" id="child-categorey" style="display: none;"></div>
                </div>
            <?php endforeach; ?>
        </div>

        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Wpt_Category() );