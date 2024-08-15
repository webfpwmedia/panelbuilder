<h2 class="comments-title">
	
	<?php
	$comments_number = get_comments_number();
	if ( '1' === $comments_number ) {
		printf( _x( 'One Reply to &ldquo;%s&rdquo;', 'comments title', 'fq-custom-theme' ), get_the_title() );
	} else {
		printf(
			_nx(
				'%1$s Reply to &ldquo;%2$s&rdquo;',
				'%1$s Replies to &ldquo;%2$s&rdquo;',
				$comments_number,
				'comments title',
				'fq-custom-theme'
			),
			number_format_i18n( $comments_number ),
			get_the_title()
		);
	}
	?>
	
</h2>
