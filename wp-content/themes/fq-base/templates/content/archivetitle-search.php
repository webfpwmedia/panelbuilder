<?php
/**
 * Template part for displaying search results page heading
 * @package FQ_Bones_Theme
 */

if ( get_search_query() ) {
	global $wp_query;
	$results_count = $wp_query->found_posts;
	$results_word = 1 === $results_count ? 'result' : 'results';
	$results_message = $results_count . ' ' . $results_word . ' found for "' . get_search_query() . '"';
	if ( 0 == $results_count ) {
		$results_message = 'Sorry, nothing found for "' . get_search_query() . '"';
	}
}

?>

<header class="entry-header archive-header">
	<h1>Search results</h1>
	<p class="search-result-message"><?php echo $results_message ?></p>
</header>
