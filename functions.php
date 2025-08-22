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


/**
 * Enqueue scripts and styles for the front-end.
 */
function alam_al_anika_scripts() {
    // =================================================================
    // START: تعديل تحسين الأداء
    // =================================================================
    // تحديد لاحقة .min تلقائيًا عندما لا يكون الموقع في وضع التصحيح
    $suffix = ( defined( 'WP_DEBUG' ) && WP_DEBUG ) ? '' : '.min';
    // =================================================================
    // END: تعديل تحسين الأداء
    // =================================================================

	// Main stylesheet.
	wp_enqueue_style( 'alam-al-anika-style', get_stylesheet_uri(), array(), '1.0.0' );

    // Theme's custom CSS file.
    wp_enqueue_style( 'alam-al-anika-main-css', get_template_directory_uri() . '/assets/css/main' . $suffix . '.css', array(), '1.0.0' );

	// Font Awesome icons.
	wp_enqueue_style( 'font-awesome-all', get_template_directory_uri() . '/assets/fonts/font-awesome/css/all' . $suffix . '.css', array(), '5.15.4' );

    // =================================================================
    // START: تعديل تحميل خطوط جوجل الديناميكي
    // =================================================================
    $heading_font = get_theme_mod( 'heading_font', 'Cairo' );
    $body_font = get_theme_mod( 'body_font', 'Segoe UI' );
    $google_fonts = array();

    // إضافة خط العناوين إلى القائمة إذا لم يكن خط النظام
    if ( $heading_font && $heading_font !== 'Segoe UI' ) {
        $google_fonts[] = $heading_font;
    }
    // إضافة خط النصوص إلى القائمة إذا لم يكن خط النظام
    if ( $body_font && $body_font !== 'Segoe UI' ) {
        $google_fonts[] = $body_font;
    }
    
    // التأكد من عدم تكرار تحميل نفس الخط
    $google_fonts = array_unique($google_fonts);

    if ( ! empty( $google_fonts ) ) {
        // بناء الرابط لخطوط جوجل مع الأوزان المطلوبة
        $font_families = implode( ':wght@300;400;700&family=', $google_fonts );
        $query_args = array(
            'family'  => $font_families . ':wght@300;400;700',
            'display' => 'swap', // لتحسين الأداء
        );
        $fonts_url = add_query_arg( $query_args, 'https://fonts.googleapis.com/css2' );
        
        // تحميل ملف خطوط جوجل
        wp_enqueue_style( 'alam-al-anika-google-fonts', $fonts_url, array(), null );
    }
    // =================================================================
    // END: تعديل تحميل خطوط جوجل الديناميكي
    // =================================================================

	// Main JS file.
	wp_enqueue_script( 'alam-al-anika-main-js', get_template_directory_uri() . '/assets/js/main' . $suffix . '.js', array( 'jquery' ), '1.0.0', true );

    // Pass ajax_url to our main.js
    wp_localize_script( 'alam-al-anika-main-js', 'alam_anika_ajax', array(
        'ajax_url' => admin_url( 'admin-ajax.php' )
    ));

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'alam_al_anika_scripts' );

/**
 * Enqueue scripts and styles for the admin area.
 */
function alam_al_anika_admin_scripts() {
	wp_enqueue_style( 'alam-al-anika-admin-style', get_template_directory_uri() . '/assets/css/admin.css', array(), '1.0.0' );
	wp_enqueue_script( 'alam-al-anika-admin-js', get_template_directory_uri() . '/assets/js/admin.js', array( 'jquery' ), '1.0.0', true );
}
add_action( 'admin_enqueue_scripts', 'alam_al_anika_admin_scripts' );
