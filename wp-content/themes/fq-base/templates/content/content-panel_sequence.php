<?php

/**
 * Main template part for displaying post content, if not more more specific template part
 * @package FQ_Bones_Theme_Parent
 */

require_once WP_PLUGIN_DIR . '/statesindustries/vendor/autoload.php'; 

$sequence = get_post( get_the_ID() );
get_template_part( 'templates/content/panel-sequence-full', null, [ 'sequence' => $sequence ] );

?>
