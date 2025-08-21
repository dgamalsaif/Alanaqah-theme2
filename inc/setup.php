<?php
/**
 * Theme setup and core functionality.
 *
 * @package AlamAlAnika
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'alam_al_anika_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function alam_al_anika_setup() {
		load_theme_textdomain( 'alam-al-anika', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
        add_theme_support( 'custom-logo', array(
            'height'      => 50,
            'width'       => 150,
            'flex-height' => true,
            'flex-width'  => true,
        ) );
		add_theme_support( 'woocommerce' );
		add_theme_support( 'wc-product-gallery-zoom' );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-slider' );
		register_nav_menus(
			array(
				'primary'  => esc_html__( 'Primary Menu (Main Nav)', 'alam-al-anika' ),
				'footer-1' => esc_html__( 'Footer Column 1', 'alam-al-anika' ),
				'footer-2' => esc_html__( 'Footer Column 2', 'alam-al-anika' ),
				'footer-3' => esc_html__( 'Footer Column 3', 'alam-al-anika' ),
				'footer-4' => esc_html__( 'Footer Column 4 (Social)', 'alam-al-anika' ),
			)
		);
		add_theme_support(
			'html5',
			array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption', 'style', 'script' )
		);
	}
endif;
add_action( 'after_setup_theme', 'alam_al_anika_setup' );

/**
 * Enqueue scripts and styles.
 */
function alam_al_anika_scripts() {
    // Main theme stylesheet.
    wp_enqueue_style( 'alam-al-anika-main-style', get_template_directory_uri() . '/assets/css/main.css', array(), ALAM_AL_ANIKA_VERSION );

    // Responsive stylesheet. It depends on the main style to load after it.
    wp_enqueue_style( 'alam-al-anika-responsive', get_template_directory_uri() . '/assets/css/responsive.css', array('alam-al-anika-main-style'), ALAM_AL_ANIKA_VERSION );

    // This line is for the theme's root style.css, which mainly contains theme information.
    // It's good practice to enqueue it, though it has no styles in this theme.
    wp_enqueue_style( 'alam-al-anika-style', get_stylesheet_uri(), array('alam-al-anika-main-style'), ALAM_AL_ANIKA_VERSION );

    // This line loads your local Font Awesome library.
    wp_enqueue_style( 'font-awesome', get_template_directory_uri() . '/assets/fonts/font-awesome/css/all.min.css', array(), '6.4.0' );

    // --- JS Files ---
    wp_deregister_script( 'jquery' );
    wp_register_script( 'jquery', get_template_directory_uri() . '/assets/js/vendor/jquery-3.7.1.js', array(), '3.7.1', true );
    wp_enqueue_script( 'jquery' );

    // Note: The individual JS files like slider, product, filters seem to be combined into main.js in the HTML version.
    // For simplicity and correctness, we will load main.js which contains all needed functionality.
    wp_enqueue_script( 'alam-al-anika-main', get_template_directory_uri() . '/assets/js/main.js', array( 'jquery' ), ALAM_AL_ANIKA_VERSION, true );

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
        wp_enqueue_script( 'comment-reply' );
    }
}
add_action( 'wp_enqueue_scripts', 'alam_al_anika_scripts' );
/**
 * Register widget areas.
 */
function alam_al_anika_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Shop Sidebar', 'alam-al-anika' ),
			'id'            => 'shop-sidebar',
			'description'   => esc_html__( 'Add WooCommerce filter widgets here.', 'alam-al-anika' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s filter-section">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title filter-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action( 'widgets_init', 'alam_al_anika_widgets_init' );

/**
 * Register Custom Post Type for Hero Slides.
 */
function alam_al_anika_register_slides_cpt() {
	$labels = array(
		'name'                  => _x( 'Slides', 'Post Type General Name', 'alam-al-anika' ),
		'singular_name'         => _x( 'Slide', 'Post Type Singular Name', 'alam-al-anika' ),
		'menu_name'             => __( 'Hero Slides', 'alam-al-anika' ),
		'name_admin_bar'        => __( 'Slide', 'alam-al-anika' ),
		'all_items'             => __( 'All Slides', 'alam-al-anika' ),
		'add_new_item'          => __( 'Add New Slide', 'alam-al-anika' ),
		'add_new'               => __( 'Add New', 'alam-al-anika' ),
		'new_item'              => __( 'New Slide', 'alam-al-anika' ),
		'edit_item'             => __( 'Edit Slide', 'alam-al-anika' ),
	);
	$args   = array(
		'label'                 => __( 'Slide', 'alam-al-anika' ),
		'description'           => __( 'Slides for the homepage hero section.', 'alam-al-anika' ),
		'labels'                => $labels,
		'supports'              => array( 'title', 'editor', 'thumbnail' ),
		'hierarchical'          => false,
		'public'                => true,
		'show_ui'               => true,
		'show_in_menu'          => true,
		'menu_position'         => 5,
		'menu_icon'             => 'dashicons-images-alt2',
		'show_in_admin_bar'     => true,
		'show_in_nav_menus'     => false,
		'can_export'            => true,
		'has_archive'           => false,
		'exclude_from_search'   => true,
		'publicly_queryable'    => false,
		'capability_type'       => 'page',
	);
	register_post_type( 'slide', $args );
}
add_action( 'init', 'alam_al_anika_register_slides_cpt', 0 );
