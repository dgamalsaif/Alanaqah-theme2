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

        // --- Size Swatches ---
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

        // --- Added to Cart Notification ---
        $(document.body).on('added_to_cart', function(event, btn) {
            var msg = $(btn).closest('.product-card').find('.woocommerce-loop-product__title').text() || 'تمت إضافة المنتج للسلة!';
            var $note = $('#notification');
            $note.text(msg).addClass('show');
            setTimeout(function(){ $note.removeClass('show'); }, 2600);
        });

        // ===============================================
        // START: Quick View Code
        // ===============================================

        // Quick View AJAX Handler
        $('body').on('click', '.quick-view-btn', function(e) {
            e.preventDefault();
            
            var productId = $(this).data('product-id');
            var modalWrapper = $('#quick-view-modal-wrapper');
            var modalContent = $('#quick-view-content');

            modalContent.html('<p>جاري التحميل...</p>');
            modalWrapper.show();

            $.ajax({
                url: alam_anika_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'load_product_quick_view',
                    product_id: productId
                },
                success: function(response) {
                    modalContent.html(response);
                    // This is important to re-initialize WooCommerce scripts for the new content
                    // For example, the variation form scripts and the gallery scripts.
                    $(document.body).trigger('wc_variation_form');
                    modalContent.find('.woocommerce-product-gallery').each(function() {
                        $(this).wc_product_gallery();
                    });
                },
                error: function() {
                    modalContent.html('<p>حدث خطأ، يرجى المحاولة مرة أخرى.</p>');
                }
            });
        });

        // Close modal
        $('body').on('click', '.modal-overlay, .modal-close', function(e) {
            e.preventDefault();
            $('#quick-view-modal-wrapper').hide();
        });

        // ===============================================
        // END: Quick View Code
        // ===============================================

    });
// ... الكود السابق مثل كود النظرة السريعة

// Live AJAX Search Handler
var searchInput = $('.search-form .search-field');
var resultsContainer = $('#live-search-results');
var typingTimer; // مؤقت لتأخير الطلب
var doneTypingInterval = 300; // الوقت بالمللي ثانية (0.3 ثانية)

// عند الكتابة في حقل البحث
searchInput.on('keyup', function() {
    clearTimeout(typingTimer);
    typingTimer = setTimeout(performLiveSearch, doneTypingInterval);
});

// عند الانتهاء من الكتابة
searchInput.on('keydown', function() {
    clearTimeout(typingTimer);
});

function performLiveSearch() {
    var query = searchInput.val();

    if (query.length < 3) { // لا تقم بالبحث إلا إذا كان النص 3 أحرف أو أكثر
        resultsContainer.hide().html('');
        return;
    }

    resultsContainer.html('<div class="loading-results">جاري البحث...</div>').show();

    $.ajax({
        url: alam_anika_ajax.ajax_url, // نفس المتغير الذي استخدمناه سابقاً
        type: 'POST',
        data: {
            action: 'live_product_search',
            query: query
        },
        success: function(response) {
            resultsContainer.html(response).show();
        }
    });
}

// إخفاء النتائج عند النقر في أي مكان آخر في الصفحة
$(document).on('click', function(e) {
    if (!$(e.target).closest('.search-container').length) {
        resultsContainer.hide();
    }
});
})(jQuery);