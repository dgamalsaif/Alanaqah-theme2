<?php
/**
 * The template for displaying the footer widgets.
 *
 * @package AlamAlAnika
 */

?>

<div class="footer-content">
	<?php if ( is_active_sidebar( 'footer-1' ) ) : ?>
		<div class="footer-column">
			<?php dynamic_sidebar( 'footer-1' ); ?>
		</div>
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'footer-2' ) ) : ?>
		<div class="footer-column">
			<?php dynamic_sidebar( 'footer-2' ); ?>
		</div>
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'footer-3' ) ) : ?>
		<div class="footer-column">
			<?php dynamic_sidebar( 'footer-3' ); ?>
		</div>
	<?php endif; ?>

	<?php if ( is_active_sidebar( 'footer-4' ) ) : ?>
		<div class="footer-column">
			<?php dynamic_sidebar( 'footer-4' ); ?>
		</div>
	<?php endif; ?>
</div>