<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="site-header">
    
    <div class="header-top">
        <div class="container">
            <div class="header-top-content">
                <div class="header-top-left">
                    <?php
                    // استدعاء قائمة الشريط العلوي (إذا كانت موجودة)
                    if (has_nav_menu('top-bar-menu')) {
                        wp_nav_menu([
                            'theme_location' => 'top-bar-menu',
                            'container' => false,
                            'menu_class' => 'top-bar-menu'
                        ]);
                    }
                    ?>
                </div>
                
                <div class="header-top-right">
                    </div>
            </div>
        </div>
    </div>

    <div class="header-container">
        <div class="site-branding">
            <?php if (has_custom_logo()) : ?>
                <?php the_custom_logo(); ?>
            <?php else : ?>
                <h1 class="site-title">
                    <a href="<?php echo esc_url(home_url('/')); ?>">
                        <?php bloginfo('name'); ?>
                    </a>
                </h1>
            <?php endif; ?>
        </div>

        <nav class="main-navigation">
            <?php wp_nav_menu([
                'theme_location' => 'main-menu',
                'container'      => false,
                'menu_class'     => 'menu main-menu',
                'walker'         => new FashionWorld_MegaMenu_Walker()
            ]); ?>
        </nav>
    </div>
</header>

<?php 
// هذا هو الكود الذي يقوم بعرض شريط التنقل الثانوي
// وهو يستدعي الدالة من ملف inc/secondary-navigation.php
if (function_exists('alam_display_secondary_nav')) {
    alam_display_secondary_nav();
}
?>

<main class="site-content">