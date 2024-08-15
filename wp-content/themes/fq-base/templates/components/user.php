<?php
/**
 * The template for displaying the login/out user icon, etc.
 * @package FQ_Bones_Theme
 */

use FigoliQuinn\StatesIndustries\PanelSequences\PanelSequenceCPT;

$redirect = get_the_permalink();

?>

<div class="login-out">

	<?php if ( ! is_user_logged_in() ): ?>
		<a href="<?php echo esc_url( wp_login_url( $redirect ) ); ?>">
			<i class="fas fa-sign-in-alt"></i>
		</a>
	<?php else: ?>
		<a href="<?php echo get_post_type_archive_link( PanelSequenceCPT::SLUG ); ?>">
			<i class="fas fa-layer-group"></i> Choose Panel
		</a>
		<a href="<?php echo esc_url( wp_logout_url( $redirect ) ); ?>">
			<i class="fas fa-sign-out-alt"></i>	 Sign Out
		</a>
	<?php endif; ?>
</div>
