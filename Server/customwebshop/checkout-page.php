<?php
/*
 * Template Name: Checkout
 */
get_header();
?>

<div class="front-page-content">
    <h1 class="front-page-title">Tak for din ordre!</h1>

    <p>Her er dine købte varer:</p>

    <?php
    session_start();
    if (!empty($_SESSION['cart'])) {
        echo '<div class="cart-items">';
        foreach ($_SESSION['cart'] as $post_id) {
            $post = get_post($post_id);
            $price = get_post_meta($post_id, 'price', true);

            echo '<div class="cart-item" style="margin-bottom: 1rem; padding: 1rem; border: 1px solid #ccc; border-radius: 8px;">';
            echo '<h2>' . esc_html($post->post_title) . '</h2>';
            if ($price) {
                echo '<p>Pris: ' . esc_html($price) . ' DKK</p>';
            }
            echo '</div>';
        }
        echo '</div>';
    } else {
        echo '<p>Ingen varer i din kurv.</p>';
    }
    ?>

    <p style="margin-top:2rem;">Tak fordi du handler hos Urban Shop!</p>

<?php get_footer(); ?>