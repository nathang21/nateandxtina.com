<?php
add_filter( 'comment_form_default_fields', 'bootstrap_comment_fields' );
function bootstrap_comment_fields( $fields ){
	$commenter  = 	wp_get_current_commenter();
	$req 		=	get_option( 'require_name_email' );
	$aria_req	=	( $req ? " aria-required = 'true' " : '' );
	$html5		=	current_theme_supports( 'html5', 'comment-form' ) ? 1 : 0;

	$fields 	=	array(
		'author'	=>	'<div class="row"><div class="col-sm-6"><div class="form-group comment-form-author">' . '<label for="author">' . __( 'Name', 'brood' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                		'<input class="form-control" id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30"' . $aria_req . ' /></div></div>',
		'email'  	=> 	'<div class="col-sm-6"><div class="form-group comment-form-email"><label for="email">' . __( 'Email', 'brood' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label> ' .
                		'<input class="form-control" id="email" name="email" ' . ( $html5 ? 'type="email"' : 'type="text"' ) . ' value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30"' . $aria_req . ' /></div></div></div>',
    	'url'    	=> 	'<div class="form-group comment-form-url"><label for="url">' . __( 'Website', 'brood' ) . '</label> ' .
                		'<input class="form-control" id="url" name="url" ' . ( $html5 ? 'type="url"' : 'type="text"' ) . ' value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="30" /></div>'
		);
	unset($fields['url']);
	return $fields;
}

add_filter( 'comment_form_defaults', 'bootstrap_comment_form' );
function bootstrap_comment_form( $args ) {
    $args['comment_field'] = '<div class="form-group comment-form-comment">
            <label for="comment">' . _x( 'Comment', 'noun', 'brood' ) . '</label> 
            <textarea class="form-control" id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea>
        </div>';
    $args['class_submit'] = 'btn btn-default btn-cta'; // since WP 4.1

    return $args;
}

if ( ! function_exists( 'brood_comment' ) ) :
/**
 * Template for comments and pingbacks.
 *
 * To override this walker in a child theme without modifying the comments template
 * simply create your own brood_comment(), and that function will be used instead.
 *
 * Used as a callback by wp_list_comments() for displaying the comments.
 *
 * @since brood 1.0
 */
function brood_comment( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
		// Display trackbacks differently than normal comments.
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<p><?php _e( 'Pingback:', 'brood' ); ?> <?php comment_author_link(); ?> <?php edit_comment_link( __( '(Edit)', 'brood' ), '<span class="edit-link">', '</span>' ); ?></p>
	<?php
			break;
		default :
		// Proceed with normal comments.
		global $post;
	?>
	<li <?php comment_class(); ?> id="li-comment-<?php comment_ID(); ?>">
		<section id="comment-<?php comment_ID(); ?>" class="comment">
			<div class="avatar">
				<?php echo get_avatar( $comment, 44 ); ?>
			</div>
			<div class="comment-content">
				<h3 class="comment-author">
					<?php
						printf( '%1$s %2$s',
							get_comment_author_link(),
							// If current post author is also comment author, make it known visually.
							( $comment->user_id === $post->post_author ) ? '<span class="badge">' . __( 'Post author', 'brood' ) . '</span>' : ''
						);
					?>
				</h3>
				<p class="comment-meta">
					<?php
					printf( '<a href="%1$s"><time datetime="%2$s">%3$s</time></a>',
						esc_url( get_comment_link( $comment->comment_ID ) ),
						get_comment_time( 'c' ),
						/* translators: 1: date, 2: time */
						sprintf( __( '%1$s at %2$s', 'brood' ), get_comment_date(), get_comment_time() )
					);
					?>
				</p>
				<div class="comment-text">
					<?php comment_text(); ?>
				</div>
				<div class="comment-reply">
					<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'brood' ), 'after' => ' <span></span>', 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?>
				</div>
			</div>
		</section><!-- #comment-## -->
	<?php
		break;
	endswitch; // end comment_type check
}
endif;
?>
