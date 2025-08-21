<?php
/**
 * The template for displaying the category navigation icons on the homepage.
 *
 * @package AlamAlAnika
 */

// First, check if WooCommerce is active before trying to use its functions.
if ( ! class_exists( 'WooCommerce' ) ) {
    return; // Stop executing this file if WooCommerce is not active.
}

/**
 * Helper function to safely get a category link.
 * If the category doesn't exist, it returns the main shop page URL.
 */
if ( ! function_exists( 'alam_al_anika_get_safe_category_link' ) ) {
    function alam_al_anika_get_safe_category_link( $slug ) {
        $url = get_term_link( $slug, 'product_cat' );
        if ( is_wp_error( $url ) ) {
            return get_permalink( wc_get_page_id( 'shop' ) );
        }
        return $url;
    }
}
?>
<div class="category-nav">
    <a href="<?php echo esc_url( alam_al_anika_get_safe_category_link('women') ); ?>" class="category-item">
        <div class="category-icon hot">
            <i class="fas fa-female"></i>
        </div>
        <div class="category-name"><?php esc_html_e( 'نسائي', 'alam-al-anika' ); ?></div>
    </a>
    <a href="<?php echo esc_url( alam_al_anika_get_safe_category_link('men') ); ?>" class="category-item">
        <div class="category-icon">
            <i class="fas fa-male"></i>
        </div>
        <div class="category-name"><?php esc_html_e( 'رجالي', 'alam-al-anika' ); ?></div>
    </a>
    <a href="<?php echo esc_url( alam_al_anika_get_safe_category_link('kids') ); ?>" class="category-item">
        <div class="category-icon">
            <i class="fas fa-child"></i>
        </div>
        <div class="category-name"><?php esc_html_e( 'أطفال', 'alam-al-anika' ); ?></div>
    </a>
    <a href="<?php echo esc_url( alam_al_anika_get_safe_category_link('dresses') ); ?>" class="category-item">
        <div class="category-icon hot">
            <i class="fas fa-tshirt"></i>
        </div>
        <div class="category-name"><?php esc_html_e( 'فساتين', 'alam-al-anika' ); ?></div>
    </a>
    <a href="<?php echo esc_url( alam_al_anika_get_safe_category_link('jewelry') ); ?>" class="category-item">
        <div class="category-icon">
            <i class="fas fa-gem"></i>
        </div>
        <div class="category-name"><?php esc_html_e( 'مجوهرات', 'alam-al-anika' ); ?></div>
    </a>
    <a href="<?php echo esc_url( alam_al_anika_get_safe_category_link('bags') ); ?>" class="category-item">
        <div class="category-icon">
            <i class="fas fa-shopping-bag"></i>
        </div>
        <div class="category-name"><?php esc_html_e( 'حقائب', 'alam-al-anika' ); ?></div>
    </a>
</div>
