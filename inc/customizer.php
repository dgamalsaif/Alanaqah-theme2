<?php
/**
 * Alam Al Anika Theme Customizer.
 *
 * @package AlamAlAnika
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function alam_al_anika_customize_register( $wp_customize ) {
	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';

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

	// Colors Panel.
	$wp_customize->add_panel(
		'alam_al_anika_colors_panel',
		array(
			'title'    => __( 'Theme Colors', 'alam-al-anika' ),
			'priority' => 10,
		)
	);

	// Primary Color Setting.
	$wp_customize->add_section(
		'alam_al_anika_primary_color_section',
		array(
			'title' => __( 'Primary Color', 'alam-al-anika' ),
			'panel' => 'alam_al_anika_colors_panel',
		)
	);

	$wp_customize->add_setting(
		'primary_color',
		array(
			'default'           => '#ff2b4d',
			'sanitize_callback' => 'sanitize_hex_color',
			'transport'         => 'refresh',
		)
	);

	$wp_customize->add_control(
		new WP_Customize_Color_Control(
			$wp_customize,
			'primary_color',
			array(
				'label'   => __( 'Primary Color', 'alam-al-anika' ),
				'section' => 'alam_al_anika_primary_color_section',
			)
		)
	);

	// Typography Panel.
	$wp_customize->add_panel(
		'alam_al_anika_typography_panel',
		array(
			'title'    => __( 'Theme Typography', 'alam-al-anika' ),
			'priority' => 20,
		)
	);

	// Heading Font Setting.
	$wp_customize->add_section(
		'alam_al_anika_heading_font_section',
		array(
			'title' => __( 'Headings Font', 'alam-al-anika' ),
			'panel' => 'alam_al_anika_typography_panel',
		)
	);

	$wp_customize->add_setting(
		'heading_font',
		array(
			'default'           => 'Cairo',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'heading_font',
		array(
			'label'   => __( 'Heading Font Family', 'alam-al-anika' ),
			'section' => 'alam_al_anika_heading_font_section',
			'type'    => 'text',
		)
	);

	// Body Font Setting.
	$wp_customize->add_section(
		'alam_al_anika_body_font_section',
		array(
			'title' => __( 'Body Font', 'alam-al-anika' ),
			'panel' => 'alam_al_anika_typography_panel',
		)
	);

	$wp_customize->add_setting(
		'body_font',
		array(
			'default'           => 'Segoe UI',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);

	$wp_customize->add_control(
		'body_font',
		array(
			'label'   => __( 'Body Font Family', 'alam-al-anika' ),
			'section' => 'alam_al_anika_body_font_section',
			'type'    => 'text',
		)
	);
}
add_action( 'customize_register', 'alam_al_anika_customize_register' );

/**
 * Render the site title for the selective refresh partial.
 */
function alam_al_anika_customize_partial_blogname() {
	bloginfo( 'name' );
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function alam_al_anika_customize_partial_blogdescription() {
	bloginfo( 'description' );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function alam_al_anika_customize_preview_js() {
	wp_enqueue_script( 'alam-al-anika-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array( 'customize-preview' ), '1.0.0', true );
}
add_action( 'customize_preview_init', 'alam_al_anika_customize_preview_js' );

/**
 * Adds custom CSS from the customizer to the head.
 */
function alam_al_anika_customize_css() {
	$primary_color = get_theme_mod( 'primary_color', '#ff2b4d' );
	$body_font     = get_theme_mod( 'body_font', 'Segoe UI' );
	$heading_font  = get_theme_mod( 'heading_font', 'Cairo' );

	// Sanitize the color value again just in case.
	$primary_color = sanitize_hex_color( $primary_color );
	?>
	<style type="text/css">
		body { 
			font-family: '<?php echo esc_attr( $body_font ); ?>', sans-serif; 
		}
		h1, h2, h3, h4, h5, h6 { 
			font-family: '<?php echo esc_attr( $heading_font ); ?>', sans-serif; 
		}
		:root {
			--primary-color: <?php echo esc_attr( $primary_color ); ?>;
		}
	</style>
	<?php
}
add_action( 'wp_head', 'alam_al_anika_customize_css' );