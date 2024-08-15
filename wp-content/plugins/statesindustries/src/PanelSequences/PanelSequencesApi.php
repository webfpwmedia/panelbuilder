<?php 

namespace FigoliQuinn\StatesIndustries\PanelSequences;

if (!defined('ABSPATH')) exit;

class PanelSequencesApi
{
    public function __construct()
    {
        add_action( 'wp_ajax_nopriv_filter_panel_sequences', [ $this, 'filter_panel_sequences' ] );
        add_action( 'wp_ajax_filter_panel_sequences', [ $this, 'filter_panel_sequences' ] );
    }

    public function filter_panel_sequences() 
    {
        $html = '';
        $sequences = (new PanelSequenceCPT())->filter( sanitize_text_field( $_REQUEST['value'] ) );

        foreach ( $sequences as $sequence ) {
            ob_start();
            get_template_part( 'templates/content/sequence-excerpt', null, [ 'sequence' => $sequence ] );
            $template = ob_get_contents();
            ob_end_clean();
            $html .= $template;
        }

        echo $html;
        exit;
    }
}