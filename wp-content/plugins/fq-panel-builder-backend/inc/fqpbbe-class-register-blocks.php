<?php 

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! class_exists( 'FQPBBE_RegisterBlocks' ) ) {

    class FQPBBE_RegisterBlocks {

        public function __construct()
        {
            $this->register_wp_hooks();
        }

        protected function register_wp_hooks(): void
        {
            add_action( 'enqueue_block_editor_assets', [ $this, 'enqueue_block_editor_assets' ] );
            add_action( 'enqueue_block_assets', [ $this, 'enqueue_block_assets' ] );
        }

        public function enqueue_block_editor_assets(): void
        {
            wp_enqueue_script(
                'fq-panel-builder-backend-blocks',
                FQPBBE_URL . '/dist/blocks.js',
                [ 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ],
                true
            );
        }

        public function enqueue_block_assets(): void 
        {
            if ( is_admin() ) {
                return;
            }

            if( ! has_block('figoli-quinn/panel-builder') ) { 
                return;
            }

            wp_enqueue_script(
                'fq-panel-builder-backend-blocks-front-end',
                FQPBBE_URL . '/dist/blocks-front-end.js',
                [],
                '',
                true
            );
        }
    }

}

new FQPBBE_RegisterBlocks();