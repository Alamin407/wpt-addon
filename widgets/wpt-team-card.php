<?php
namespace Elementor;
use WP_Query;

class Wpt_Team_Card extends Widget_Base {

    public function get_name() {
        return 'wpt-team-card-id';
    }

    public function get_title() {
        return esc_html__( 'Team Card', 'wpt-addon' );
    }

    public function get_script_depends() {
        return [
            'wpt-category-js' // Enqueue the JS file for category functionality
        ];
    }

    public function get_icon() {
        return 'eicon-posts-grid';
    }

    public function get_categories() {
        return ['wpt-for-elementor'];
    }

    public function register_controls() {
        $this->start_controls_section(
            'wpt_speak_content_section',
            [
                'label' => esc_html__( 'Team', 'wpt-addon' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
			'wpt_speak_post_per_page',
			[
				'label' => esc_html__( 'Post Per Page', 'textdomain' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'default' => esc_html__( 'Default title', 'textdomain' ),
				'placeholder' => esc_html__( 'Type your title here', 'textdomain' ),
			]
		);

        $this->end_controls_section();

        // Style section
        $this->style_tab();
    }

    private function style_tab(){
        $this->start_controls_section(
            'wpt_speak_grid_section',
            [
                'label' => esc_html__( 'Post Grid Style', 'wpt-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();

        // Get the current page number from 'paged' or 'page' query variables.
        $paged = max( 1, get_query_var('paged'), get_query_var('page') );

        // Query for speaker posts.
        $args  = [
            'post_type'      => 'speaker',
            'posts_per_page' => $settings[ 'wpt_speak_post_per_page' ],
            'paged' => $paged,
        ];
        $query = new WP_Query( $args );

        ?>
            <?php if($query->have_posts()) : ?>
                <div id="speaker-grid" class="speaker-grid">
                    <?php while($query->have_posts() ) : 
                        $query->the_post();
                        $speaker_id    = get_the_ID();
                        $speaker_name  = get_field( 'speaker_name' );
                        $speaker_image = get_field( 'speaker_image' );
                    ?>
                        <div class="speaker-item" data-speaker-id="<?php echo esc_attr( $speaker_id ); ?>">
                            <?php if ( $speaker_image ) : ?>
                                <div class="speaker-img" style="background: url(<?php echo esc_url($speaker_image['url'] ); ?>)"></div>
                            <?php endif; ?>
                            <h3><?php echo esc_html( $speaker_name ); ?></h3>
                        </div>
                    <?php endwhile; ?>
                </div>
                <?php
                    // Pagination with custom icon HTML for previous and next buttons.
                    $big = 999999999; // an unlikely integer
                    $pagination = paginate_links( array(
                        'base'      => str_replace( $big, '%#%', esc_url( get_pagenum_link( $big ) ) ),
                        'format'    => '?paged=%#%',
                        'current'   => $paged,
                        'total'     => $query->max_num_pages,
                        'type'      => 'list',
                        'prev_text' => '<i class="fa-solid fa-arrow-left"></i> <span>Previous</span>',
                        'next_text' => '<span>Next</span><i class="fa-solid fa-arrow-right"></i>',
                        'add_fragment'=> '#speaker-grid'
                    ) );

                    if ( $pagination ) {
                        echo '<div class="speaker-pagination">' . $pagination . '</div>';
                    }
                    wp_reset_postdata(); 
                ?>
            <?php endif; ?>
            <div id="speaker-popup" style="display:none;">
                <div class="speak-popup-wrap">
                    <div class="popup-content">
                        <span class="close-popup"><i class="fa-solid fa-xmark"></i></span>
                        <div id="speaker-details"></div>
                    </div>
                </div>
            </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Wpt_Team_Card() );