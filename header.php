 <?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package AlamAlAnika
 */
?>
<!doctype html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>
<div id="page" class="site">
	<a class="skip-link screen-reader-text" href="#primary"><?php esc_html_e( 'Skip to content', 'alam-al-anika' ); ?></a>

	<header id="masthead" class="site-header">
        <div class="header-top">
            <div class="logo">
                <?php
                if ( has_custom_logo() ) {
                    the_custom_logo();
                } else {
                    echo '<h1><a href="' . esc_url( home_url( '/' ) ) . '" rel="home">' . get_bloginfo( 'name' ) . '</a></h1>';
                }
                ?>
            </div>
            <div class="search-container">
                <?php get_search_form(); ?>
            </div>
            <div class="user-actions">
                <?php if ( class_exists( 'WooCommerce' ) ) : ?>
                    <a href="<?php echo esc_url( get_permalink( get_option('woocommerce_myaccount_page_id') ) ); ?>" title="<?php esc_attr_e( 'My Account', 'alam-al-anika' ); ?>">
                        <i class="far fa-user"></i>
                        <span><?php esc_html_e( 'حسابي', 'alam-al-anika' ); ?></span>
                    </a>
                    <!-- Note: Wishlist functionality requires a plugin like YITH WooCommerce Wishlist -->
                    <a href="#" class="wishlist-link" title="<?php esc_attr_e( 'Wishlist', 'alam-al-anika' ); ?>">
                        <i class="far fa-heart"></i>
                        <span><?php esc_html_e( 'المفضلة', 'alam-al-anika' ); ?></span>
                    </a>
                    <a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart-contents" title="<?php esc_attr_e( 'View your shopping cart', 'alam-al-anika' ); ?>">
                        <i class="fas fa-shopping-bag"></i>
                        <span><?php esc_html_e( 'السلة', 'alam-al-anika' ); ?></span>
                        <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>
        <nav id="site-navigation" class="nav-menu">
            <?php
            wp_nav_menu(
                array(
                    'theme_location' => 'primary',
                    'menu_id'        => 'primary-menu',
                    'container'      => false,
                )
            );
            ?>
        </nav><!-- #site-navigation -->
	</header><!-- #masthead -->

	<div id="content" class="site-content">
