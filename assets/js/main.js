```javascript name=assets/js/main.js
(function($) {
    "use strict";

    $(document).ready(function() {

        // --- SWATCHES JAVASCRIPT ---
        function initSwatches() {
            // When a swatch is clicked
            $('.variations_form').on('click', '.variation-swatches-container .swatch', function(e) {
                e.preventDefault();
                var $swatch = $(this);
                var value = $swatch.data('value');
                var $select = $('select[name="attribute_pa_color"]'); // Target the actual select dropdown

                // If this swatch is already selected, do nothing.
                if ($swatch.hasClass('selected')) {
                    return;
                }

                if ($select.length > 0) {
                    // Update the hidden select dropdown, which triggers WooCommerce's default variation handling
                    $select.val(value).trigger('change');
                    
                    // Update the visual state of the swatches
                    $swatch.siblings('.swatch').removeClass('selected');
                    $swatch.addClass('selected');
                }
            });

            // WooCommerce triggers this event when variations are updated (e.g., after selecting another attribute)
            $('.variations_form').on('woocommerce_update_variation_nav', function() {
                // Re-check which swatch should be selected based on the dropdown's value
                var selectedValue = $('select[name="attribute_pa_color"]').val();
                if (selectedValue) {
                    $('.variation-swatches-container .swatch').removeClass('selected');
                    $('.variation-swatches-container .swatch[data-value="' + selectedValue + '"]').addClass('selected');
                }
            });
        }
        initSwatches();

        // --- Back to Top Button ---
        const backToTopBtn = $('#back-to-top');
        $(window).on('scroll', function() {
            if ($(this).scrollTop() > 300) {
                backToTopBtn.addClass('show');
            } else {
                backToTopBtn.removeClass('show');
            }
        });
        backToTopBtn.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({
                scrollTop: 0
            }, 500);
        });

    });
    $('.variations_form').on('click','.size-swatch',function(e){
    e.preventDefault();
    var value = $(this).data('value');
    var $select = $('select[name="attribute_pa_size"]');
    if($select.length) {
        $select.val(value).trigger('change');
        $(this).siblings('.size-swatch').removeClass('selected');
        $(this).addClass('selected');
    }
});
$(document.body).on('added_to_cart', function(event, btn) {
    var msg = $(btn).closest('.product-card').find('.woocommerce-loop-product__title').text() || 'تمت إضافة المنتج للسلة!';
    var $note = $('#notification');
    $note.text(msg).addClass('show');
    setTimeout(function(){ $note.removeClass('show'); }, 2600);
});
})(jQuery);

