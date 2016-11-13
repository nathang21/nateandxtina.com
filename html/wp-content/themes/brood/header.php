<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package brood
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<div id="page" class="hfeed site">
	<header id="masthead" class="site-header" role="banner">
        <div class="container">
            <div class="col-sm-12">
                <div class="site-branding">
                    <?php if( function_exists('get_custom_logo') && get_custom_logo() != '' ): ?>
                        <?php the_custom_logo(); ?>
                    <?php else: ?>
                        <div class="site-branding_text">
    						<?php if ( is_front_page() && is_home() ) : ?>
    						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
    						<?php else : ?>
    							<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
    						<?php endif; ?>
    						<p class="site-description">
    							<?php echo esc_html( bloginfo( 'description' ) ); ?>
    						</p>
    					</div><!-- .site-branding_text -->
                    <?php endif; ?>
                    <button data-target="#site-navigation" data-toggle="collapse" class="navbar-toggle" type="button" aria-expanded="true">
                        <span class="sr-only"><?php _e( 'Toggle navigation', 'brood' ); ?></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div><!-- .site-branding -->
                <nav id="site-navigation" class="main-navigation navbar-collapse collapse" role="navigation">
                    <?php
                    	$args = array(
                    		'theme_location'	=>	'primary',
                    		'menu_class'		=>	'nav navbar-nav',
                    		'container'         => 	'',
                    		'fallback_cb'       => 	'wp_bootstrap_navwalker::fallback',
                    		'walker'			=>	new wp_bootstrap_navwalker()
                    		);
                    	wp_nav_menu( $args );
                    ?>
                </nav><!-- #site-navigation -->
            </div>
						<?php if ( get_header_image() ) : ?>
							<div class="site-header_background">
									<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" >
										<img src="<?php header_image(); ?>" width="<?php echo esc_attr( get_custom_header()->width ); ?>" height="<?php echo esc_attr( get_custom_header()->height ); ?>" alt="">
									</a>
							</div>
						<?php endif; // End header image check. ?>
        </div>
    </header><!-- #masthead -->
    <?php 
        if( is_home() ) 
            brood_featured_posts(); 
    ?>
	<div id="content" class="site-content">
		<div class="container">
			<div class="col-md-8">
