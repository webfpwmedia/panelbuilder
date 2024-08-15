<nav id="post-nav" class="prev-next-nav" role="navigation">
	<h2 class="screen-reader-text"><?php esc_html_e( 'Pagination navigation', 'fq-custom-theme' ); ?></h2>
	<div class="nav-links">
		<div class="prev-next nav-previous"><?php previous_posts_link( '<span><i class="fas fa-arrow-left"></i></span>' . esc_html__( 'Back', 'fq-custom-theme' ) ); ?></div>
		<div class="pagination">
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( '', 'fq-custom-theme' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .pagination -->
		<div class="prev-next nav-next"><?php next_posts_link( esc_html__( 'More', 'fq-custom-theme' ) . '<span><i class="fas fa-arrow-right"></i></span>' ); ?></div>
	</div><!-- .nav-links -->
</nav><!-- #post-nav -->
