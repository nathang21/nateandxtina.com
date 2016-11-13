<?php
/**
 * brood Theme Customizer.
 *
 * @package brood
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function brood_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

	/**
	 * Footer options section
	 * Setting 1 - copyright text
	 * setting 2 - copyright link checkbox
	 * setting 3 - copyright link text
	 */
	$wp_customize->add_section(
        'footer_options',
        array(
            'title' => 'Footer Options',
            'description' => __( 'This is a Footer options section.', 'brood' ),
            'priority' => 100,
        )
    );
	$wp_customize->add_setting(
		'copyright_textbox',
		array(
        	'default' 			=> 	__( 'Proudly powered by wordpress', 'brood' ),
        	'sanitize_callback'	=>	'copyright_text_sanitize'
    	)
	);
	$wp_customize->add_control(
	    'copyright_textbox',
	    array(
	        'label' => __( 'Copyright text', 'brood' ),
	        'section' => 'footer_options',
	        'type' => 'text',
	    )
	);
	$wp_customize->add_setting(
		'copyright_flag',
		array(
        	'type' => 'theme_mod',
        	'sanitize_callback'	=>	'copyright_flag_sanitize'
    	)
	);
	$wp_customize->add_control(
	    'copyright_flag',
	    array(
	        'label' 	=> __( 'Use below link for copyright text', 'brood' ),
	        'section' 	=> 'footer_options',
	        'type' 		=> 'checkbox',
	    )
	);
	$wp_customize->add_setting(
		'copyright_link',
		array(
        	'type' 		=> 	'theme_mod',
        	'sanitize_callback'	=>	'copyright_url_sanitize'
    	)
	);
	$wp_customize->add_control(
	    'copyright_link',
	    array(
	        'label' => __( 'Copyright link', 'brood' ),
	        'section' => 'footer_options',
	        'type' => 'text',
	    )
	);
}
add_action( 'customize_register', 'brood_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function brood_customize_preview_js() {
	wp_enqueue_script( 'brood_customizer', get_template_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20130508', true );
}
add_action( 'customize_preview_init', 'brood_customize_preview_js' );

/**
 * Sanitize functions
 */
function copyright_text_sanitize( $input ){
	return esc_html( $input );
}
function copyright_flag_sanitize( $input ){
	if( $input )
		return 1;
	else
		return '';
}
function copyright_url_sanitize( $input ){
	return esc_url_raw( $input );
}
