 <?php
/**
 * The template for displaying single product content.
 * This file now loads modular template parts.
 *
 * @package AlamAlAnika/WooCommerce
 */

defined( 'ABSPATH' ) || exit;

global $product;

do_action( 'woocommerce_before_single_product' );

if ( post_password_required() ) {
	echo get_the_password_form();
	return;
}
?>
<div id="product-<?php the_ID(); ?>" <?php wc_product_class( 'product-detail-page active', $product ); ?>>

    <div class="product-breadcrumb">
        <?php woocommerce_breadcrumb(); ?>
    </div>

	<div class="product-detail-container">
        <?php
        // Load the product images part
        get_template_part('template-parts/single/product-images');

        // Load the product info part
        get_template_part('template-parts/single/product-info');
        ?>
	</div>

    <?php
    // Load the related products and tabs part
    get_template_part('template-parts/single/related-products');
    ?>
</div>

<?php do_action( 'woocommerce_after_single_product' ); ?>
