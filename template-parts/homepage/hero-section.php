<?php
/**
 * Template part for displaying the hero section on the homepage.
 *
 * @package AlamAlAnika
 */

// Placeholder data for the hero slider.
// In a real theme, this would come from theme options or a custom post type.
$slides = array(
	array(
		'image_url'   => get_template_directory_uri() . '/assets/images/hero-1.jpg',
		'title'       => __( 'New Collection is Here', 'alam-al-anika' ),
		'description' => __( 'Discover the latest trends and styles for this season.', 'alam-al-anika' ),
		'button_text' => __( 'Shop Now', 'alam-al-anika' ),
		'button_url'  => '#',
	),
	array(
		'image_url'   => get_template_directory_uri() . '/assets/images/hero-2.jpg',
		'title'       => __( 'Up to 50% Off', 'alam-al-anika' ),
		'description' => __( 'Limited time offer on selected items. Don\'t miss out!', 'alam-al-anika' ),
		'button_text' => __( 'View Deals', 'alam-al-anika' ),
		'button_url'  => '#',
	),
);
?>

<section class="hero">
	<?php foreach ( $slides as $index => $slide ) : ?>
		<div class="hero-slide<?php echo ( 0 === $index ) ? ' active' : ''; ?>" data-slide="<?php echo esc_attr( $index ); ?>">
			<img src="<?php echo esc_url( $slide['image_url'] ); ?>" alt="<?php echo esc_attr( $slide['title'] ); ?>" class="hero-image">
			<div class="hero-content">
				<h1><?php echo esc_html( $slide['title'] ); ?></h1>
				<p><?php echo esc_html( $slide['description'] ); ?></p>
				<a href="<?php echo esc_url( $slide['button_url'] ); ?>" class="hero-btn"><?php echo esc_html( $slide['button_text'] ); ?></a>
			</div>
		</div>
	<?php endforeach; ?>

	<div class="hero-dots">
		<?php foreach ( $slides as $index => $slide ) : ?>
			<span class="hero-dot<?php echo ( 0 === $index ) ? ' active' : ''; ?>" data-slide-to="<?php echo esc_attr( $index ); ?>"></span>
		<?php endforeach; ?>
	</div>
</section>