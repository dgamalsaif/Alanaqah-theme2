<?php
/**
 * The template part for displaying the product info on the single product page.
 *
 * @package AlamAlAnika
 */
?>
<div class="product-info-section">
    <?php
    /**
     * Hook: woocommerce_single_product_summary.
     *
     * @hooked woocommerce_template_single_title - 5
     * @hooked woocommerce_template_single_rating - 10
     * @hooked woocommerce_template_single_price - 10
     * @hooked woocommerce_template_single_excerpt - 20
     * @hooked woocommerce_template_single_add_to_cart - 30
     * @hooked woocommerce_template_single_meta - 40
     * @hooked woocommerce_template_single_sharing - 50
     */
    do_action( 'woocommerce_single_product_summary' );
    ?>
</div>
