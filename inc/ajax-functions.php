<?php
/**
 * AJAX functions for the theme.
 *
 * @package AlamAlAnika
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * AJAX handler for live search.
 */
function alam_al_anika_live_search() {
	// 1. Verify nonce for security.
	check_ajax_referer( 'search-nonce', 'security' );

	// 2. Sanitize user input.
	$search_query = isset( $_POST['query'] ) ? sanitize_text_field( wp_unslash( $_POST['query'] ) ) : '';

	if ( empty( $search_query ) ) {
		wp_die();
	}

	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => 5,
		's'              => $search_query,
	);

	$query = new WP_Query( $args );

	if ( $query->have_posts() ) {
		echo '<ul class="live-search-list">';
		while ( $query->have_posts() ) {
			$query->the_post();
			global $product;
			?>
			<li class="live-search-item">
				<a href="<?php echo esc_url( get_the_permalink() ); ?>">
					<?php echo wp_kses_post( $product->get_image( 'thumbnail' ) ); ?>
					<div class="item-details">
						<span class="item-title"><?php echo esc_html( get_the_title() ); ?></span>
						<span class="item-price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
					</div>
				</a>
			</li>
			<?php
		}
		echo '</ul>';
	} else {
		echo '<div class="no-results">' . esc_html__( 'No products found', 'alam-al-anika' ) . '</div>';
	}

	wp_reset_postdata();
	wp_die();
}
add_action( 'wp_ajax_alam_al_anika_live_search', 'alam_al_anika_live_search' );
add_action( 'wp_ajax_nopriv_alam_al_anika_live_search', 'alam_al_anika_live_search' );


/**
 * AJAX handler for adding products to the cart.
 */
function alam_al_anika_add_to_cart() {
	// 1. Verify nonce for security.
	check_ajax_referer( 'add-to-cart-nonce', 'security' );

	// 2. Sanitize all inputs.
	$product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;
	$quantity   = isset( $_POST['quantity'] ) ? absint( $_POST['quantity'] ) : 1;

	if ( ! $product_id ) {
		wp_send_json_error( array( 'message' => esc_html__( 'Invalid product.', 'alam-al-anika' ) ) );
		return;
	}

	$passed_validation = apply_filters( 'woocommerce_add_to_cart_validation', true, $product_id, $quantity );

	if ( $passed_validation && WC()->cart->add_to_cart( $product_id, $quantity ) ) {
		do_action( 'woocommerce_ajax_added_to_cart', $product_id );
		wp_send_json_success(
			array(
				'message'      => esc_html__( 'Product added to cart successfully.', 'alam-al-anika' ),
				'cart_count'   => WC()->cart->get_cart_contents_count(),
				'cart_subtotal' => WC()->cart->get_cart_subtotal(),
			)
		);
	} else {
		wp_send_json_error( array( 'message' => esc_html__( 'Failed to add product to cart.', 'alam-al-anika' ) ) );
	}

	wp_die();
}
add_action( 'wp_ajax_alam_al_anika_add_to_cart', 'alam_al_anika_add_to_cart' );
add_action( 'wp_ajax_nopriv_alam_al_anika_add_to_cart', 'alam_al_anika_add_to_cart' );


/**
 * AJAX handler for the quick view modal.
 */
function alam_al_anika_quick_view() {
	// 1. Verify nonce for security.
	check_ajax_referer( 'quick-view-nonce', 'security' );

	// 2. Sanitize input.
	$product_id = isset( $_POST['product_id'] ) ? absint( $_POST['product_id'] ) : 0;

	if ( ! $product_id ) {
		wp_send_json_error( array( 'message' => esc_html__( 'Invalid product ID.', 'alam-al-anika' ) ) );
		return;
	}

	// Set the main query to the specific product.
	$query_args = array(
		'p'         => $product_id,
		'post_type' => 'product',
	);

	$query = new WP_Query( $query_args );

	ob_start();

	if ( $query->have_posts() ) {
		while ( $query->have_posts() ) {
			$query->the_post();
			// Use WooCommerce's template for consistency.
			wc_get_template_part( 'content', 'single-product' );
		}
	}

	wp_reset_postdata();

	$content = ob_get_clean();

	wp_send_json_success( array( 'content' => $content ) );

	wp_die();
}
add_action( 'wp_ajax_alam_al_anika_quick_view', 'alam_al_anika_quick_view' );
add_action( 'wp_ajax_nopriv_alam_al_anika_quick_view', 'alam_al_anika_quick_view' );