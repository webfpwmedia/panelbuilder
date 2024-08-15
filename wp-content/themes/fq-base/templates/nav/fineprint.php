<?php
/**
* The template for displaying minor nav.
* @package FQ_Bones_Theme
 */

 if ( ! defined( 'ABSPATH' ) ) {
 	exit;
 }
?>

<?php

$nav_location = 'footer-minor';
$nav_args = array(
	'theme_location' => $nav_location,
	'depth' => 1,
);

?>

<?php if ( has_nav_menu( $nav_location ) ) : ?>
	<div class="nav-fineprint">
		<?php wp_nav_menu( $nav_args ); ?>
	</div>
<?php endif; ?>
