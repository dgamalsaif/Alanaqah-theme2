<?php
/**
 * Theme widgets.
 *
 * @package AlamAlAnika
 */

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function alam_al_anika_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Sidebar', 'alam-al-anika' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here.', 'alam-al-anika' ),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);

	// Footer widget areas.
	for ( $i = 1; $i <= 4; $i++ ) {
		register_sidebar(
			array(
				/* translators: %d: The number of the footer widget area. */
				'name'          => sprintf( esc_html__( 'Footer %d', 'alam-al-anika' ), $i ),
				'id'            => 'footer-' . $i,
				'description'   => esc_html__( 'Add widgets here to appear in your footer.', 'alam-al-anika' ),
				'before_widget' => '<div id="%1$s" class="footer-column widget %2$s">',
				'after_widget'  => '</div>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			)
		);
	}

	// Shop sidebar for WooCommerce.
	if ( class_exists( 'WooCommerce' ) ) {
		register_sidebar(
			array(
				'name'          => esc_html__( 'Shop Sidebar', 'alam-al-anika' ),
				'id'            => 'shop-sidebar',
				'description'   => esc_html__( 'Widgets added here will appear on WooCommerce archive pages.', 'alam-al-anika' ),
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h2 class="widget-title">',
				'after_title'   => '</h2>',
			)
		);
	}
}
add_action( 'widgets_init', 'alam_al_anika_widgets_init' );