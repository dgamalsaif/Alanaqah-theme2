<?php
/**
 * ثوابت القالب الأساسية
 */
define('FW_VERSION', '1.0.0');
define('FW_PATH', get_template_directory());
define('FW_URI', get_template_directory_uri());

/**
 * 1. إعدادات القالب الأساسية
 */
add_action('after_setup_theme', 'fw_basic_setup');
function fw_basic_setup() {
    // تحميل النصوص العربية
    load_theme_textdomain('fashion-world', FW_PATH . '/languages');
    
    // دعم الميزات الأساسية
    add_theme_support('title-tag');
    add_theme_support('post-thumbnails');
    add_theme_support('html5', ['gallery', 'caption']);
    
    // تسجيل القوائم
    register_nav_menus([
        'main-menu' => __('القائمة الرئيسية', 'fashion-world'),
        'footer-menu' => __('قائمة التذييل', 'fashion-world')
    ]);
    
    // أحجام الصور الأساسية
    add_image_size('fw_hero', 1920, 1080, true);
    add_image_size('fw_thumbnail', 400, 400, true);
}

/**
 * 2. تسجيل الأصول (CSS/JS)
 */
add_action('wp_enqueue_scripts', 'fw_enqueue_assets');
function fw_enqueue_assets() {
    // CSS الأساسي
    wp_enqueue_style('fw-main', FW_URI . '/assets/css/main.css', [], FW_VERSION);
    
    // JavaScript الأساسي
    wp_enqueue_script('fw-main', FW_URI . '/assets/js/main.js', ['jquery'], FW_VERSION, true);
}

/**
 * 3. نظام الألوان التكيفي (البداية)
 */
add_action('wp_head', 'fw_apply_adaptive_colors');
function fw_apply_adaptive_colors() {
    $colors = get_theme_mod('adaptive_colors', [
        'primary' => ['r' => 212, 'g' => 168, 'b' => 92],
        'secondary' => ['r' => 26, 'g' => 26, 'b' => 26],
        'accent' => ['r' => 232, 'g' => 215, 'b' => 195]
    ]);
    
    echo "<style>
        :root {
            --color-primary: rgb({$colors['primary']['r']},{$colors['primary']['g']},{$colors['primary']['b']});
            --color-secondary: rgb({$colors['secondary']['r']},{$colors['secondary']['g']},{$colors['secondary']['b']});
            --color-accent: rgb({$colors['accent']['r']},{$colors['accent']['g']},{$colors['accent']['b']});
        }
    </style>";
}
// تسجيل أنماط الإدارة    
add_action('admin_enqueue_scripts', 'fw_admin_assets');
function fw_admin_assets() {
    wp_enqueue_style('fw-admin-css', FW_URI . '/assets/css/admin.css');
}
// تسجيل الأصول المعدل
add_action('wp_enqueue_scripts', 'fw_assets');
function fw_assets() {
    // ... (الكود السابق)
    
    // تسجيل المكتبات
    wp_enqueue_script('fw-vibrant', FW_URI . '/assets/js/lib/vibrant.min.js', [], '1.0', true);
    wp_enqueue_script('fw-color-adaptor', FW_URI . '/assets/js/color-adaptor.js', ['fw-vibrant'], FW_VERSION, true);
    
    // نقل البيانات لـ JS
    wp_localize_script('fw-color-adaptor', 'fw_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('fw_ajax_nonce')
    ]);
}

// إضافة نقطة نهاية لحفظ الألوان
add_action('wp_ajax_fw_save_colors', 'fw_save_colors');
function fw_save_colors() {
    check_ajax_referer('fw_ajax_nonce', 'nonce');
    
    if (!empty($_POST['colors'])) {
        $colors = $_POST['colors'];
        
        // تحويل HEX إلى RGB
        function hex2rgb($hex) {
            $hex = str_replace("#", "", $hex);
            if(strlen($hex) == 3) {
                $r = hexdec(substr($hex,0,1).substr($hex,0,1));
                $g = hexdec(substr($hex,1,1).substr($hex,1,1));
                $b = hexdec(substr($hex,2,1).substr($hex,2,1));
            } else {
                $r = hexdec(substr($hex,0,2));
                $g = hexdec(substr($hex,2,2));
                $b = hexdec(substr($hex,4,2));
            }
            return ['r' => $r, 'g' => $g, 'b' => $b];
        }
        
        update_theme_mod('adaptive_colors', [
            'primary' => hex2rgb($colors['primary']),
            'secondary' => hex2rgb($colors['secondary']),
            'accent' => hex2rgb($colors['accent'])
        ]);
        
        wp_send_json_success();
    }
    wp_send_json_error();
}
// ... (الكود السابق)

