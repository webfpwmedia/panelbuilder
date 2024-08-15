<ol class="medias list-unstyled">
		<?php
		wp_list_comments( array(
			'walker'	  => new Bootstrap_Comment_Walker,
			'avatar_size' => 50,
			'style'       => 'ol',
			'short_ping'  => true,
			// 'reverse_top_level' => false, //true displays newest comments first
			// 'reverse_children' => false, //true displays newest comments first
			'reply_text'  => __( 'Reply', 'fq-custom-theme' ),
		) );
	?>
</ol>

