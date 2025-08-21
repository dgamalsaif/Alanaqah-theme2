<?php
/**
 * Alam Al Anika Theme Loader
 *
 * This file acts as a loader for the theme's core functions, keeping the codebase organized
 * according to the specified theme structure.
 *
 * @package AlamAlAnika
 */

// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Define Theme Version for cache busting.
 */
define( 'ALAM_AL_ANIKA_VERSION', '1.0.0' );

/**
 * Require files from the /inc/ directory.
 */
$alam_al_anika_inc_dir = get_template_directory() . '/inc/';

// Core theme setup, menus, and script enqueueing.
require_once $alam_al_anika_inc_dir . 'setup.php';

// Theme customizer options.
require_once $alam_al_anika_inc_dir . 'customizer.php';

// Custom widgets.
require_once $alam_al_anika_inc_dir . 'widgets.php';

// Custom template tags.
require_once $alam_al_anika_inc_dir . 'template-tags.php';

// WooCommerce specific functions.
if ( class_exists( 'WooCommerce' ) ) {
    require_once $alam_al_anika_inc_dir . 'product-functions.php';
}

// AJAX handlers.
if ( file_exists( $alam_al_anika_inc_dir . 'ajax-functions.php' ) ) {
    require_once $alam_al_anika_inc_dir . 'ajax-functions.php';
}