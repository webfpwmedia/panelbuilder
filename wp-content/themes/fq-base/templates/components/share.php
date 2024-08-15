<?php
/**
 * The template for displaying the Mailchimp list signup
 * @package FQ_Bones_Theme
 */
?>

<?php

$channels = [
	'facebook',
	'twitter',
	'pinterest',
];
$lead_in = 'Share this post';

?>

<div class="meta-item share-links">
	<?php fq_the_share_buttons( $channels, $lead_in ); ?>
</div>
