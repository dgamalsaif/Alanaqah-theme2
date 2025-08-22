<?php
/**
 * The template for displaying the homepage.
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages
 * and that other 'pages' on your WordPress site may use a
 * different template.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AlamAlAnika
 */

get_header();
?>

<main id="primary" class="site-main">

	<?php
	// Hero Section.
	get_template_part( 'template-parts/homepage/hero-section' );

	// Category Navigation Section.
	get_template_part( 'template-parts/homepage/category-nav' );

	// Flash Sale Section.
	get_template_part( 'template-parts/homepage/flash-sale' );

	// Super Deals Section.
	get_template_part( 'template-parts/homepage/super-deals' );

	// Picks For You Section.
	get_template_part( 'template-parts/homepage/picks-for-you' );

	?>

</main>
<?php
get_footer();