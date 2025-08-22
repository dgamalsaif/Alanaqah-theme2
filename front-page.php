<?php
/**
 * The template for displaying the homepage.
 *
 * @package AlamAlAnika
 */

get_header();
?>

<main id="primary" class="site-main">

    <?php
    /**
     * We are including template parts from the /template-parts/homepage/ directory.
     * This keeps the front-page.php file clean and easy to manage.
     * Each file will contain the specific markup and logic for its section.
     */
    
    // Hero Slider Section (No animation needed as it's the first thing seen)
    get_template_part( 'template-parts/homepage/hero-section' );
    ?>

    <div class="animate-on-scroll">
        <?php
        // Category Navigation Section
        get_template_part( 'template-parts/homepage/category-nav' );
        ?>
    </div>

    <?php
    // Flash Sale Products Section
    if ( class_exists( 'WooCommerce' ) ) : ?>
        <div class="animate-on-scroll">
            <?php get_template_part( 'template-parts/homepage/flash-sale' ); ?>
        </div>
    <?php endif; ?>

    <?php
    // Super Deals Products Section
    if ( class_exists( 'WooCommerce' ) ) : ?>
        <div class="animate-on-scroll">
            <?php get_template_part( 'template-parts/homepage/super-deals' ); ?>
        </div>
    <?php endif; ?>
    
    <?php
    // Picks For You Section
    if ( class_exists( 'WooCommerce' ) ) : ?>
        <div class="animate-on-scroll">
            <?php get_template_part( 'template-parts/homepage/picks-for-you' ); ?>
        </div>
    <?php endif; ?>

</main><?php
get_footer();