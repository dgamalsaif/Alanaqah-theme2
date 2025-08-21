 <?php
/**
 * The sidebar containing the main widget area.
 *
 * This sidebar is intended for WooCommerce pages.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package AlamAlAnika
 */

// We only want to display the sidebar if it has active widgets.
if ( ! is_active_sidebar( 'shop-sidebar' ) ) {
	return;
}
?>

<aside id="secondary" class="widget-area filter-sidebar" role="complementary">
	<?php
    // This function displays the widgets that you add in Appearance > Widgets.
    dynamic_sidebar( 'shop-sidebar' );
    ?>
</aside><!-- #secondary -->
