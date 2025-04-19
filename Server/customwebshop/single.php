<?php get_header(); ?>

<div class="single-product-content">
    <?php
    if (have_posts()) :
        while (have_posts()) : the_post(); ?>

            <?php the_post_thumbnail('full'); ?>
            <h1><?php the_title(); ?></h1>
            <?php the_content(); ?>

            <!-- Show price -->
            <p>
                <?php
                $price = get_post_meta(get_the_ID(), 'price', true);
                if ($price) {
                    echo 'Pris: ' . esc_html($price) . ' DKK';
                }
                ?>
            </p>

            <!-- Add to Cart Button -->
            <a class="add-to-cart-button" href="?add_to_cart=<?php the_ID(); ?>" style="display:inline-block;margin-top:1rem;padding:10px 20px;background:#0073aa;color:white;text-decoration:none;border-radius:5px;">
                Tilføj til Kurv
            </a>

        <?php endwhile;
    else :
        echo '<p>Ingen produkter fundet.</p>';
    endif;
    ?>
</div>

<?php get_footer(); ?>