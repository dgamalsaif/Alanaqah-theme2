<?php
/**
 * The template part for displaying the product images on the single product page.
 *
 * @package AlamAlAnika
 */
?>
<div class="product-images-section">
    <?php
    /**
     * Hook: woocommerce_before_single_product_summary.
     *
     * @hooked woocommerce_show_product_sale_flash - 10
     * @hooked woocommerce_show_product_images - 20
     */
    do_action( 'woocommerce_before_single_product_summary' );
    ?>
</div>
