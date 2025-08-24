 (function($) {
    "use strict";
    $(document).ready(function() {
        // --- Hero Slider Functionality ---
        const heroSlides = document.querySelectorAll('.hero-slide');
        const heroDots = document.querySelectorAll('.hero-dot');
        let currentSlide = 0;
        
        function showSlide(index) {
            if (heroSlides.length === 0 || heroDots.length === 0) return;
            heroSlides.forEach(slide => {
                slide.classList.remove('active');
            });
            heroDots.forEach(dot => {
                dot.classList.remove('active');
            });
            
            if (heroSlides[index] && heroDots[index]) {
                heroSlides[index].classList.add('active');
                heroDots[index].classList.add('active');
            }
        }
        
        heroDots.forEach((dot, index) => {
            dot.addEventListener('click', function() {
                currentSlide = index;
                showSlide(currentSlide);
            });
        });
        
        if (heroSlides.length > 1) {
            setInterval(function() {
                currentSlide = (currentSlide + 1) % heroSlides.length;
                showSlide(currentSlide);
            }, 5000);
        }
        
        // Show the first slide initially if it exists
        if (heroSlides.length > 0) {
            showSlide(0);
        }
        
        // --- SWATCHES JAVASCRIPT ---
        function initSwatches() {
            $('.variations_form').on('click', '.variation-swatches-container .swatch', function(e) {
                e.preventDefault();
                var $swatch = $(this);
                var value = $swatch.data('value');
                var $select = $('select[name="attribute_pa_color"]');
                if ($swatch.hasClass('selected')) {
                    return;
                }
                if ($select.length > 0) {
                    $select.val(value).trigger('change');
                    $swatch.siblings('.swatch').removeClass('selected');
                    $swatch.addClass('selected');
                }
            });
            
            $('.variations_form').on('woocommerce_update_variation_nav', function() {
                var selectedValue = $('select[name="attribute_pa_color"]').val();
                if (selectedValue) {
                    $('.variation-swatches-container .swatch').removeClass('selected');
                    $('.variation-swatches-container .swatch[data-value="' + selectedValue + '"]').addClass('selected');
                }
            });
        }
        initSwatches();
        
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
        
        // --- Added to Cart Notification ---
        $(document.body).on('added_to_cart', function(event, btn) {
            var msg = $(btn).closest('.product-card').find('.woocommerce-loop-product__title').text() || 'تمت إضافة المنتج للسلة!';
            var $note = $('#notification');
            $note.text(msg).addClass('show');
            setTimeout(function(){ $note.removeClass('show'); }, 2600);
        });
        
        // --- Quick View Code ---
        $('body').on('click', '.quick-view-btn', function(e) {
            e.preventDefault();
            
            var productId = $(this).data('product-id');
            var modalWrapper = $('#quick-view-modal-wrapper');
            var modalContent = $('#quick-view-content');
            modalContent.html('<p>جاري التحميل...</p>');
            modalWrapper.show();
            
            $.ajax({
                url: alam_al_anika_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'load_product_quick_view',
                    product_id: productId
                },
                success: function(response) {
                    modalContent.html(response);
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
        
        $('body').on('click', '.modal-overlay, .modal-close', function(e) {
            e.preventDefault();
            $('#quick-view-modal-wrapper').hide();
        });

        // --- Live AJAX Search Handler ---
        var searchInput = $('.search-form .search-field');
        var resultsContainer = $('#live-search-results');
        var typingTimer;
        var doneTypingInterval = 300;
        
        searchInput.on('keyup', function() {
            clearTimeout(typingTimer);
            typingTimer = setTimeout(performLiveSearch, doneTypingInterval);
        });
        
        searchInput.on('keydown', function() {
            clearTimeout(typingTimer);
        });
        
        function performLiveSearch() {
            var query = searchInput.val();
            if (query.length < 3) {
                resultsContainer.hide().html('');
                return;
            }
            
            resultsContainer.html('<div class="loading-results">جاري البحث...</div>').show();
            
            $.ajax({
                url: alam_al_anika_ajax.ajax_url,
                type: 'POST',
                data: {
                    action: 'alam_al_anika_live_search',
                    query: query,
                    security: alam_al_anika_ajax.search_nonce
                },
                success: function(response) {
                    resultsContainer.html(response).show();
                }
            });
        }
        
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.search-container').length) {
                resultsContainer.hide();
            }
        });
        
        // --- Countdown Timers ---
        function initializeCountdown(elementId, initialTimeStr) {
            const countdownElement = document.getElementById(elementId);
            if (!countdownElement) return;
            
            let timeParts = initialTimeStr.split(':').map(Number);
            let totalSeconds = timeParts[0] * 3600 + timeParts[1] * 60 + timeParts[2];
            
            const timerInterval = setInterval(function() {
                if (totalSeconds <= 0) {
                    clearInterval(timerInterval);
                    countdownElement.textContent = " انتهى العرض ";
                    return;
                }
                
                totalSeconds--;
                
                let hours = Math.floor(totalSeconds / 3600);
                let minutes = Math.floor((totalSeconds % 3600) / 60);
                let seconds = totalSeconds % 60;
                
                countdownElement.textContent = 
                    `ينتهي خلال: ${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
            }, 1000);
        }
        
        // Start the timers
        initializeCountdown('flash-timer-countdown', '05:53:48');
        initializeCountdown('deals-timer-countdown', '02:34:56');
        
        // --- Animation on Scroll ---
        function animateOnScroll() {
            $('.animate-on-scroll').each(function() {
                const elementTop = $(this).offset().top;
                const elementBottom = elementTop + $(this).outerHeight();
                const viewportTop = $(window).scrollTop();
                const viewportBottom = viewportTop + $(window).height();
                
                if (elementBottom > viewportTop && elementTop < viewportBottom) {
                    $(this).addClass('is-visible');
                }
            });
        }
        
        $(window).on('scroll', animateOnScroll);
        animateOnScroll();
        
        // --- Mobile Menu Toggle ---
        $('.menu-toggle').on('click', function() {
            $('.nav-menu ul').toggleClass('mobile-active');
        });
        
        // --- Product Gallery ---
        if ($('.woocommerce-product-gallery').length) {
            $('.woocommerce-product-gallery').flexslider({
                selector: '.woocommerce-product-gallery__wrapper > .woocommerce-product-gallery__image',
                animation: 'slide',
                controlNav: false,
                directionNav: false,
                animationLoop: false,
                slideshow: false
            });
            
            $('.flex-control-nav').flexslider({
                selector: '.flex-control-nav li img',
                animation: 'slide',
                controlNav: false,
                directionNav: false,
                animationLoop: false,
                slideshow: false,
                itemWidth: 100,
                itemMargin: 10,
                asNavFor: '.woocommerce-product-gallery'
            });
        }
    });
})(jQuery);
