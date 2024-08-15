<?php 

namespace FigoliQuinn\StatesIndustries\PanelSequences;

use FigoliQuinn\BetterCustomPostTypes\BetterCustomPostType;

if (!defined('ABSPATH')) exit;

class PanelSequenceCPT extends BetterCustomPostType
{
    const SLUG = 'panel_sequence';
    const NAME = 'Panel Sequence';
    const PANELS_FIELD_KEY = 'panels';
    const NAME_FIELD_KEY = 'name';
    const NUMBER_FIELD_KEY = 'number';
    const SEQUENCES_FIELD_KEY = 'sequences';
    const SEQUENCE_OF_FIELD_KEY = 'sequence_of_';
    const IMAGES_FIELD_KEY = 'images';
    const SHOW_PANELS_KEY = 'live_look_show_panels';
    const VISIBLE_PANELS_KEY = 'live_look_visible_panels';

    public function __construct( ?int $id = null, $setup = false )
    {
        $this->slug = SELF::SLUG;
        $this->name = SELF::NAME;
        $this->menu_icon = 'dashicons-format-gallery';
        $this->custom_url = 'panel-sequences';

        if ( ! empty( $id ) ) {
            $this->id = $id;
        }

        parent::__construct();


        if ( $setup ) {
            add_action( 'init', [ $this, 'register_acf_fields' ] );
            add_action( 'live-look-content', [ $this, 'live_look_content' ] );
            add_action( 'live-look-controls', [ $this, 'live_look_controls' ], 10 );
            add_action('wp_ajax_save_live_look_data', [ $this, 'save_live_look_data' ] );
            add_action('wp_ajax_get_live_look_data', [ $this, 'get_live_look_data' ] );
        }
    }

    public function custom_admin_column_headers( array $columns ): array 
    {
        $index = array_search( 'taxonomy-wood_type', array_keys( $columns ) );
        $columns = array_slice( $columns, 0, $index ) + [ 'number' => __( 'Number') ] + array_slice( $columns, $index, count( $columns ) - 1, true );

        return $columns;
    }

    public function custom_admin_column_value( string $column, int $post_id ): void 
    {
        if ( $column != 'number' ) {
            return;
        }

        the_field( self::NUMBER_FIELD_KEY );
    }

    public function filter( ?string $wood_type = '' ): array 
    {
        $query = (new PanelSequenceCPT)->query();

        
        if ( ! empty( $wood_type ) ) {
            $query->whereTaxonomy( PanelSequenceTaxonomy::NAME, 'slug', [$wood_type] );
        }
        
        return $query->get();
    }

    public function register_acf_fields()
    {
        if( ! function_exists('acf_add_local_field_group') ) {
            return;
        }

        acf_add_local_field_group(array(
            'key' => 'group_5fb5c13437be0',
            'title' => 'Panel Sequences',
            'fields' => array(
                array(
                    'key' => 'field_5fb5c13d9df9b',
                    'label' => 'Panels',
                    'name' => self::PANELS_FIELD_KEY,
                    'type' => 'repeater',
                    'instructions' => '',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '',
                        'class' => '',
                        'id' => '',
                    ),
                    'collapsed' => '',
                    'min' => 0,
                    'max' => 0,
                    'layout' => 'row',
                    'button_label' => 'Add Panel',
                    'sub_fields' => array(
                        array(
                            'key' => 'field_5fb5c1bc9df9d',
                            'label' => 'Name',
                            'name' => self::NAME_FIELD_KEY,
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5fb5c1bc9df9c',
                            'label' => 'Number',
                            'name' => self::NUMBER_FIELD_KEY,
                            'type' => 'text',
                            'instructions' => '',
                            'required' => 1,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'default_value' => '',
                            'placeholder' => '',
                            'prepend' => '',
                            'append' => '',
                            'maxlength' => '',
                        ),
                        array(
                            'key' => 'field_5fb5c1ce9df9d',
                            'label' => 'Sequences',
                            'name' => self::SEQUENCES_FIELD_KEY,
                            'type' => 'repeater',
                            'instructions' => '',
                            'required' => 0,
                            'conditional_logic' => 0,
                            'wrapper' => array(
                                'width' => '',
                                'class' => '',
                                'id' => '',
                            ),
                            'collapsed' => '',
                            'min' => 0,
                            'max' => 0,
                            'layout' => 'row',
                            'button_label' => 'Add Sequence',
                            'sub_fields' => array(
                                array(
                                    'key' => 'field_5fb5c23d9df9e',
                                    'label' => 'Sequence of',
                                    'name' => self::SEQUENCE_OF_FIELD_KEY,
                                    'type' => 'number',
                                    'instructions' => '',
                                    'required' => 1,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'default_value' => '',
                                    'placeholder' => '',
                                    'prepend' => '',
                                    'append' => '',
                                    'min' => '',
                                    'max' => '',
                                    'step' => '',
                                ),
                                array(
                                    'key' => 'field_5fb5c24c9df9f',
                                    'label' => 'Images',
                                    'name' => self::IMAGES_FIELD_KEY,
                                    'type' => 'gallery',
                                    'instructions' => '',
                                    'required' => 0,
                                    'conditional_logic' => 0,
                                    'wrapper' => array(
                                        'width' => '',
                                        'class' => '',
                                        'id' => '',
                                    ),
                                    'return_format' => 'array',
                                    'preview_size' => 'medium',
                                    'insert' => 'append',
                                    'library' => 'all',
                                    'min' => '',
                                    'max' => '',
                                    'min_width' => '',
                                    'min_height' => '',
                                    'min_size' => '',
                                    'max_width' => '',
                                    'max_height' => '',
                                    'max_size' => '',
                                    'mime_types' => '',
                                ),
                            ),
                        ),
                    ),
                ),
            ),
            'location' => array(
                array(
                    array(
                        'param' => 'post_type',
                        'operator' => '==',
                        'value' => self::SLUG,
                    ),
                ),
            ),
            'menu_order' => 0,
            'position' => 'normal',
            'style' => 'default',
            'label_placement' => 'top',
            'instruction_placement' => 'label',
            'hide_on_screen' => '',
            'active' => true,
            'description' => '',
        ));
    }

    public function live_look_content()
    {
        $template = __DIR__ . '/templates/live-look.php';
        ob_start();
        include $template;
        $html = ob_get_clean();

        echo $html;
    }

    public function live_look_controls()
    {
        if ( ! \FQJSH_Init::can_access_live_look_controls() ) {
            return;
        }

        $template = __DIR__ . '/templates/live-look-panel-sequence-controls.php';
        ob_start();
        include $template;
        $html = ob_get_clean();

        echo $html;
    }

    public function save_live_look_data()
    {
        if ( ! \FQJSH_Init::can_access_live_look_controls() ) {
            return;
        }

        $show_panels = sanitize_text_field( $_REQUEST['show_panels'] );
        $panel_ids = $_REQUEST['panel_ids'];

        set_transient( self::SHOW_PANELS_KEY, $show_panels, DAY_IN_SECONDS );
        set_transient( self::VISIBLE_PANELS_KEY, $panel_ids, DAY_IN_SECONDS );
    }
    
    public function get_live_look_data()
    {
        if ( ! is_user_logged_in() ) {
            return;
        }
        
        return wp_send_json([
            'show_panels' => get_transient( self::SHOW_PANELS_KEY ),
            'panel_ids' => get_transient( self::VISIBLE_PANELS_KEY ),
        ]);
    }
}