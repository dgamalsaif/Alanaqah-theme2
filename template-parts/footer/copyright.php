<?php
/**
 * The template for displaying the footer copyright.
 *
 * @package AlamAlAnika
 */
?>

<div class="footer-bottom">
	<p>
		<?php
		/* translators: 1: Current year, 2: Site name */
		printf(
			esc_html__( '&copy; %1$s %2$s. All Rights Reserved.', 'alam-al-anika' ),
			esc_html( date_i18n( 'Y' ) ),
			esc_html( get_bloginfo( 'name' ) )
		);
		?>
	</p>
</div>