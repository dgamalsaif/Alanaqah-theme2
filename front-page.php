<?php
/**
 * The template for displaying the dynamic homepage built from the Customizer.
 */

get_header(); ?>

<main id="main" class="site-main">
    <?php
    // جلب التخطيط المختار من أداة التخصيص
    $selected_layout_key = get_theme_mod('fw_layout_preset', 'default_store');
    
    // جلب بيانات كل التخطيطات من ملف JSON
    $layout_presets = fw_get_config_presets('layout-presets');

    // التأكد من وجود التخطيط المختار
    if (isset($layout_presets[$selected_layout_key])) {
        $layout_blocks = $layout_presets[$selected_layout_key]['layout'];

        // المرور على البلوكات المحددة في التخطيط وعرضها
        foreach ($layout_blocks as $block) {
            $block_slug = $block['block'];
            $settings = $block['settings'] ?? []; // إعدادات البلوك (اختيارية)

            // استدعاء ملف البلوك المناسب وتمرير الإعدادات إليه
            wc_get_template("template-parts/blocks/block-{$block_slug}.php", $settings);
        }
    }
    ?>
</main>

<?php get_footer(); ?>