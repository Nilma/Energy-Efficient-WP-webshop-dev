<!-- Registrere forskellige funktioner, som temaet skal bruge og tilføje hooks hvis nødvendigt. den virker ligesom motoren på en bil -->
<?php
// Theme setup - registrér funktioner, som temaet skal bruge
function my_simple_theme_setup() {
    // Aktivér title-tag support - dette gør det muligt at tilføje en titel til temaet
    add_theme_support('title-tag');

    // Aktivér featured images - dette gør det muligt at tilføje et billede til et indlæg
    add_theme_support('post-thumbnails');

    // Registrér menuer i temaet - her registreres en menu med navnet "Primary Menu"
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'customwebshop'),
    ));
}
add_action('after_setup_theme', 'my_simple_theme_setup'); // her fortæller vi fortæller WordPress at efter wordpress har sat temaet op, så kør funktionen my_simple_theme_setup()



// Indlæs stylesheet og scripts - dette gør det muligt at tilføje stylesheets og scripts til temaet via en enqueue funktion
function my_simple_theme_scripts() {
    wp_enqueue_style('style.css', get_stylesheet_uri());
}
add_action('wp_enqueue_scripts', 'my_simple_theme_scripts');



// Tilføj custom fonts - dette gør det muligt at tilføje custom fonts til temaet
function my_custom_fonts() {
    wp_enqueue_style(
        'google-fonts',
        'https://fonts.googleapis.com/css2?family=Inter:wght@300&display=swap',
        array(),
        null
    );
}
add_action('wp_enqueue_scripts', 'my_custom_fonts');

// Start session for cart and handle Add to Cart
add_action('init', function () {
    if (!session_id()) {
        session_start();
    }

    if (isset($_GET['add_to_cart'])) {
        $post_id = intval($_GET['add_to_cart']);
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
        if (!in_array($post_id, $_SESSION['cart'])) {
            $_SESSION['cart'][] = $post_id;
        }
        wp_redirect(remove_query_arg('add_to_cart'));
        exit;
    }
});

// Handle removing items from cart
add_action('init', function () {
    if (isset($_GET['remove_from_cart'])) {
        $key = intval($_GET['remove_from_cart']);
        if (isset($_SESSION['cart'][$key])) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['cart'] = array_values($_SESSION['cart']); // reindex array
        }
        wp_redirect(remove_query_arg('remove_from_cart'));
        exit;
    }
});