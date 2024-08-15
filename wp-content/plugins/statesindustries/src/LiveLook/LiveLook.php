<?php 

namespace FigoliQuinn\StatesIndustries\LiveLook;

class LiveLook 
{
    const SAVED_IMAGE_KEY = 'live_look_image_key';


    public function __construct()
    {
        add_action( 'init', [ $this, 'enqueue_scripts' ] );
        add_action( 'live-look-controls', [ $this, 'live_look_controls' ] );
        add_action( 'live-look-content', [ $this, 'live_look_content' ] );
        add_action( 'wp_ajax_save_live_look_image', [ $this, 'save_live_look_image' ] );
        add_action( 'wp_ajax_get_live_look_image', [ $this, 'get_live_look_image' ] );
    }

    public function enqueue_scripts()
    {
        wp_enqueue_media();
    }

    public function live_look_controls()
    {
        if ( ! \FQJSH_Init::can_access_live_look_controls() ) {
            return;
        }

        $template = __DIR__ . '/templates/live-look-image-viewer-controls.php';
        ob_start();
        include $template;
        $html = ob_get_clean();

        echo $html;
    }

    public function live_look_content()
    {
        $template = __DIR__ . '/templates/live-look-image-viewer-content.php';
        ob_start();
        include $template;
        $html = ob_get_clean();

        echo $html;
    }

    public function save_live_look_image()
    {
        if ( ! \FQJSH_Init::can_access_live_look_controls() ) {
            return;
        }

        $attachment_id = sanitize_text_field( $_REQUEST['attachment_id'] );

        if ( empty( $attachment_id ) ) {
            delete_transient( self::SAVED_IMAGE_KEY );
        } else {
            set_transient( self::SAVED_IMAGE_KEY, $attachment_id, DAY_IN_SECONDS );
        }
    }

    public function get_live_look_image()
    {
        if ( ! is_user_logged_in() ) {
            return;
        }
        
        $attachment_id = get_transient( self::SAVED_IMAGE_KEY );
        $url = ! empty( $attachment_id ) ? wp_get_attachment_url( $attachment_id ) : null;

        return wp_send_json([
            'attachment' => [
                'id' => $attachment_id,
                'url' => $url,
            ],
        ]);
    }
}