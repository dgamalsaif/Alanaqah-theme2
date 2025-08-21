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
    
    // Hero Slider Section
    get_template_part( 'template-parts/homepage/hero-section' );

    // Category Navigation Section
    get_template_part( 'template-parts/homepage/category-nav' );

    // Flash Sale Products Section
    if ( class_exists( 'WooCommerce' ) ) {
        get_template_part( 'template-parts/homepage/flash-sale' );
    }

    // Super Deals Products Section
    if ( class_exists( 'WooCommerce' ) ) {
        get_template_part( 'template-parts/homepage/super-deals' );
    }
    
    // Picks For You Section
    if ( class_exists( 'WooCommerce' ) ) {
        get_template_part( 'template-parts/homepage/picks-for-you' );
    }

    ?>

</main><!-- #main -->

<?php
get_footer();