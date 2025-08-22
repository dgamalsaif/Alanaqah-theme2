<?php
/**
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AlamAlAnika
 */

get_header();
?>

	<div id="primary" class="content-area container" style="padding: 40px 20px;">
		<main id="main" class="site-main">

			<?php
			while ( have_posts() ) :
				the_post();

				// This will look for a file named 'content-page.php' in the '/template-parts/' folder.
				get_template_part( 'template-parts/content-page' );

				// If comments are open or there is at least one comment, load the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main></div><?php
		get_footer();
		?>