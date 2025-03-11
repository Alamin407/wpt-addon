<?php
namespace Wpt;

class Upload_Day_Ajax{
    public function __construct() {
        add_action( 'wp_ajax_filter_video_gallery', array($this, 'filter_video_gallery') );
        add_action( 'wp_ajax_nopriv_filter_video_gallery', array($this, 'filter_video_gallery') );
    }

    public function filter_video_gallery() {
        $day = isset( $_POST['day'] ) ? sanitize_text_field( $_POST['day'] ) : '';
    
        $args = array(
            'post_type'      => 'video-gallery',
            'posts_per_page' => 5,
            'orderby'        => 'date',
            'order'          => 'DESC',
            'tax_query'      => array(
                array(
                    'taxonomy' => 'upload-day',
                    'field'    => 'slug',
                    'terms'    => $day,
                ),
            ),
        );
    
        $query = new \WP_Query( $args );
        ob_start();
        if ( $query->have_posts() ) :
            $videos = $query->posts;
            $col1   = array_slice( $videos, 0, 1 );
            $col2   = array_slice( $videos, 1, 2 );
            $col3   = array_slice( $videos, 3, 2 );
            ?>
            <div class="wpt-videos" style="display: flex;">
                <div class="video-column col-1" style="flex: 2; margin-right: 10px;">
                    <?php foreach ( $col1 as $post ) : setup_postdata( $post );
                        $video_thumbnail = get_post_meta( $post->ID, 'video_thumbnail', true );
                        if ( is_numeric( $video_thumbnail ) ) {
                            $video_thumbnail = wp_get_attachment_url( $video_thumbnail );
                        }
                        $video_url = get_post_meta( $post->ID, 'video_url', true );
                    ?>
                        <div class="wpt-video-item video-item-large" style="margin-bottom:10px;">
                            <div class="video-thumbnail-wrapper">
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
                            <div class="video-thumbnail-wrapper">
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
                            <div class="video-thumbnail-wrapper">
                                <img src="<?php echo esc_url( $video_thumbnail ); ?>" alt="<?php echo esc_attr( get_the_title( $post ) ); ?>">
                                <a href="#" class="video-play-icon" data-video-url="<?php echo esc_url( $video_url ); ?>" style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-decoration: none; font-size: 36px; color: #fff;">
                                    <i class="fa fa-play" aria-hidden="true"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; wp_reset_postdata(); ?>
                </div>
            </div>
            <?php
        else :
            echo '<p>No videos found</p>';
        endif;
        $html = ob_get_clean();
        echo $html;
        wp_die();
    }
}