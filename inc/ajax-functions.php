```php name=inc/ajax-functions.php
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
add_action( 'wp_ajax_alam_al_anika_quick_view', 'alam_al_anika_quick_view_handler' );
add_action( 'wp_ajax_nopriv_alam_al_anika_quick_view', 'alam_al_anika_quick_view_handler' );

function alam_al_anika_quick_view_handler() {
    $product_id = isset( $_POST['product_id'] ) ? intval( $_POST['product_id'] ) : 0;
    if ( $product_id > 0 ) {
        $product = wc_get_product( $product_id );
        if ( $product ) {
            echo '<div class="modal-content">';
            echo '<img src="' . get_the_post_thumbnail_url( $product_id, 'medium' ) . '" style="width:100%;border-radius:8px;margin-bottom:16px;" />';
            echo '<h2>' . $product->get_name() . '</h2>';
            echo wc_price( $product->get_price() );
            echo '<p>' . $product->get_short_description() . '</p>';
            echo '<a href="' . get_permalink( $product_id ) . '" class="button" style="margin-top:12px;">' . __('View Product','alam-al-anika') . '</a>';
            echo '</div>';
        }
    }
    wp_die();
}
<?php
// أضف هذا الكود في نهاية الملف

/**
 * AJAX handler for Quick View.
 */
function alam_al_anika_load_product_quick_view() {
    if ( ! isset( $_POST['product_id'] ) ) {
        wp_die();
    }

    $product_id = intval( $_POST['product_id'] );
    
    // قم بتعيين المنتج العالمي حتى تعمل قوالب woocommerce بشكل صحيح
    wc_setup_product_data( $product_id );

    // استدعاء قالب محتوى المنتج المفرد
    wc_get_template_part( 'content', 'single-product' );

    wp_die();
}
add_action( 'wp_ajax_load_product_quick_view', 'alam_al_anika_load_product_quick_view' );
add_action( 'wp_ajax_nopriv_load_product_quick_view', 'alam_al_anika_load_product_quick_view' );
<?php
// ... الدوال السابقة مثل دالة النظرة السريعة

/**
 * AJAX handler for Live Product Search.
 */
function alam_al_anika_live_product_search() {
    // التأكد من وجود مصطلح البحث
    if ( ! isset( $_POST['query'] ) || empty( $_POST['query'] ) ) {
        wp_die();
    }

    $search_query = sanitize_text_field( $_POST['query'] );

    $args = array(
        'post_type'      => 'product',
        'posts_per_page' => 5, // تحديد عدد النتائج
        's'              => $search_query
    );

    $products_query = new WP_Query( $args );

    if ( $products_query->have_posts() ) {
        echo '<ul class="live-search-list">';
        while ( $products_query->have_posts() ) {
            $products_query->the_post();
            global $product;
            ?>
            <li class="live-search-item">
                <a href="<?php echo esc_url( get_the_permalink() ); ?>">
                    <?php echo $product->get_image('thumbnail'); // عرض الصورة المصغرة ?>
                    <div class="item-details">
                        <span class="item-title"><?php echo get_the_title(); ?></span>
                        <span class="item-price"><?php echo $product->get_price_html(); ?></span>
                    </div>
                </a>
            </li>
            <?php
        }
        echo '</ul>';
        wp_reset_postdata();
    } else {
        echo '<div class="no-results">لا توجد منتجات مطابقة.</div>';
    }

    wp_die();
}
add_action( 'wp_ajax_live_product_search', 'alam_al_anika_live_product_search' );
add_action( 'wp_ajax_nopriv_live_product_search', 'alam_al_anika_live_product_search' );
