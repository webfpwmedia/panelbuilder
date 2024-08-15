<?php
/**
 * The header for our theme: This is the template that displays all of the <head> section and everything up until <div id="content">
 * @package FQ_Bones_Theme_Parent
 */
?>

<!DOCTYPE html>
<html <?php language_attributes(); ?>>
	<head>
	    <meta charset="<?php bloginfo( 'charset' ); ?>">
	    <meta name="viewport" content="width=device-width, initial-scale=1">
	    <meta http-equiv="X-UA-Compatible" content="IE=edge">
	    <link rel="profile" href="http://gmpg.org/xfn/11">
	    <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
		<link rel="shortcut icon" href="<?php echo get_template_directory_uri(); ?>/static/images/favicon.png" type="image/x-icon" />
		<?php wp_head(); ?>
	</head>

	<?php
		$body_classes = null;
		if ( fq_has_announcement() ) {
			$body_classes[] = 'has-announcement';
		}
	?>

	<body <?php body_class( $body_classes ); ?>>
		<div id="page" class="page">
			<a class="skip-link screen-reader-text" href="#content">
				<?php esc_html_e( 'Skip to content', 'fq-custom-theme' ); ?>
			</a>

			<header id="masthead" class="page-header" role="banner">
		  		<?php get_template_part( 'templates/header/structure' ); ?>
			</header><!-- #masthead -->
