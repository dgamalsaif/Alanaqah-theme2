<?php
/**
 * The template for displaying the hero section on the homepage.
 * This version dynamically pulls content from the 'slide' Custom Post Type.
 *
 * @package AlamAlAnika
 */

// First, check if WooCommerce is active before trying to use its functions.
if ( ! class_exists( 'WooCommerce' ) ) {
    echo '<p>WooCommerce plugin is not active. Please activate it to see this section.</p>';
    return; // Stop executing this file if WooCommerce is not active.
}

$args = array(
    'post_type'      => 'slide',
    'posts_per_page' => 5, // Show up to 5 slides
    'orderby'        => 'date',
    'order'          => 'DESC',
);

$slides_query = new WP_Query( $args );

if ( $slides_query->have_posts() ) :
?>
<section class="hero">
    <div class="hero-slides-container">
        <?php
        $slide_index = 0;
        while ( $slides_query->have_posts() ) :
            $slides_query->the_post();
            $active_class = ( $slide_index === 0 ) ? 'active' : '';
        ?>
            <div class="hero-slide <?php echo esc_attr( $active_class ); ?>">
                <?php if ( has_post_thumbnail() ) : ?>
                    <img src="<?php the_post_thumbnail_url( 'full' ); ?>" alt="<?php the_title_attribute(); ?>" class="hero-image">
                <?php endif; ?>

                <div class="hero-content">
                    <h1><?php the_title(); ?></h1>
                    <?php
                    // The content editor is used for the subtitle
                    if ( get_the_content() ) {
                        echo '<p>' . get_the_content() . '</p>';
                    }
                    ?>
                    <!-- For now, the button is static. We can add custom fields for it later. -->
                    <a href="<?php echo esc_url( get_permalink( wc_get_page_id( 'shop' ) ) ); ?>" class="hero-btn"><?php esc_html_e( 'تسوق الآن', 'alam-al-anika' ); ?></a>
                </div>
            </div>
        <?php
            $slide_index++;
        endwhile;
        ?>
    </div>

    <?php if ( $slides_query->post_count > 1 ) : ?>
    <div class="hero-dots">
        <?php for ( $i = 0; $i < $slides_query->post_count; $i++ ) : ?>
            <div class="hero-dot <?php echo ( $i === 0 ) ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>"></div>
        <?php endfor; ?>
    </div>
    <?php endif; ?>
</section>
<?php
endif;
wp_reset_postdata();
?>