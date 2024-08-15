<?php
/**
 * Global helper functions for this theme
 * @package FQ_Bones_Theme_Parent
 */

 /*--------------------------------------------------------------
 # Allow us to call custom loops or content types from standard
 set of templates.
 --------------------------------------------------------------*/

function fq_get_template_part_type() {

	$types = [
		'is_404' => [
			'part-slug' => '404',
			'param' => null,
		],
		'is_front_page' => [
			'part-slug' => 'front',
			'param' => null,
		],
		'is_search' => [
			'part-slug' => 'search',
			'param' => null,
		],
		'is_post_type_archive' => [
			'part-slug' => 'grid-swatch',
			'param' => 'veneer', // add post types here for instance
		],
		'is_post_type_archive' => [
			'part-slug' => 'grid-panel-sequence',
			'param' => 'panel_sequence', // add post types here for instance
		],
		// 'is_post_type_archive' => [
		// 	'part-slug' => 'grid',
		// 	'param' => [], // add post types here for instance
		// ],
    ];
    
	foreach ( $types as $conditional_tag => $type ) {
		if ( $conditional_tag( $type['param'] ) ) {
            return $type['part-slug'];
		}
    }
    
	return get_post_type();
}

// If we want breadcrumbs work that out here

function fq_the_breadcrumbs() {

	if ( ! is_single() || ! $post_type ) {
		return;
	}

	// $parent_pages = [
	// 	// 'clients' => 'who-we-help',
	// 	// 'services' => 'areas-of-expertise',
	// ];

	// $post_type = get_post_type_object( get_post_type() );
	// $parent = $post_type->labels->name;
	//
	// $url = '';
	//
	// foreach ( $parent_pages as $post_type_slug => $page_slug ) {
	// 	if ( $post_type_slug == $post_type->name ) {
	// 		$url = site_url( $page_slug );
	// 	}
	// }
	//
	// if ( empty( $url ) ) {
	// 	$url = get_post_type_archive_link( $post_type->name );
	// }
	//
	// $page = get_the_title();

	// Whatever we do above we need to end up with an array of objects like this for the breadcrumb template
	$page = new stdClass();
	$page->url = '';
	$page->label = '';
	$pages[] = $page;

	$breadcrumbs = new stdClass();
	$breadcrumbs->pages = $pages;
	$breadcrumbs->separator = '<i class="separator far fa-angle-double-right"></i>';

	ob_start();
	include locate_template( 'templates/components/breadcrumbs.php' );
	$html = ob_get_clean();

	return $html;
}

function fq_has_announcement() {
	if ( ! class_exists('ACF') ) {
		return false;
	}

	if  ( get_field( 'banner_message_activated', 'option' ) && ! empty( get_field( 'banner_message', 'option' ) ) ) {
		return true;
	}
}

// TODO: Also make this more generic and better.

function fq_the_archive_header() {
	if ( is_home() ) {
		$html = '<header class="entry-header archive-header">';
		$html .= '<h1>';
		$html .= 'News & tips';
		$html .= '</h1>';
		$html .= '</header><!-- .entry-header -->';
		echo $html;
	}

	return false;
}

/*--------------------------------------------------------------
# allows native WP custom-post-type archive page,
but redirects any singles view of that cpt to the archive page
--------------------------------------------------------------*/

function fq_disable_single_views( $slug ) {
	if ( is_single() && $slug == get_query_var( 'post_type' ) ) {
		wp_redirect( home_url( '/' . get_query_var( 'post_type' ) . '/' ), 301 );
		exit;
	}
}

function copyright_statement( $organization = '', $launch_year = '' ) {

	if( empty( $organization ) ) {
		$organization = get_bloginfo( 'name' );
	}

	$current_year = date( 'Y' );

	if( empty( $launch_year ) || $current_year == $launch_year ) {
		$copyright_date = $current_year;
	} else {
		$copyright_date = $launch_year . "-" . $current_year;
	}
	return '&copy; ' . $copyright_date . ' ' . $organization;
}

/**
 * Template tag to output social media sharing buttons.
 *
 * @param array $channels -- Pass the social media channels you want to include as an array of strings. Acceptable elements are 'facebook','twitter','pinterest' and 'linkedin'. Default: all four of those.
 * @param string $lead_in -- This is the text that will appear before the buttons appear. Passing false or '' will output no heading before the links. Default: "Share"
 * @return echos the html to the page
 * @author Robert Passaro
 */


// TODO: Can this be improved? Is this outdated? Use a template instead of hardcoded html.

function fq_the_share_buttons( $channels = array( 'facebook','twitter','pinterest','linkedin' ), $lead_in = 'Share' ) {

	// Add a fallback image that will appear with any shares if there is not a featured image on whatever post is being shared
	// Ex.: /wp-content/uploads/2018/04/some-image.jpg
	$fallback_image_path = '';

    global $post;
	$page_id = $post->ID;

	$descript = urlencode( html_entity_decode( get_the_title( $page_id ), ENT_COMPAT, "UTF-8") );
	$link = esc_url( get_permalink() );
	$thumb_id = get_post_thumbnail_id();
	if( $thumb_id ) {
		$thumb_url_array = wp_get_attachment_image_src( $thumb_id, 'full', true );
		$image = $thumb_url_array[0];
	} else {
		$image = site_url() . $fallback_image_path;
	}

	$buttons = array();
	$buttons['linkedin'] = '<div class="share-button linkedin"><a class="linkedin-share-button" target="_blank" href="https://www.linkedin.com/shareArticle?mini=true&title=' . $descript . '&url=' . $link . '"><i class="fa fa-linkedin" aria-hidden="true"></i></a></div>';
	$buttons['twitter'] = '<div class="share-button twitter"><a class="twitter-share-button" target="_blank" href="https://twitter.com/intent/tweet?text=' . $descript . '&url=' . $link . '"><i class="fa fa-twitter" aria-hidden="true"></i></a></div>';
	$buttons['facebook'] = '<div class="share-button facebook"><a class="facebook-share-button" href="https://www.facebook.com/sharer.php?u=' . $link . '"><i class="fa fa-facebook" aria-hidden="true"></i></a></div>';
	$buttons['pinterest'] = '<div class="share-button pinterest"><a class="pinterest-share-button" href="https://pinterest.com/pin/create/bookmarklet/?media=' . $image . '&url=' . $link . '&description=' . $descript .'"><i class="fa fa-pinterest" aria-hidden="true"></i></a></div>';

	$output = '<div class="icon-row social-sharing">';
	if ( ! empty( $lead_in ) ) {
		$output .= '<p>' . esc_html__( $lead_in ) . '</p>';
	}
	foreach( $channels as $channel ) {
		$output .= $buttons[$channel];
	}
	$output .= '</div>';

	echo $output;
}

function fq_should_show_page_title()
{
    $post_types_with_titles = [
        'post',
        'press_release',
    ];

    return in_array( get_post_type(), $post_types_with_titles ) || is_archive() || is_search();
}
