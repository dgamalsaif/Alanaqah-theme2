<?php
/**
 * Custom product functions for the theme.
 *
 * @package AlamAlAnika
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Get featured products.
 *
 * @param int $limit Number of products to show.
 * @return string HTML output of products.
 */
function alam_al_anika_get_featured_products( $limit = 4 ) {
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => absint( $limit ),
		'tax_query'      => array( // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_tax_query
			array(
				'taxonomy' => 'product_visibility',
				'field'    => 'name',
				'terms'    => 'featured',
				'operator' => 'IN',
			),
		),
	);

	$query  = new WP_Query( $args );
	$output = '';

	if ( $query->have_posts() ) {
		ob_start();
		while ( $query->have_posts() ) {
			$query->the_post();
			global $product;
			?>
			<li class="product">
				<a href="<?php echo esc_url( get_the_permalink() ); ?>">
					<?php echo wp_kses_post( $product->get_image() ); ?>
					<h2 class="woocommerce-loop-product__title"><?php echo esc_html( get_the_title() ); ?></h2>
					<span class="price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
				</a>
				<?php woocommerce_template_loop_add_to_cart(); ?>
			</li>
			<?php
		}
		$output = ob_get_clean();
	}

	wp_reset_postdata();
	return $output;
}

/**
 * Get new arrival products.
 *
 * @param int $limit Number of products to show.
 * @return string HTML output of products.
 */
function alam_al_anika_get_new_arrivals( $limit = 8 ) {
	$args = array(
		'post_type'      => 'product',
		'posts_per_page' => absint( $limit ),
		'orderby'        => 'date',
		'order'          => 'DESC',
	);

	$query  = new WP_Query( $args );
	$output = '';

	if ( $query->have_posts() ) {
		ob_start();
		while ( $query->have_posts() ) {
			$query->the_post();
			global $product;
			?>
			<li class="product">
				<a href="<?php echo esc_url( get_the_permalink() ); ?>">
					<?php echo wp_kses_post( $product->get_image() ); ?>
					<h2 class="woocommerce-loop-product__title"><?php echo esc_html( get_the_title() ); ?></h2>
					<span class="price"><?php echo wp_kses_post( $product->get_price_html() ); ?></span>
				</a>
				<?php woocommerce_template_loop_add_to_cart(); ?>
			</li>
			<?php
		}
		$output = ob_get_clean();
	}

	wp_reset_postdata();
	return $output;
}