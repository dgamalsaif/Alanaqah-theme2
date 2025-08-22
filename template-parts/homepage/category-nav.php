<?php
/**
 * Template part for displaying the category navigation on the homepage.
 *
 * @package AlamAlAnika
 */

// Placeholder data for categories.
// In a real theme, this would come from `get_terms` for 'product_cat'.
$categories = array(
	array(
		'name' => __( 'Women', 'alam-al-anika' ),
		'icon' => 'fas fa-female',
		'url'  => '#',
	),
	array(
		'name' => __( 'Men', 'alam-al-anika' ),
		'icon' => 'fas fa-male',
		'url'  => '#',
	),
	array(
		'name' => __( 'Kids', 'alam-al-anika' ),
		'icon' => 'fas fa-child',
		'url'  => '#',
	),
	array(
		'name' => __( 'Shoes', 'alam-al-anika' ),
		'icon' => 'fas fa-shoe-prints',
		'url'  => '#',
	),
	array(
		'name' => __( 'Bags', 'alam-al-anika' ),
		'icon' => 'fas fa-shopping-bag',
		'url'  => '#',
	),
	array(
		'name' => __( 'Accessories', 'alam-al-anika' ),
		'icon' => 'fas fa-gem',
		'url'  => '#',
	),
);
?>

<section class="category-nav">
	<?php foreach ( $categories as $category ) : ?>
		<a href="<?php echo esc_url( $category['url'] ); ?>" class="category-item">
			<div class="category-icon">
				<i class="<?php echo esc_attr( $category['icon'] ); ?>"></i>
			</div>
			<span class="category-name"><?php echo esc_html( $category['name'] ); ?></span>
		</a>
	<?php endforeach; ?>
</section>