<?php
/**
 * The template for displaying breadcrumb nav
 * @package FQ_Bones_Theme
 */
?>

<?php
	if ( ! $breadcrumbs || ! $breadcrumbs->pages ) {
		return;
	}
?>

<div class="breadcrumbs">
	<?php $i = 0; ?>
	<?php foreach( $breadcrumbs->pages as $page ) : ?>

		<?php if ( $page->url ) : ?>

			<a href="<?php echo esc_url( $page->url ); ?>">
				<?php echo $page->label ?>
			</a>

		<?php else: ?>

			<span><?php echo $page->label ?></span>

		<?php endif; ?>

		<?php if ( $i < count( $breadcrumbs->pages ) ) : ?>
			<?php echo $breadcrumbs->separator; ?>
		<?php endif; ?>

	<?php $i++; ?>
	<?php endforeach; ?>
</div>
