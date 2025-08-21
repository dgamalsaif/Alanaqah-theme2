<?php
/**
 * Template Name: Full Width Page
 *
 * This is the template that displays full-width pages without a sidebar.
 *
 * @package AlamAlAnika
 */

get_header();
?>

	<div id="primary" class="content-area full-width-content container" style="padding: 40px 20px; max-width: 100%;">
		<main id="main" class="site-main">

			<?php
			while ( have_posts() ) :
				the_post();

				// We can reuse the standard content-page template part
				get_template_part( 'template-parts/content/content', 'page' );

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

			endwhile; // End of the loop.
			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();