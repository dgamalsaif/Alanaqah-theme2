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
	// Default WordPress settings
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

    // =================================================================
    // START: قسم الألوان الإضافية
    // =================================================================
    
    // 1. إعداد لون الروابط
    $wp_customize->add_setting( 'link_color', array(
        'default'   => '#ff2b4d',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    // 2. أداة التحكم بلون الروابط
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'link_color_control', array(
        'label'    => __( 'Link Color', 'alam-al-anika' ),
        'section'  => 'colors', // إضافة الخيار إلى قسم الألوان الافتراضي
        'settings' => 'link_color',
    ) ) );

    // 3. إعداد لون خلفية التذييل
    $wp_customize->add_setting( 'footer_bg_color', array(
        'default'   => '#333333',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_hex_color',
    ) );

    // 4. أداة التحكم بلون خلفية التذييل
    $wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'footer_bg_color_control', array(
        'label'    => __( 'Footer Background Color', 'alam-al-anika' ),
        'section'  => 'colors',
        'settings' => 'footer_bg_color',
    ) ) );
    
    // =================================================================
    // END: قسم الألوان الإضافية
    // =================================================================


    // =================================================================
    // START: قسم الخطوط (Typography)
    // =================================================================
    
    $wp_customize->add_section( 'typography_section', array(
        'title'    => __( 'Typography', 'alam-al-anika' ),
        'priority' => 20,
    ) );
    
    // 1. إعداد خط العناوين
    $wp_customize->add_setting( 'heading_font', array(
        'default'   => 'Cairo',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    // 2. أداة التحكم بخط العناوين
    $wp_customize->add_control( 'heading_font_control', array(
        'type'    => 'select',
        'label'   => __( 'Headings Font', 'alam-al-anika' ),
        'section' => 'typography_section',
        'settings' => 'heading_font',
        'choices' => array(
            'Cairo'   => 'Cairo',
            'Poppins' => 'Poppins',
            'Roboto'  => 'Roboto',
            'Montserrat' => 'Montserrat',
        ),
    ) );

    // 3. إعداد خط النصوص
    $wp_customize->add_setting( 'body_font', array(
        'default'   => 'Segoe UI',
        'transport' => 'refresh',
        'sanitize_callback' => 'sanitize_text_field',
    ) );

    // 4. أداة التحكم بخط النصوص
    $wp_customize->add_control( 'body_font_control', array(
        'type'    => 'select',
        'label'   => __( 'Body Font', 'alam-al-anika' ),
        'section' => 'typography_section',
        'settings' => 'body_font',
        'choices' => array(
            'Segoe UI' => 'Segoe UI (System Default)',
            'Cairo'   => 'Cairo',
            'Poppins' => 'Poppins',
            'Roboto'  => 'Roboto',
            'Open Sans' => 'Open Sans',
        ),
    ) );

    // 5. إعداد حجم الخط الأساسي
    $wp_customize->add_setting( 'base_font_size', array(
        'default'   => '16',
        'transport' => 'refresh',
        'sanitize_callback' => 'absint',
    ) );

    // 6. أداة التحكم بحجم الخط الأساسي
    $wp_customize->add_control( 'base_font_size_control', array(
        'type'    => 'number',
        'label'   => __( 'Base Font Size (px)', 'alam-al-anika' ),
        'section' => 'typography_section',
        'settings' => 'base_font_size',
        'input_attrs' => array(
            'min' => 12,
            'max' => 22,
            'step' => 1,
        ),
    ) );

    // =================================================================
    // END: قسم الخطوط (Typography)
    // =================================================================
}
add_action( 'customize_register', 'alam_al_anika_customize_register' );


/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function alam_al_anika_customize_preview_js() {
	wp_enqueue_script( 'alam-al-anika-customizer-preview', get_template_directory_uri() . '/assets/js/admin.js', array( 'customize-preview' ), '1.0', true );
}
add_action( 'customize_preview_init', 'alam_al_anika_customize_preview_js' );


/**
 * This new function will generate and print our custom CSS in the <head> of the site.
 */
function alam_al_anika_generate_customizer_css() {
    // Start CSS output
    $css_output = '';
    
    // Get saved settings from the Customizer with defaults
    $link_color = get_theme_mod( 'link_color', '#ff2b4d' );
    $footer_bg_color = get_theme_mod( 'footer_bg_color', '#333333' );
    $heading_font = get_theme_mod( 'heading_font', 'Cairo' );
    $body_font = get_theme_mod( 'body_font', 'Segoe UI' );
    $base_font_size = get_theme_mod( 'base_font_size', '16' );
    
    // Start generating CSS
    $css_output .= '<style type="text/css">';
    
    // Root variables for easy access
    $css_output .= ':root {';
    if ( ! empty( $base_font_size ) && $base_font_size != '16' ) {
        $css_output .= '--base-font-size: ' . esc_attr( $base_font_size ) . 'px;';
    }
    $css_output .= '}';

    // Apply fonts
    $css_output .= 'body, button, input, select, textarea { font-family: "' . esc_attr( $body_font ) . '", sans-serif; font-size: var(--base-font-size, 16px); }';
    $css_output .= 'h1, h2, h3, h4, h5, h6, .logo a, .section-title { font-family: "' . esc_attr( $heading_font ) . '", sans-serif; }';
    
    // Apply colors
    if ( ! empty( $link_color ) && strtolower($link_color) !== '#ff2b4d' ) {
        $css_output .= 'a, .view-all { color: ' . esc_attr( $link_color ) . '; }';
        $css_output .= 'a:hover { opacity: 0.8; }';
    }
    
    if ( ! empty( $footer_bg_color ) && strtolower($footer_bg_color) !== '#333333' ) {
        $css_output .= '.site-footer { background-color: ' . esc_attr( $footer_bg_color ) . '; }';
    }
    
    $css_output .= '</style>';
    
    // Print the generated CSS
    echo $css_output;
}
add_action( 'wp_head', 'alam_al_anika_generate_customizer_css' );