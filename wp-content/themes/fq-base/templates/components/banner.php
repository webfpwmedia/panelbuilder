<?php
/**
 * The template for displaying a top banner.
 * @package FQ_Bones_Theme
 */

if ( ! fq_has_announcement() ) {
	return;
}

$link = get_field( 'banner_message_link', 'option' );
$atts = '';
if ( ! empty( $link['target'] ) ) {
	$atts = ' target="' . $link['target'] . '" rel="noopener"';
}

?>
<section class="page-header-announcement">
	<div class="banner-message">
	    <p>
			<?php the_field( 'banner_message', 'option' ); ?>
			<?php if ( $link ) : ?>
				<a class="banner-link" href="<?php echo $link['url']; ?>"<?php echo $atts; ?>><?php echo $link['title']; ?></a>
			<?php endif; ?>
		</p>
	</div>
</section>