// تسجيل أنماط المحرر
add_action('admin_enqueue_scripts', 'fw_layout_editor_assets');
function fw_layout_editor_assets($hook) {
    if ($hook === 'toplevel_page_layout-builder') {
        // CSS
        wp_enqueue_style('fw-layout-editor', FW_URI . '/assets/css/layout-editor.css');
        
        // JS
        wp_enqueue_script('interact-js', FW_URI . '/assets/js/lib/interact.min.js', [], '1.10.0', true);
        wp_enqueue_script('fw-layout-editor', FW_URI . '/assets/js/layout-editor.js', ['interact-js', 'fw-vibrant'], FW_VERSION, true);
        
        // نقل البيانات
        wp_localize_script('fw-layout-editor', 'fw_ajax', [
            'ajax_url' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('fw_layout_nonce')
        ]);
    }
}

// تسجيل AJAX لحفظ التخطيطات
add_action('wp_ajax_fw_save_layout', 'fw_save_layout');
function fw_save_layout() {
    check_ajax_referer('fw_layout_nonce', 'nonce');
    
    if (!empty($_POST['layout'])) {
        $layout_data = json_decode(stripslashes($_POST['layout']), true);
        
        // حفظ التخطيط
        $layout_builder = new FashionWorld_LayoutBuilder();
        $layout_builder->save_layout($layout_data);
        
        wp_send_json_success(['message' => 'تم حفظ التخطيط بنجاح']);
    }
    
    wp_send_json_error(['message' => 'فشل في حفظ التخطيط']);
}
// ... (الكود السابق)

// دعم ووكومرس
add_action('after_setup_theme', function() {
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
});

// تحميل نواة ووكومرس
require_once FW_PATH . '/core/WooCore.php';

// تسجيل سكريبتات السلة
add_action('wp_enqueue_scripts', 'fw_woo_scripts');
function fw_woo_scripts() {
    wp_enqueue_script('fw-cart', FW_URI . '/assets/js/cart.js', ['jquery'], FW_VERSION, true);
    
    wp_localize_script('fw-cart', 'fw_cart', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('fw_cart_nonce')
    ]);
}
// ... (الكود السابق)

// تسجيل نظام السمات
require_once FW_PATH . '/core/AttributeSystem.php';

// تسجيل أصول السمات
add_action('wp_enqueue_scripts', 'fw_attribute_assets');
function fw_attribute_assets() {
    wp_enqueue_style('fw-attributes', FW_URI . '/assets/css/attributes.css');
    wp_enqueue_script('fw-attributes', FW_URI . '/assets/js/attributes.js', ['jquery'], FW_VERSION, true);
    
    // فقط في لوحة التحكم
    if (is_admin()) {
        wp_enqueue_media(); // تمكين رفع الصور
    }
}
// ... (الكود السابق)

// تسجيل نظام الفلاتر
require_once FW_PATH . '/core/ProductFilter.php';

// تسجيل أصول الفلاتر
add_action('wp_enqueue_scripts', 'fw_filter_assets');
function fw_filter_assets() {
    wp_enqueue_style('fw-filters', FW_URI . '/assets/css/filters.css');
    wp_enqueue_script('fw-filters', FW_URI . '/assets/js/filters.js', ['jquery'], FW_VERSION, true);
    
    // مكتبة نطاق الأسعار
    wp_enqueue_script('nouislider', 'https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.js', [], '15.7.1', true);
    wp_enqueue_style('nouislider', 'https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/15.7.1/nouislider.min.css');
    
    // نقل بيانات AJAX
    wp_localize_script('fw-filters', 'fw_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('fw_filter_nonce')
    ]);
}
// In functions.php
require_once FW_PATH . '/core/CustomizerPro.php';
// تضمين مكتبة استخراج الألوان
require_once FW_PATH . '/inc/color-thief/ColorThief.php';
use ColorThief\ColorThief;

/**
 * دالة لتحليل الصورة وتحديد إذا كانت داكنة أم فاتحة
 * @param int $image_id
 * @return bool
 */
function fw_is_image_dark($image_id) {
    $image_path = get_attached_file($image_id);
    if (!$image_path || !file_exists($image_path)) {
        return false;
    }

    try {
        $dominant_color = ColorThief::getColor($image_path);
        // حساب السطوع (Luminance)
        $luminance = (0.299 * $dominant_color[0] + 0.587 * $dominant_color[1] + 0.114 * $dominant_color[2]) / 255;
        
        // إذا كان السطوع أقل من 0.5، نعتبر الصورة داكنة
        return $luminance < 0.5;

    } catch (Exception $e) {
        return false;
    }
}

// ... في ملف functions.php الرئيسي ...

// تحميل نظام إدارة العلامات التجارية
require_once FW_PATH . '/core/BrandManager.php';

// إضافة خطاف لعرض الشعار على بطاقة المنتج
add_action('woocommerce_before_shop_loop_item_title', 'fw_display_brand_on_product_card', 5);
function fw_display_brand_on_product_card() {
    global $product;
    // استدعاء المكون الجديد
    wc_get_template('templates/components/component-brand-display.php', ['product' => $product]);
}
// ... الكود السابق ...

// --- تفعيل نظام تبديل العملات (النسخة المعدلة) ---

// 1. تحميل الكلاس الرئيسي للنظام (تبقى كما هي)
require_once FW_PATH . '/modules/CurrencySwitcher/class-currency.php';
new FashionWorld_CurrencySwitcher();

