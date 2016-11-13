<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package brood
 */

?>

	</div><!-- #content -->
	<footer id="colophon" class="site-footer" role="contentinfo">
		<?php if( is_active_sidebar('footer-left') || is_active_sidebar('footer-center') || is_active_sidebar('footer-right') ) : ?>
		<div class="foo-widgets">
			<div class="container">
				<div class="col-sm-4">
					<?php dynamic_sidebar('footer-left'); ?>
				</div>
				<div class="col-sm-4">
					<?php dynamic_sidebar('footer-center'); ?>
				</div>
				<div class="col-sm-4">
					<?php dynamic_sidebar('footer-right'); ?>
				</div>
			</div><!-- .container -->
		</div>
		<?php endif; ?>
		<div class="site-info">
			<?php
				$copyright 			= get_theme_mod( 'copyright_textbox', 'Proudly Powered by WordPress' );
				$copyright_flag = get_theme_mod( 'copyright_flag' );
				$copyright_link	= get_theme_mod( 'copyright_link' );
				if( $copyright_flag ) {
					printf( '<a href="%s">%s</a>', esc_url( $copyright_link ), $copyright );
				}else{
					echo $copyright;
				}
			?>
			<span class="sep"> | </span>
				<?php printf( __( 'WordPress Theme by <a href="%s" target="_blank">%s</a>', 'brood' ), esc_url( 'http://tidyhive.com/' ), 'Tidyhive'); ?>
		</div><!-- .site-info -->
	</footer><!-- #colophon -->
</div><!-- #page -->

<?php wp_footer(); ?>

</body>
</html>
