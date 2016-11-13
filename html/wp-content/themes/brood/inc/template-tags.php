<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package brood
 */

if ( ! function_exists( 'brood_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function brood_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( '%s', 'post date', 'brood' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( '%s', 'post author', 'brood' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);

	echo '<h6><span class="posted-on">' . $posted_on . '</span><span class="seperator">|</span><span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.
	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="seperator">|</span><span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'brood' ), esc_html__( '1 Comment', 'brood' ), esc_html__( '% Comments', 'brood' ) );
		echo '</span>';
	}


}
endif;
if ( ! function_exists( 'brood_entry_footer' ) ) :
/**
 * Prints post category
 */
function brood_entry_cat(){
	// if( 'post' === get_post_type() ){

	// 	$categories_list = get_the_category_list( esc_html__( ', ', 'brood' ) );
		
	// 	if ( $categories_list && brood_categorized_blog() && count( $categories_list ) < 2 ) {
	// 		printf( '<div class="entry-cat">' . esc_html__( '%1$s', 'brood' ) . '</div>', $categories_list ); // WPCS: XSS OK.
	// 	}
	// }
	$categories = get_the_category();
	$category_link = get_category_link($categories[0]->term_id);
	return '<div class="entry-cat"><a href="'.esc_url( $category_link ).'">'.esc_html__( $categories[0]->name, 'brood').'</a></div>';
}
endif;
if ( ! function_exists( 'brood_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function brood_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		
		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'brood' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links"><i class="glyphicon glyphicon-tags"></i>' . esc_html__( '%1$s', 'brood' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'brood' ), esc_html__( '1 Comment', 'brood' ), esc_html__( '% Comments', 'brood' ) );
		echo '</span>';
	}

	edit_post_link(
		'<span class="edit-link"><i class="glyphicon glyphicon-pencil"></i></span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function brood_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'brood_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,

			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'brood_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so brood_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so brood_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in brood_categorized_blog.
 */
function brood_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'brood_categories' );
}
add_action( 'edit_category', 'brood_category_transient_flusher' );
add_action( 'save_post',     'brood_category_transient_flusher' );

/**
 * Prints the featured posts
 */
function brood_featured_posts(){
	$args = array(
		'post_status'			=>	'publish',
		'tag' 					=>	'featured',
		'posts_per_page'		=>	5,
		'ignore_sticky_posts'	=>	true,
		);
	$featured_posts = new WP_Query($args);
	if($featured_posts->have_posts()){
		if($featured_posts->post_count > 1){
			wp_enqueue_script('owl-js', get_template_directory_uri() . '/js/owl.min.js', array('jquery') );
			wp_enqueue_style('owl-css', get_template_directory_uri() . '/css/owl.css');
			wp_enqueue_script('brood-js', get_template_directory_uri() . '/js/script.js', array('jquery') );
		}
		echo '<div class="feat-slider">';
		while($featured_posts->have_posts()){
			$featured_posts->the_post();
			if(get_the_post_thumbnail() != ''){
				$html = sprintf( '<article class="item">%s %s</article>',
						get_the_post_thumbnail('','', array('class' => 'img-responsive')),
						sprintf('<div class="feat-content">%s %s %s %s</div>',
							brood_entry_cat(), 
							'<h2 class="feat-title"><a href="'.get_the_permalink().'">'.get_the_title().'</a></h2>',
							'<p>'.excerpt(50).'</p>',
							'<a class="btn-cta-2" href="'.get_the_permalink().'">'.__('Read More', 'brood').'</a>'
							)
				 );
				echo $html;
			}
		}
		echo '</div>';
	}

}