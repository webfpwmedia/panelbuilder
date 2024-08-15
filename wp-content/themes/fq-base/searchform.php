<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<fieldset class="form-fields">
		<label for="searchfor" class="screen-reader-text placeholder"><?php esc_attr_e( 'Search ...', 'fq-custom-theme' ); ?></label>
		<input id="searchfor" type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search &hellip;', 'placeholder', 'fq-custom-theme' ); ?>" value="<?php echo esc_attr( get_search_query() ); ?>" name="s">
		<button type="submit" class="search-submit no-button"><i class="fas fa-search"></i></button>
	</fieldset>
</form>
