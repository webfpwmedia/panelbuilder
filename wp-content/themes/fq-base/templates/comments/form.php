<?php

$comment_args = array(
	'id_form'           => 'commentform',  // that's the wordpress default value! delete it or edit it ;)
	'id_submit'         => 'commentsubmit',
	'class_submit'		=> 'btn btn-primary',
	'title_reply'       => __( 'Would you like to comment?', 'fq-custom-theme' ),
	'title_reply_to'    => __( 'Replying to %s', 'fq-custom-theme' ),
	'cancel_reply_link' => __( 'Cancel Reply', 'fq-custom-theme' ),
	'label_submit'      => __( 'Post Comment', 'fq-custom-theme' ),
	'comment_field' =>  '<p><textarea placeholder="Start typing..." id="comment" class="form-control" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
	'comment_notes_after' => '',
);

comment_form( $comment_args );

?>
