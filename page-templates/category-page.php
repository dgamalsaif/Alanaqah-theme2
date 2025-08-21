<?php
/**
 * Template Name: Custom Category Page
 *
 * This template can be used to display products from a specific category
 * in a unique layout.
 *
 * @package AlamAlAnika
 */

get_header();
?>
    <div id="primary" class="content-area container" style="padding: 40px 20px;">
        <main id="main" class="site-main">
            <!-- You can add a custom WP_Query here to display specific products -->
            <h1 class="entry-title"><?php the_title(); ?></h1>
            <div class="entry-content">
                <?php the_content(); ?>
            </div>
        </main>
    </div>
<?php
get_footer();