 <?php
/**
 * WooCommerce Compatibility Functions for Alam Al Anika Theme.
 *
 * @package AlamAlAnika
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

// Ensure WooCommerce is active before running any of its functions.
if ( ! class_exists( 'WooCommerce' ) ) {
    return;
}

/**
 * Add a wrapper class to all WooCommerce pages for styling purposes.
 */
if ( ! function_exists( 'alam_al_anika_woocommerce_wrapper_start' ) ) {
    function alam_al_anika_woocommerce_wrapper_start() {
        echo '<div class="woocommerce-wrapper container" style="padding: 20px 15px;">';
    }
}
add_action('woocommerce_before_main_content', 'alam_al_anika_woocommerce_wrapper_start', 5);

if ( ! function_exists( 'alam_al_anika_woocommerce_wrapper_end' ) ) {
    function alam_al_anika_woocommerce_wrapper_end() {
        echo '</div>';
    }
}
add_action('woocommerce_after_main_content', 'alam_al_anika_woocommerce_wrapper_end', 20);

/**
 * Remove default WooCommerce wrappers and sidebar.
 */
remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );
remove_action( 'woocommerce_sidebar', 'woocommerce_get_sidebar', 10 );


// =========================================================================
// SWATCHES FUNCTIONALITY - FINAL CORRECTED CODE
// =========================================================================

/**
 * 1. Add color picker field to the "Add New Color Term" screen.
 */
if ( ! function_exists( 'alam_al_anika_add_color_field_to_add_form' ) ) {
    function alam_al_anika_add_color_field_to_add_form() {
        ?>
        <div class="form-field term-color-wrap">
            <label for="term-color"><?php _e( 'Color', 'alam-al-anika' ); ?></label>
            <input name="term_color" id="term-color" type="text" value="" class="alam-al-anika-color-picker" data-default-color="#ffffff" />
            <p><?php _e( 'Choose a color for this attribute term.', 'alam-al-anika' ); ?></p>
        </div>
        <?php
    }
}
add_action( 'pa_color_add_form_fields', 'alam_al_anika_add_color_field_to_add_form' );


/**
 * 2. Add color picker field to the "Edit Color Term" screen.
 */
if ( ! function_exists( 'alam_al_anika_add_color_field_to_edit_form' ) ) {
    function alam_al_anika_add_color_field_to_edit_form( $term ) {
        $color = get_term_meta( $term->term_id, 'color_value', true );
        ?>
        <tr class="form-field term-color-wrap">
            <th scope="row"><label for="term-color"><?php _e( 'Color', 'alam-al-anika' ); ?></label></th>
            <td>
                <input name="term_color" id="term-color" type="text" value="<?php echo esc_attr( $color ); ?>" class="alam-al-anika-color-picker" data-default-color="#ffffff" />
            </td>
        </tr>
        <?php
    }
}
add_action( 'pa_color_edit_form_fields', 'alam_al_anika_add_color_field_to_edit_form' );

/**
 * 3. Save the color value when a color term is created or edited.
 */
if ( ! function_exists( 'alam_al_anika_save_term_color' ) ) {
    function alam_al_anika_save_term_color( $term_id ) {
        if ( isset( $_POST['term_color'] ) && ! empty( $_POST['term_color'] ) ) {
            update_term_meta( $term_id, 'color_value', sanitize_hex_color( $_POST['term_color'] ) );
        }
    }
}
add_action( 'created_pa_color', 'alam_al_anika_save_term_color' );
add_action( 'edited_pa_color', 'alam_al_anika_save_term_color' );


/**
 * 4. Enqueue the WordPress color picker script and styles on the correct admin pages.
 */
if ( ! function_exists( 'alam_al_anika_enqueue_admin_assets' ) ) {
    function alam_al_anika_enqueue_admin_assets( $hook ) {
        $screen = get_current_screen();
        if ( $hook === 'edit-tags.php' && isset($screen->taxonomy) && $screen->taxonomy === 'pa_color' ) {
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_script( 'wp-color-picker' );
            add_action( 'admin_footer', 'alam_al_anika_init_color_picker_js' );
        }
    }
}
add_action( 'admin_enqueue_scripts', 'alam_al_anika_enqueue_admin_assets' );

/**
 * 5. Initialize the color picker using JavaScript in the admin footer.
 */
if ( ! function_exists( 'alam_al_anika_init_color_picker_js' ) ) {
    function alam_al_anika_init_color_picker_js() {
        ?>
        <script>jQuery(document).ready(function($){$('.alam-al-anika-color-picker').wpColorPicker();});</script>
        <?php
    }
}


/**
 * 6. Override the default WooCommerce dropdown for the 'color' attribute on the front-end.
 */
if ( ! function_exists( 'alam_al_anika_variation_swatches' ) ) {
    function alam_al_anika_variation_swatches( $html, $args ) {
        $attribute_name = $args['attribute'];

        if ( $attribute_name !== 'pa_color' ) {
            return $html;
        }

        $swatches = '';
        $options   = $args['options'];
        $product   = $args['product'];

        if ( empty( $options ) && ! empty( $product ) ) {
            $attributes = $product->get_variation_attributes();
            $options    = $attributes[ $attribute_name ];
        }

        if ( ! empty( $options ) ) {
            if ( $product && taxonomy_exists( $attribute_name ) ) {
                $terms = wc_get_product_terms( $product->get_id(), $attribute_name, array( 'fields' => 'all' ) );

                foreach ( $terms as $term ) {
                    if ( in_array( $term->slug, $options, true ) ) {
                        $color = get_term_meta( $term->term_id, 'color_value', true );
                        $swatches .= sprintf(
                            '<div class="swatch swatch-color" data-value="%s" style="background-color:%s;" title="%s"></div>',
                            esc_attr( $term->slug ),
                            esc_attr( $color ),
                            esc_attr( $term->name )
                        );
                    }
                }
            }
        }

        return '<div class="swatch-container color-swatches">' . $swatches . '</div>' . $html;
    }
}
add_filter( 'woocommerce_dropdown_variation_attributes', 'alam_al_anika_variation_swatches', 100, 2 );


/**
 * 7. Add a body class to hide the default dropdown when swatches are active.
 */
if ( ! function_exists( 'alam_al_anika_add_body_class_for_swatches' ) ) {
    function alam_al_anika_add_body_class_for_swatches( $classes ) {
        global $product;
        // THIS IS THE FIX: Check if we are on a product page AND if $product is a valid object.
        if ( is_product() && is_a( $product, 'WC_Product' ) && $product->is_type( 'variable' ) ) {
            $attributes = $product->get_variation_attributes();
            if ( isset( $attributes['pa_color'] ) ) {
                $classes[] = 'swatches-active';
            }
        }
        return $classes;
    }
}
add_filter( 'body_class', 'alam_al_anika_add_body_class_for_swatches' );