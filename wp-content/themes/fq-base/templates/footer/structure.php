<?php
/**
 * The template for displaying the footer content.
 * @package FQ_Bones_Theme
 */
?>

<div class="page-footer-content">
	<div class="upper-footer">
		<div class="branding">
			<?php get_template_part( 'templates/brand/logo', 'mark' ); ?>
		</div>
		<?php get_template_part( 'templates/nav/sitemap' ); ?>
	</div>
	<div class="lower-footer">
		<?php get_template_part( 'templates/components/address' ); ?>
		<?php get_template_part( 'templates/components/social' ); ?>
		<?php get_template_part( 'templates/components/phone' ); ?>
	</div>
</div><!-- .footer-content -->
<div class="fineprint">
	<?php get_template_part( 'templates/footer/copyright' ); ?>
</div>


<!-- generally hidden elements until they're not! -->
<?php get_template_part( 'templates/components/ui', 'progress' ); ?>
<?php get_template_part( 'templates/components/ui', 'overlay' ); ?>