// 2. ✨ تسجيل وتشغيل ملف الجافا سكريبت الجديد
add_action('wp_enqueue_scripts', 'fw_currency_switcher_assets');
function fw_currency_switcher_assets() {
    // تحميل ملف الجافا سكريبت
    wp_enqueue_script(
        'fw-currency-switcher-js', 
        FW_URI . '/modules/CurrencySwitcher/assets/currency-switcher.js', 
        ['jquery'], 
        FW_VERSION, 
        true
    );

    // إرسال بيانات AJAX إلى ملف الجافا سكريبت
    wp_localize_script('fw-currency-switcher-js', 'fw_currency_ajax', [
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('fw_switch_currency_nonce')
    ]);
}


// 3. ✨ حذف الدالة القديمة (لم نعد بحاجة إليها)
// remove_action('init', 'fw_handle_currency_switch');
// function fw_handle_currency_switch() { ... } // <-- قم بحذف هذه الدالة بالكامل

// ... (بقية الكود) ..
// ... الكود السابق ...

// --- تفعيل نظام تبديل اللغات ---

// 1. تحميل الكلاس الرئيسي للنظام
require_once FW_PATH . '/modules/LanguageSwitcher/class-language.php';
new FashionWorld_LanguageSwitcher();

// 2. إضافة دالة مساعدة لعرض مبدل اللغات
// يمكنك الآن استدعاء هذه الدالة في أي مكان في ملفات الهيدر
function fw_display_language_switcher() {
    FashionWorld_LanguageSwitcher::render();
}
/**
 * دالة مساعدة لجلب الإعدادات المسبقة من ملفات التكوين JSON
 *
 * @param string $file_name اسم ملف JSON (بدون الامتداد).
 * @return array مصفوفة الإعدادات المسبقة.
 */
function fw_get_config_presets($file_name) {
    $file_path = FW_PATH . "/config/{$file_name}.json";
    
    if (!file_exists($file_path)) {
        return [];
    }

    $content = file_get_contents($file_path);
    $presets = json_decode($content, true);

    if (json_last_error() !== JSON_ERROR_NONE) {
        return [];
    }

    return $presets;
}
/**
 * تطبيق الإعدادات المسبقة المختارة من أداة التخصيص
 */
add_action('wp_head', 'fw_apply_preset_styles');
function fw_apply_preset_styles() {
    // --- تطبيق منظومة الألوان ---
    $color_presets = fw_get_config_presets('color-presets');
    $selected_color_preset = get_theme_mod('fw_color_preset', 'golden'); // 'golden' هي القيمة الافتراضية
    
    // --- تطبيق نظام الخطوط ---
    $font_schemes = fw_get_config_presets('font-schemes');
    $selected_font_scheme = get_theme_mod('fw_font_scheme', 'elegant_serif');

    // التأكد من وجود الإعدادات قبل المتابعة
    if (!isset($color_presets[$selected_color_preset]) || !isset($font_schemes[$selected_font_scheme])) {
        return;
    }

    $colors = $color_presets[$selected_color_preset]['settings'];
    $fonts = $font_schemes[$selected_font_scheme]['settings'];

    // طباعة متغيرات CSS في رأس الصفحة
    echo "<style id='fw-preset-styles'>
        :root {
            --color-primary: {$colors['primary']};
            --color-secondary: {$colors['secondary']};
            --color-accent: {$colors['accent']};
            
            --font-headings: '{$fonts['headings_font_family']}', serif;
            --font-body: '{$fonts['body_font_family']}', sans-serif;
        }
        
        body {
            font-family: var(--font-body);
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--font-headings);
        }
    </style>";
}
// In functions.php

/**
 * تسجيل سكريبت المعاينة الحية لأداة التخصيص
 */
add_action('customize_preview_init', 'fw_customizer_live_preview');
function fw_customizer_live_preview() {
    wp_enqueue_script(
        'fw-customizer-preview',
        FW_URI . '/assets/js/customizer-preview.js',
        ['jquery', 'customize-preview'],
        FW_VERSION,
        true
    );

    // ✨ تمرير بيانات JSON إلى ملف الجافا سكريبت
    wp_localize_script('fw-customizer-preview', 'fw_preset_data', [
        'colors' => fw_get_config_presets('color-presets'),
        'fonts'  => fw_get_config_presets('font-schemes')
    ]);
}
// In functions.php
require_once FW_PATH . '/core/MegaMenuWalker.php'; 
// In functions.php
register_nav_menus([
    'primary' => __('القائمة الرئيسية', 'alam-al-anaqa'),
    'footer' => __('قائمة الفوتر', 'alam-al-anaqa'),
    'mobile' => __('القائمة المحمولة', 'alam-al-anaqa'),
    'top-bar-menu' => __('قائمة الشريط العلوي', 'alam-al-anaqa') // ✨ إضافة الموقع الجديد
]);
// In functions.php
require_once ALAM_THEME_DIR . '/inc/secondary-navigation.php';