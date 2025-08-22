 <?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the #content div and all content after.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package AlamAlAnika
 */
?>

	</div><!-- #content -->

	<footer id="colophon" class="site-footer">
		<?php
        // Load the footer widgets part
        get_template_part( 'template-parts/footer/widgets' );

        // Load the footer copyright part
        get_template_part( 'template-parts/footer/copyright' );
        ?>
	</footer><!-- #colophon -->

    <!-- Global elements from the original HTML -->
    <button id="back-to-top" class="back-to-top">
        <i class="fas fa-arrow-up"></i>
    </button>
    <div id="notification" class="notification"></div>
    <div id="size-guide-modal" class="size-guide-modal">
        <!-- The content for this modal can be built out later or loaded via AJAX -->
    </div>

</div><!-- #page -->

<?php wp_footer(); ?>

<div id="quick-view-modal-wrapper" class="modal-wrapper" style="display:none;">
    <div class="modal-overlay"></div>
    <div class="modal-content">
        <button class="modal-close">X</button>
        <div id="quick-view-content">
            </div>
    </div>
</div>

</body>
</html>
