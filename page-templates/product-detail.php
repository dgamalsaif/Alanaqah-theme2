<?php
/**
 * Template Name: Custom Product Detail Page
 *
 * This template can be used to create a unique layout for a specific product.
 *
 * @package AlamAlAnika
 */

get_header();
?>
	<div id="primary" class="content-area container" style="padding: 40px 20px;">
		<main id="main" class="site-main">
			<!-- You could query for a specific product ID and display it here -->
			<h1 class="entry-title"><?php the_title(); ?></h1>
			<div class="entry-content">
				<?php the_content(); ?>
			</div>
		</main>
	</div>
<?php
get_footer();
