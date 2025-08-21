 <?php
/**
 * AJAX handlers for the Alam Al Anika Theme.
 *
 * This file is intended to handle AJAX requests for features like
 * live search, quick view, etc.
 *
 * @package AlamAlAnika
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// To prevent "Cannot redeclare function" errors, any new function you add here
// should be wrapped in a check like this:
// if ( ! function_exists( 'your_new_ajax_function_name' ) ) {
//     function your_new_ajax_function_name() {
//         // Your AJAX code here
//     }
// }

// Example: AJAX handler for a hypothetical "Quick View" feature.
/*
add_action( 'wp_ajax_alam_al_anika_quick_view', 'alam_al_anika_quick_view_handler' );
add_action( 'wp_ajax_nopriv_alam_al_anika_quick_view', 'alam_al_anika_quick_view_handler' );

if ( ! function_exists( 'alam_al_anika_quick_view_handler' ) ) {
    function alam_al_anika_quick_view_handler() {
        // Security check
        check_ajax_referer( 'quick_view_nonce', 'nonce' );

        // Get product ID from the AJAX request
        $product_id = isset( $_POST['product_id'] ) ? intval( $_POST['product_id'] ) : 0;

        if ( $product_id > 0 ) {
            // Setup product data and send back the HTML for a modal
            // ...
        }

        wp_die(); // This is required to terminate immediately and return a proper response
    }
}
*/
