<?php
/**
 * Theme Customizer functionality.
 *
 * @package AlamAlAnika
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function alam_al_anika_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';

	if ( isset( $wp_customize->selective_refresh ) ) {
		$wp_customize->selective_refresh->add_partial(
			'blogname',
			array(
				'selector'        => '.site-title a',
				'render_callback' => 'alam_al_anika_customize_partial_blogname',
			)
		);
		$wp_customize->selective_refresh->add_partial(
			'blogdescription',
			array(
				'selector'        => '.site-description',
				'render_callback' => 'alam_al_anika_customize_partial_blogdescription',
			)
		);
	}

    // Example: Add a section for theme colors
    // $wp_customize->add_section( 'alam_al_anika_colors' , array(
    //     'title'      => __( 'Theme Colors', 'alam-al-anika' ),
    //     'priority'   => 30,
    // ) );
}
add_action( 'customize_register', 'alam_al_anika_customize_register' );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function alam_al_anika_customize_preview_js() {
	wp_enqueue_script( 'alam-al-anika-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'alam_al_anika_customize_preview_js' );