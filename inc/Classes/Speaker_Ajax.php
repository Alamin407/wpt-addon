<?php
namespace Wpt;

class Speaker_Ajax{
    public function __construct(){
        // Team Ajax Query
        add_action( 'wp_ajax_load_speaker_details', [ $this, 'load_speaker_details' ] );
        add_action( 'wp_ajax_nopriv_load_speaker_details', [ $this, 'load_speaker_details' ] );
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
}