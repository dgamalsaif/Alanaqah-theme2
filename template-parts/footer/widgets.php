<?php
/**
 * The template part for displaying the footer widgets area.
 *
 * @package AlamAlAnika
 */
?>
<div class="footer-content">
    <div class="footer-column">
        <h3><?php esc_html_e( 'خدمة العملاء', 'alam-al-anika' ); ?></h3>
        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'footer-1',
                'menu_id'        => 'footer-menu-1',
                'container'      => 'ul',
                'fallback_cb'    => false,
            )
        );
        ?>
    </div>
    <div class="footer-column">
        <h3><?php esc_html_e( 'من نحن', 'alam-al-anika' ); ?></h3>
        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'footer-2',
                'menu_id'        => 'footer-menu-2',
                'container'      => 'ul',
                'fallback_cb'    => false,
            )
        );
        ?>
    </div>
    <div class="footer-column">
        <h3><?php esc_html_e( 'مساعدة', 'alam-al-anika' ); ?></h3>
        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'footer-3',
                'menu_id'        => 'footer-menu-3',
                'container'      => 'ul',
                'fallback_cb'    => false,
            )
        );
        ?>
    </div>
    <div class="footer-column">
        <h3><?php esc_html_e( 'تواصل معنا', 'alam-al-anika' ); ?></h3>
        <?php
        wp_nav_menu(
            array(
                'theme_location' => 'footer-4',
                'menu_id'        => 'footer-menu-4',
                'container'      => 'ul',
                'fallback_cb'    => false,
            )
        );
        ?>
    </div>
</div><!-- .footer-content -->
