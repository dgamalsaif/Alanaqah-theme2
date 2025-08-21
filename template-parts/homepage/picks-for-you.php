<?php
/**
 * The template for displaying the "Picks For You" section on the homepage.
 *
 * This section displays the most recent products.
 *
 * @package AlamAlAnika
 */

$recent_products_args = array(
    'post_type'      => 'product',
    'posts_per_page' => 4, // You can change the number of products to show
    'orderby'        => 'date',
    'order'          => 'DESC',
);

$recent_products_query = new WP_Query( $recent_products_args );

if ( $recent_products_query->have_posts() ) :
?>
<section class="section">
    <div class="section-header">
        <h2 class="section-title"><?php esc_html_e( 'مختارات لك', 'alam-al-anika' ); ?></h2>
        <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="view-all">
            <?php esc_html_e( 'عرض الكل', 'alam-al-anika' ); ?> <i class="fas fa-chevron-left"></i>
        </a>
    </div>

    <div class="product-grid">
        <?php
        echo '<ul class="products columns-4">';
        while ( $recent_products_query->have_posts() ) :
            $recent_products_query->the_post();
            wc_get_template_part( 'content', 'product' );
        endwhile;
        echo '</ul>';
        ?>
    </div>
</section>
<?php
endif;
wp_reset_postdata();