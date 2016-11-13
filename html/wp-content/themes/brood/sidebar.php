<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package brood
 */

if ( ! is_active_sidebar( 'sidebar-1' ) ) {
	return;
}
?>
</div>
	<div class="col-md-4">
		<div id="secondary" class="widget-area" role="complementary">
			<?php dynamic_sidebar( 'sidebar-1' ); ?>
		</div><!-- #secondary -->
	</div><!-- .col-md-4 -->
</div><!-- .container -->
