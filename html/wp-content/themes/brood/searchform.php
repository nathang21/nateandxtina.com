<form id="searchform" class="search-form" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
	<input type="text" name="s" id="s" class="form-control" size="19" placeholder="<?php esc_attr_e( 'Enter search text', 'brood' ); ?>"/>
	<input type="submit" class="btn btn-cta" value="<?php esc_attr_e('Search', 'brood'); ?>" />
</form>
