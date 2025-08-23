<?php
/**
 * The sidebar containing the shop widget area.
 *
 * @package AlamAlAnika
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly.
}

// If the shop sidebar has no widgets, do nothing.
if ( ! is_active_sidebar( 'shop-sidebar' ) ) {
    return;
}
?>

<aside id="secondary" class="widget-area">
    <?php dynamic_sidebar( 'shop-sidebar' ); ?>
</aside>```