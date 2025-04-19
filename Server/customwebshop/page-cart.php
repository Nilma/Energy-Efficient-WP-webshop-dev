<?php
/*
 * Template Name: Cart
 */
get_header();
?>

<div class="front-page-content">
    <h1 class="front-page-title">Din Kurv</h1>

    <?php
    session_start();
    if (!empty($_SESSION['cart'])) {
        echo '<div class="cart-items">';
        foreach ($_SESSION['cart'] as $key => $post_id) {
            $post = get_post($post_id);
            $price = get_post_meta($post_id, 'price', true);

            echo '<div class="cart-item" style="margin-bottom: 1rem; padding: 1rem; border: 1px solid #ccc; border-radius: 8px;">';
            echo '<h2>' . esc_html($post->post_title) . '</h2>';
            if ($price) {
                echo '<p>Pris: ' . esc_html($price) . ' DKK</p>';
            }
            echo '<a href="?remove_from_cart=' . $key . '" style="color:red;">Fjern fra kurv</a>';
            echo '</div>';
        }
        echo '</div>';

        echo '<a class="checkout-button" href="' . site_url('/checkout') . '" style="display:inline-block;margin-top:2rem;padding:10px 20px;background:#28a745;color:white;text-decoration:none;border-radius:5px;">Gå til Checkout</a>';

    } else {
        echo '<p>Din kurv er tom.</p>';
        echo '<a class="shop-button" href="' . site_url('/shop') . '">SHOP</a>';
    }
    ?>
</div>

<?php get_footer(); ?>