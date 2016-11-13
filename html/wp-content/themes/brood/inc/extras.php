<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package brood
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function brood_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	return $classes;
}
add_filter( 'body_class', 'brood_body_classes' );

/**
 * Changes excerpt length on fly
 */
function excerpt($limit) {
  $excerpt = explode(' ', get_the_excerpt(), $limit);
  if (count($excerpt)>=$limit) {
    array_pop($excerpt);
    $excerpt = implode(" ",$excerpt).'...';
  } else {
    $excerpt = implode(" ",$excerpt);
  } 
  $excerpt = preg_replace('`\[[^\]]*\]`','',$excerpt);
  return $excerpt;
}
/**
 * Adds a link to the submenu under Posts
 */
if ( !function_exists( 'brood_featured_posts_link' ) ) {
function brood_featured_posts_link() {
    global $submenu;
    $link_to_add = 'edit.php?tag=featured';
    // change edit.php to the top level menu you want to add it to 
    $submenu['edit.php'][] = array('Featured Posts', 'edit_posts', $link_to_add);
}
add_action('admin_menu', 'brood_featured_posts_link');
}
/**
 * Update notice messages
 * 
 */
function brood_plugin_notice() {
	
	global $current_user;
	
	$user_id = $current_user->ID;
	
	if (!get_user_meta($user_id, 'brood-admin-notice_ignore')) {
		
		$message = '<ol style="margin-top: 0px;">
						<h4 style="margin-top: 0px;">New Features added to theme</h4>
						<li>Setting Featured Posts - Add "featured" tag to your post and don\'t forget to add a featured image.</li>
						<li>Custom Logo - You can add a logo from Theme customizer which will show up instead of name and description in top bar.</li>
					</ol> ';
		$message .= '<p>Few Bug fixes</p>';
		$message .= '<p>In case you have any query, ask it on <a href="'.esc_url('https://wordpress.org/support/theme/brood').'" target="_blank" >wordpress.org Theme Forums</a></p>';
		echo '<div class="updated notice"><p>'. $message .' <a href="?brood-admin-notice=0">Dismiss this notice</a></p></div>';
		
	}
	
}
add_action('admin_notices', 'brood_plugin_notice');
	
function brood_plugin_notice_ignore() {
	
	global $current_user;
	
	$user_id = $current_user->ID;
	
	if (isset($_GET['brood-admin-notice']) && '0' == $_GET['brood-admin-notice']) {
		
		add_user_meta($user_id, 'brood-admin-notice_ignore', 'true', true);
		
	}
	
}
add_action('admin_init', 'brood_plugin_notice_ignore');