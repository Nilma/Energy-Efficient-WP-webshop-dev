<?php
/*
Template Name: Shop
*/
get_header();
?>

<div class="shop-container">
    <h1>Shop</h1>

    <div class="post-grid">
        <?php
        // WP Query for fetching all posts
        $args = array(
            'post_type'      => 'post',
            'posts_per_page' => -1
        );
        $all_posts_query = new WP_Query($args);

        if ($all_posts_query->have_posts()) :
            while ($all_posts_query->have_posts()) : $all_posts_query->the_post();
                ?>
                <div class="post-item" style="border: 1px solid #ccc; padding: 1rem; margin-bottom: 2rem; border-radius: 8px;">
                    
                    <!-- Product Image -->
                    <a href="<?php the_permalink(); ?>">
                        <?php 
                        if (has_post_thumbnail()) {
                            the_post_thumbnail('full'); 
                        }
                        ?>
                    </a>

                    <!-- Product Title -->
                    <h2 class="post-title">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_title(); ?>
                        </a>
                    </h2>

                    <!-- Product Excerpt (short description) -->
                    <div class="post-excerpt">
                        <?php
                        $excerpt = wp_trim_words(get_the_content(), 25, '...');
                        echo $excerpt;
                        ?>
                    </div>

                    <!-- Product Price -->
                    <p class="product-price" style="font-weight: bold;">
                        <?php 
                        $price = get_post_meta(get_the_ID(), 'price', true);
                        if ($price) {
                            echo 'Pris: ' . esc_html($price) . ' DKK';
                        } else {
                            echo 'Pris: Ikke angivet';
                        }
                        ?>
                    </p>

                    <!-- Add to Cart Button -->
                    <a class="add-to-cart-button" href="?add_to_cart=<?php the_ID(); ?>" style="display: inline-block; margin-top: 10px; padding: 10px 20px; background: #0073aa; color: white; text-decoration: none; border-radius: 5px;">
                        Tilføj til Kurv
                    </a>

                </div>
                <?php
            endwhile;
            wp_reset_postdata();
        else :
            echo '<p>Ingen produkter tilgængelige.</p>';
        endif;
        ?>
    </div>
</div>

<?php get_footer(); ?>