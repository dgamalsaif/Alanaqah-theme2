 <?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package AlamAlAnika
 */

get_header();
?>

	<div id="primary" class="content-area container" style="padding: 40px 20px;">
		<main id="main" class="site-main">

		<?php if ( have_posts() ) : ?>

			<header class="page-header" style="margin-bottom: 30px; border-bottom: 1px solid var(--border-color); padding-bottom: 20px;">
				<?php
				the_archive_title( '<h1 class="page-title">', '</h1>' );
				the_archive_description( '<div class="archive-description">', '</div>' );
				?>
			</header><!-- .page-header -->

			<?php
			/* Start the Loop */
			while ( have_posts() ) :
				the_post();

				get_template_part( 'template-parts/content/content', get_post_type() );

			endwhile;

			the_posts_navigation();

		else :

			get_template_part( 'template-parts/content/content', 'none' );

		endif;
		?>

		</main><!-- #main -->
		<?php get_sidebar(); ?>
	</div><!-- #primary -->

<?php
get_footer();
