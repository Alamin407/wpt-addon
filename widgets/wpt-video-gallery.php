<?php
namespace Elementor;

class Wpt_Video_Gallery extends Widget_Base {

    public function get_name() {
        return 'wpt-video-gallery-id';
    }

    public function get_title() {
        return esc_html__( 'Video Gallery', 'wpt-addon' );
    }

    public function get_script_depends() {
        return [
            'wpt-category-js' // Enqueue the JS file for category functionality
        ];
    }

    public function get_icon() {
        return 'eicon-gallery-group';
    }

    public function get_categories() {
        return ['wpt-for-elementor'];
    }

    public function register_controls() {
        $this->start_controls_section(
            'wpt_vid_gallery_section',
            [
                'label' => esc_html__( 'Video Gallery', 'wpt-addon' ),
                'tab' => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->end_controls_section();

        // Style section
        $this->style_tab();
    }

    private function style_tab(){
        $this->start_controls_section(
            'wpt_vid_gallery_wrapper_section',
            [
                'label' => esc_html__( 'Video Gallery', 'wpt-addon' ),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
            ]
        );


        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
         // Get the selected day from URL query parameters.
        $selected_day = isset( $_GET['day'] ) ? sanitize_text_field( $_GET['day'] ) : '';

        // Set up query arguments.
        $args = [
            'post_type'      => 'video-gallery',
            'posts_per_page' => 5,
            'orderby'        => 'date',
            'order'          => 'DESC',
        ];

        // If a day filter is set, modify the query.
        if ( ! empty( $selected_day ) ) {
            $args['tax_query'] = [
                [
                    'taxonomy' => 'upload-day',
                    'field'    => 'slug',
                    'terms'    => $selected_day,
                ],
            ];
        }

        $query = new \WP_Query( $args );

        // Retrieve available terms for the filter.
        $upload_days = get_terms( [
            'taxonomy'   => 'upload-day',
            'hide_empty' => true,
        ] );
        ?>
        <div class="wpt-video-gallery">
            <div class="wpt-gallery-head" style="display: flex; justify-content: space-between; align-items: center;">
                <div class="wpt-filter">
                    <?php if ( ! empty( $upload_days ) && ! is_wp_error( $upload_days ) ) : ?>
                        <?php foreach ( $upload_days as $day ) : 
                            // Build a link with the day parameter.
                            $link = esc_url( add_query_arg( 'day', $day->slug ) );
                            $active_class = ( $selected_day === $day->slug ) ? ' active' : '';
                        ?>
                            <a href="<?php echo $link; ?>" class="upload-day<?php echo $active_class; ?>">
                                <?php echo esc_html( $day->name ); ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="wpt-menu">
                    <a href="/image-gallery" class="image-gallery"><?php _e( 'Image Gallery', 'plugin-domain' ); ?></a>
                    <a href="/video-gallery" class="video-gallery"><?php _e( 'Video Gallery', 'plugin-domain' ); ?></a>
                </div>
            </div>
            <!-- Video grid container -->
            <div class="wpt-videos" style="display: flex;">
                <?php
                if ( $query->have_posts() ) :
                    $videos = $query->posts;
                    // Split videos into columns:
                    // Column 1: first video (large), Column 2: next two (small), Column 3: next two (small)
                    $col1 = array_slice( $videos, 0, 1 );
                    $col2 = array_slice( $videos, 1, 2 );
                    $col3 = array_slice( $videos, 3, 2 );
                    ?>
                    <div class="video-column col-1" style="flex: 2; margin-right: 10px;">
                        <?php foreach ( $col1 as $post ) : setup_postdata( $post );
                            $video_thumbnail = get_post_meta( $post->ID, 'video_thumbnail', true );
                            if ( is_numeric( $video_thumbnail ) ) {
                                $video_thumbnail = wp_get_attachment_url( $video_thumbnail );
                            }
                            $video_url = get_post_meta( $post->ID, 'video_url', true );
                        ?>
                            <div class="wpt-video-item video-item-large" style="margin-bottom:10px;">
                                <div class="video-thumbnail-wrapper" style="position: relative;">
                                    <img src="<?php echo esc_url( $video_thumbnail ); ?>" alt="<?php echo esc_attr( get_the_title( $post ) ); ?>">
                                    <a href="#" class="video-play-icon" data-video-url="<?php echo esc_url( $video_url ); ?>" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-decoration: none; font-size: 48px; color: #fff;">
                                        <i class="fa fa-play" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; wp_reset_postdata(); ?>
                    </div>
                    <div class="video-column col-2" style="flex: 1; margin-right: 10px;">
                        <?php foreach ( $col2 as $post ) : setup_postdata( $post );
                            $video_thumbnail = get_post_meta( $post->ID, 'video_thumbnail', true );
                            if ( is_numeric( $video_thumbnail ) ) {
                                $video_thumbnail = wp_get_attachment_url( $video_thumbnail );
                            }
                            $video_url = get_post_meta( $post->ID, 'video_url', true );
                        ?>
                            <div class="wpt-video-item video-item-small" style="margin-bottom:10px;">
                                <div class="video-thumbnail-wrapper" style="position: relative;">
                                    <img src="<?php echo esc_url( $video_thumbnail ); ?>" alt="<?php echo esc_attr( get_the_title( $post ) ); ?>">
                                    <a href="#" class="video-play-icon" data-video-url="<?php echo esc_url( $video_url ); ?>" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-decoration: none; font-size: 36px; color: #fff;">
                                        <i class="fa fa-play" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; wp_reset_postdata(); ?>
                    </div>
                    <div class="video-column col-3" style="flex: 1;">
                        <?php foreach ( $col3 as $post ) : setup_postdata( $post );
                            $video_thumbnail = get_post_meta( $post->ID, 'video_thumbnail', true );
                            if ( is_numeric( $video_thumbnail ) ) {
                                $video_thumbnail = wp_get_attachment_url( $video_thumbnail );
                            }
                            $video_url = get_post_meta( $post->ID, 'video_url', true );
                        ?>
                            <div class="wpt-video-item video-item-small" style="margin-bottom:10px;">
                                <div class="video-thumbnail-wrapper" style="position: relative;">
                                    <img src="<?php echo esc_url( $video_thumbnail ); ?>" alt="<?php echo esc_attr( get_the_title( $post ) ); ?>">
                                    <a href="#" class="video-play-icon" data-video-url="<?php echo esc_url( $video_url ); ?>" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-decoration: none; font-size: 36px; color: #fff;">
                                        <i class="fa fa-play" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; wp_reset_postdata(); ?>
                    </div>
                <?php else: ?>
                    <p><?php _e( 'No videos found', 'plugin-domain' ); ?></p>
                <?php endif; ?>
            </div>
        </div>

        <!-- Popup Modal Markup -->
        <div id="video-popup" class="video-popup-overlay" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:9999; align-items:center; justify-content:center;">
            <div class="video-popup-content" style="position:relative; background:#000; padding:20px; max-width:800px; width:90%;">
                <span class="video-popup-close" style="position:absolute; top:10px; right:15px; font-size:30px; color:#fff; cursor:pointer;">&times;</span>
                <div class="video-popup-inner" style="position:relative; padding-top:56.25%;">
                    <!-- The video iframe will be injected here by your JS -->
                </div>
            </div>
        </div>
        <?php
    }
}

Plugin::instance()->widgets_manager->register( new Wpt_Video_Gallery() );