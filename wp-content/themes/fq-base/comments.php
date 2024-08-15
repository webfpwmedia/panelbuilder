<?php
/**
 * The template for displaying comments
 * @package FQ_Bones_Theme_Parent
 */

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">
	
	<?php if ( comments_open() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
	
		<?php locate_template( '/templates/comments/form.php', true ); ?>
	
	<?php elseif ( ! comments_open() && have_comments() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		
		<?php locate_template( '/templates/comments/closed.php', true ); ?>
			
	<?php endif; ?>
	
	<?php if ( have_comments() ) : ?>

		<?php locate_template( '/templates/comments/title.php', true ); ?>
		<?php locate_template( '/templates/comments/list.php', true ); ?>
		<?php locate_template( '/templates/comments/nav.php', true ); ?>

	<?php endif; ?>

</div><!-- #comments -->
