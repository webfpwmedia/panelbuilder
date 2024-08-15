<?php 

class RegisterBlocks 
{
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
            'figoli-quinn-theme-blocks',
            get_stylesheet_directory_uri() . '/js/blocks/blocks-editor-blocks.js',
            [ 'wp-blocks', 'wp-i18n', 'wp-element', 'wp-editor' ],
            true
        );

        wp_enqueue_style(
            'figoli-quinn-theme-editor',
            get_stylesheet_directory_uri() . '/editor.css'
        );
    }

    public function enqueue_block_assets(): void 
    {
        if ( is_admin() ) {
            return;
        }

        wp_enqueue_script(
            'figoli-quinn-theme-blocks-front-end',
            get_stylesheet_directory_uri() . '/js/blocks/blocks-editor-blocks-front-end.js',
            [],
            '',
            true
        );
    }
}

new RegisterBlocks;