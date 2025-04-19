<footer>
    <div class="footer-logo">
        <a href="<?php echo home_url('/'); ?>">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png">
        </a>
    </div>

    <nav class="footer-nav">
        <ul>
            <li><a href="<?php echo home_url('/shop'); ?>">Shop</a></li>
            <li><a href="<?php echo home_url('/kurv'); ?>">Kurv</a></li>
        </ul>
    </nav>

    <p class="copyright">
        &copy; <?php echo date('Y'); ?> Custom Webshop Wordpress
    </p>
</footer>

<?php wp_footer(); ?>
</body>
</html>
