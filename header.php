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
					if ( is_front_page() && is_home() ) :
						?>
						<h1 class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></h1>
						<?php
					else :
						?>
						<p class="site-title"><a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a></p>
						<?php
					endif;
				}
				?>
			</div>
			
			<div class="search-container">
				<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
					<label>
						<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'alam-al-anika' ); ?></span>
						<input type="search" class="search-field" placeholder="<?php echo esc_attr_x( 'Search products…', 'placeholder', 'alam-al-anika' ); ?>" value="<?php echo get_search_query(); ?>" name="s" />
					</label>
					<button type="submit" class="search-submit">
						<i class="fa fa-search" aria-hidden="true"></i>
						<span class="screen-reader-text"><?php echo esc_html_x( 'Search', 'submit button', 'alam-al-anika' ); ?></span>
					</button>
					<input type="hidden" name="post_type" value="product" />
					<div id="live-search-results"></div>
				</form>
			</div>

			<div class="user-actions">
				<?php if ( class_exists( 'WooCommerce' ) ) : ?>
					<a href="<?php echo esc_url( get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ) ); ?>" title="<?php esc_attr_e( 'My Account', 'alam-al-anika' ); ?>">
						<i class="far fa-user"></i>
						<span><?php esc_html_e( 'My Account', 'alam-al-anika' ); ?></span>
					</a>
					<?php if ( class_exists( 'YITH_WCWL' ) ) : ?>
						<a href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url() ); ?>" class="wishlist-link" title="<?php esc_attr_e( 'Wishlist', 'alam-al-anika' ); ?>">
							<i class="far fa-heart"></i>
							<span><?php esc_html_e( 'Wishlist', 'alam-al-anika' ); ?></span>
						</a>
					<?php endif; ?>
					<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="cart-contents" title="<?php esc_attr_e( 'View your shopping cart', 'alam-al-anika' ); ?>">
						<i class="fas fa-shopping-bag"></i>
						<span><?php esc_html_e( 'Cart', 'alam-al-anika' ); ?></span>
						<span class="cart-count"><?php echo esc_html( WC()->cart->get_cart_contents_count() ); ?></span>
					</a>
				<?php endif; ?>
			</div>
		</div>
		<nav id="site-navigation" class="main-navigation">
			<?php
			wp_nav_menu(
				array(
					'theme_location' => 'primary',
					'menu_id'        => 'primary-menu',
					'container'      => false,
				)
			);
			?>
		</nav></header><div id="content" class="site-content">