<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<header>
    <!-- Logo og titel -->
    <div class="header-logo-and-title">
        <a href="<?php echo home_url('/'); ?>">
            <img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo.png" class="site-logo">
        </a>
            <div class="site-info">
                    <h1><?php bloginfo('name'); ?></h1>
            </div>
    </div>

    <!-- Navigation -->
    <nav class="main-nav">
        <ul>
            <li><a href="<?php echo site_url('/shop'); ?>">Shop</a></li>
            <li><a href="<?php echo site_url('/cart'); ?>">Kurv</a></li>
        </ul>
    </nav>
</header>
