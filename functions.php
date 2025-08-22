<?php
/**
 * Alam Al Anika Theme functions and definitions.
 *
 * @package AlamAlAnika
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Include all the core theme files.
 */
require get_template_directory() . '/inc/setup.php';
require get_template_directory() . '/inc/widgets.php';
require get_template_directory() . '/inc/template-tags.php';
require get_template_directory() . '/inc/customizer.php';
require get_template_directory() . '/inc/ajax-functions.php';

if ( class_exists( 'WooCommerce' ) ) {
	require get_template_directory() . '/inc/product-functions.php';
}


if ( ! function_exists( 'alam_al_anika_scripts' ) ) {
	/**
	 * Enqueue scripts and styles for the front-end.
	 */
	function alam_al_anika_scripts() {
		// Determine suffix for minified files.
		$suffix = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? '' : '.min';

		// Main stylesheet.
		wp_enqueue_style( 'alam-al-anika-style', get_stylesheet_uri(), array(), '1.0.1' );

		// Theme's custom CSS files.
		wp_enqueue_style( 'alam-al-anika-main-css', get_template_directory_uri() . '/assets/css/main' . $suffix . '.css', array(), '1.0.1' );
		wp_enqueue_style( 'alam-al-anika-responsive-css', get_template_directory_uri() . '/assets/css/responsive' . $suffix . '.css', array( 'alam-al-anika-main-css' ), '1.0.1' );

		// Font Awesome icons.
		wp_enqueue_style( 'font-awesome-all', get_template_directory_uri() . '/assets/fonts/font-awesome/css/all' . $suffix . '.css', array(), '5.15.4' );

		// Dynamic Google Fonts loading.
		$heading_font = get_theme_mod( 'heading_font', 'Cairo' );
		$body_font    = get_theme_mod( 'body_font', 'Segoe UI' );
		$google_fonts = array();

		if ( $heading_font && 'Segoe UI' !== $heading_font ) {
			$google_fonts[] = $heading_font;
		}
		if ( $body_font && 'Segoe UI' !== $body_font ) {
			$google_fonts[] = $body_font;
		}

		$google_fonts = array_unique( $google_fonts );

		if ( ! empty( $google_fonts ) ) {
			$font_families = implode( ':wght@300;400;700&family=', $google_fonts );
			$query_args    = array(
				'family'  => $font_families . ':wght@300;400;700',
				'display' => 'swap',
			);
			$fonts_url     = add_query_arg( $query_args, 'https://fonts.googleapis.com/css2' );

			wp_enqueue_style( 'alam-al-anika-google-fonts', esc_url( $fonts_url ), array(), null );
		}

		// Main JS file.
		wp_enqueue_script( 'alam-al-anika-main-js', get_template_directory_uri() . '/assets/js/main' . $suffix . '.js', array( 'jquery' ), '1.0.1', true );

		// Pass ajax_url and nonces to main.js.
		wp_localize_script(
			'alam-al-anika-main-js',
			'alam_anika_ajax',
			array(
				'ajax_url'          => admin_url( 'admin-ajax.php' ),
				'search_nonce'      => wp_create_nonce( 'search-nonce' ),
				'add_to_cart_nonce' => wp_create_nonce( 'add-to-cart-nonce' ),
				'quick_view_nonce'  => wp_create_nonce( 'quick-view-nonce' ),
			)
		);

		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}
	}
}
add_action( 'wp_enqueue_scripts', 'alam_al_anika_scripts' );


if ( ! function_exists( 'alam_al_anika_admin_scripts' ) ) {
	/**
	 * Enqueue scripts and styles for the admin area.
	 */
	function alam_al_anika_admin_scripts() {
		$suffix = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? '' : '.min';
		// Since you don't have admin.css, we only enqueue admin.js.
		wp_enqueue_script( 'alam-al-anika-admin-js', get_template_directory_uri() . '/assets/js/admin' . $suffix . '.js', array( 'jquery' ), '1.0.1', true );
	}
}
add_action( 'admin_enqueue_scripts', 'alam_al_anika_admin_scripts' );
