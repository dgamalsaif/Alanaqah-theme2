<?php
/**
 * Template part for displaying single product images.
 *
 * @package AlamAlAnika
 */

?>
<div class="product-images">
	<div class="main-image">
		<?php
		if ( has_post_thumbnail() ) {
			the_post_thumbnail( 'large' );
		}
		?>
	</div>
	<div class="product-thumbnails">
		<?php
		// Gallery images would be handled here, typically by a WooCommerce hook or a custom function.
		?>
	</div>
</div>