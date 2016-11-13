<?php
/**
 * Template part for displaying posts.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package brood
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<header class="entry-header">
		<?php echo brood_entry_cat(); ?>

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<?php if ( 'post' === get_post_type() ) : ?>
		<div class="entry-meta">
			<?php brood_posted_on(); ?>
		</div><!-- .entry-meta -->
		<?php endif; ?>
	</header><!-- .entry-header -->
	<?php
		if( get_the_post_thumbnail() != '' ){
			printf( '<div class="entry-media">%s</div>', get_the_post_thumbnail('','', array('class' => 'img-responsive') ) );
		}
	?>
	<div class="entry-content">
		<?php
			the_excerpt( sprintf(
				/* translators: %s: Name of current post. */
				wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'brood' ), array( 'span' => array( 'class' => array() ) ) ),
				the_title( '<span class="screen-reader-text">"', '"</span>', false )
			) );
		?>

		<?php
			wp_link_pages( array(
				'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'brood' ),
				'after'  => '</div>',
			) );
		?>
	</div><!-- .entry-content -->
	<div class="more-link">
		<?php echo '<a href="'.esc_url( get_permalink() ).'">'.__( 'Continue Reading', 'brood' ).'</a>'; ?>
	</div>
	<?php edit_post_link(
			'<span class="edit-link"><i class="glyphicon glyphicon-pencil"></i></span>'
			);
	?>
</article><!-- #post-## -->
