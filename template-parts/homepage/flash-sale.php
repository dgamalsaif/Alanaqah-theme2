<?php
/**
 * Template part for displaying the flash sale section on the homepage.
 *
 * @package AlamAlAnika
 */

$args = array(
	'post_type'      => 'product',
	'posts_per_page' => 4,
	'meta_key'       => 'total_sales', // phpcs:ignore WordPress.DB.SlowDBQuery.slow_db_query_meta_key
	'orderby'        => 'meta_value_num',
	'order'          => 'DESC',
);

$query = new WP_Query( $args );
?>

<section class="section flash-sale">
	<div class="section-header">
		<h2 class="section-title"><?php esc_html_e( 'Flash Sale', 'alam-al-anika' ); ?></h2>
		<a href="#" class="view-all"><?php esc_html_e( 'View All', 'alam-al-anika' ); ?> <i class="fas fa-chevron-left"></i></a>
	</div>
	<?php if ( $query->have_posts() ) : ?>
		<ul class="products">
			<?php
			while ( $query->have_posts() ) :
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
			<?php endwhile; ?>
		</ul>
	<?php else : ?>
		<p><?php esc_html_e( 'No flash sale products at the moment.', 'alam-al-anika' ); ?></p>
	<?php endif; ?>
	<?php wp_reset_postdata(); ?>
</section>