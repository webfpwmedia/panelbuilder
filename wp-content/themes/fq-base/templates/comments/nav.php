<?php
$paginate_args = array(
	'show_all'           => true,
	// 'end_size'           => 1,
	// 'mid_size'           => 2,
	'prev_next'          => true,
	'prev_text'          => '<i class="fal fa-angle-double-left"></i>Back<span class="screen-reader-text">' . __( 'Back', 'fq-custom-theme' ) . '</span>',
	'next_text'          => 'More<i class="fal fa-angle-double-right"></i><span class="screen-reader-text">' . __( 'More', 'fq-custom-theme' ) . '</span>',
	'type'               => 'plain', // can also be 'array' or 'list'
	'before_page_number' => '',
	'after_page_number'  => ''
);

the_comments_pagination( $paginate_args );

?>