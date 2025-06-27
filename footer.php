</main>
<footer class="site-footer" style="background-color: var(--color-secondary);">
    <div class="footer-container">
        <nav class="footer-navigation">
            <?php 
            // ✨ هذا هو المكان الصحيح والوحيد لوضع الكود
            wp_nav_menu([
                'theme_location' => 'footer-menu', // استهداف قائمة الفوتر
                'container'      => false,
                'menu_class'     => 'footer-menu',
                'depth'          => 1, // قوائم الفوتر غالباً لا تحتاج لعمق
                'walker'         => new FashionWorld_MegaMenu_Walker() // ✨ تم تفعيل المحرك هنا
            ]); 
            ?>
        </nav>
        
        <div class="copyright">
            &copy; <?php echo date('Y'); ?> <?php bloginfo('name'); ?>
        </div>
    </div>
</footer>
<?php wp_footer(); ?>
</body>
</html>