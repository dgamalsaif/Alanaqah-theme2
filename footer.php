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

	</div><footer id="colophon" class="site-footer">
		<?php
		// Load the footer widgets part.
		get_template_part( 'template-parts/footer/widgets' );

		// Load the footer copyright part.
		get_template_part( 'template-parts/footer/copyright' );
		?>
	</footer><button id="back-to-top" class="back-to-top" aria-label="<?php esc_attr_e( 'Back to top', 'alam-al-anika' ); ?>">
		<i class="fas fa-arrow-up"></i>
	</button>
	<div id="notification" class="notification"></div>
	<div id="size-guide-modal" class="size-guide-modal">
		</div>

</div><?php wp_footer(); ?>

<div id="quick-view-modal-wrapper" class="modal-wrapper" style="display:none;">
	<div class="modal-overlay"></div>
	<div class="modal-content">
		<button class="modal-close" aria-label="<?php esc_attr_e( 'Close quick view', 'alam-al-anika' ); ?>">X</button>
		<div id="quick-view-content">
			</div>
	</div>
</div>

</body>
</html>