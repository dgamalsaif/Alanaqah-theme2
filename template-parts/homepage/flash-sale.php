<?php
/**
 * The template for displaying the flash sale section on the homepage.
 *
 * @package AlamAlAnika
 */

// Get IDs of products on sale
$product_ids_on_sale = wc_get_product_ids_on_sale();

if ( ! empty( $product_ids_on_sale ) ) :
?>
<section class="flash-sale section">
    <div class="flash-header">
        <div class="flash-title">
            <div class="flash-icon">
                <i class="fas fa-bolt"></i>
            </div>
            <h2><?php esc_html_e( 'عروض سريعة', 'alam-al-anika' ); ?></h2>
        </div>
        <div class="flash-timer">
            <i class="far fa-clock"></i>
            <span id="flash-timer"><?php esc_html_e( 'ينتهي خلال 05:53:48', 'alam-al-anika' ); ?></span>
        </div>
    </div>

    <div class="product-grid">
        <?php
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => 4, // Show 4 products in this section
            'post__in'       => $product_ids_on_sale,
        );
        $flash_sale_query = new WP_Query( $args );

        if ( $flash_sale_query->have_posts() ) :
            // We need to use the WooCommerce loop structure here
            echo '<ul class="products columns-4">';
            while ( $flash_sale_query->have_posts() ) :
                $flash_sale_query->the_post();
                wc_get_template_part( 'content', 'product' );
            endwhile;
            echo '</ul>';
        else :
            echo '<p>' . esc_html__( 'No products are currently on sale.', 'alam-al-anika' ) . '</p>';
        endif;
        wp_reset_postdata();
        ?>
    </div>
</section>
<?php
endif;