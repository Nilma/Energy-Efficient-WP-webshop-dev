<?php
/**
 * Twenty Twenty-Five functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_Five
 * @since Twenty Twenty-Five 1.0
 */

// Adds theme support for post formats.
if ( ! function_exists( 'twentytwentyfive_post_format_setup' ) ) :
	/**
	 * Adds theme support for post formats.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_post_format_setup() {
		add_theme_support( 'post-formats', array( 'aside', 'audio', 'chat', 'gallery', 'image', 'link', 'quote', 'status', 'video' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_post_format_setup' );

// Enqueues editor-style.css in the editors.
if ( ! function_exists( 'twentytwentyfive_editor_style' ) ) :
	/**
	 * Enqueues editor-style.css in the editors.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_editor_style() {
		add_editor_style( get_parent_theme_file_uri( 'assets/css/editor-style.css' ) );
	}
endif;
add_action( 'after_setup_theme', 'twentytwentyfive_editor_style' );

// Enqueues style.css on the front.
if ( ! function_exists( 'twentytwentyfive_enqueue_styles' ) ) :
	/**
	 * Enqueues style.css on the front.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_enqueue_styles() {
		wp_enqueue_style(
			'twentytwentyfive-style',
			get_parent_theme_file_uri( 'style.css' ),
			array(),
			wp_get_theme()->get( 'Version' )
		);
	}
endif;
add_action( 'wp_enqueue_scripts', 'twentytwentyfive_enqueue_styles' );

// Registers custom block styles.
if ( ! function_exists( 'twentytwentyfive_block_styles' ) ) :
	/**
	 * Registers custom block styles.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_block_styles() {
		register_block_style(
			'core/list',
			array(
				'name'         => 'checkmark-list',
				'label'        => __( 'Checkmark', 'twentytwentyfive' ),
				'inline_style' => '
				ul.is-style-checkmark-list {
					list-style-type: "\2713";
				}

				ul.is-style-checkmark-list li {
					padding-inline-start: 1ch;
				}',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_block_styles' );

// Registers pattern categories.
if ( ! function_exists( 'twentytwentyfive_pattern_categories' ) ) :
	/**
	 * Registers pattern categories.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_pattern_categories() {

		register_block_pattern_category(
			'twentytwentyfive_page',
			array(
				'label'       => __( 'Pages', 'twentytwentyfive' ),
				'description' => __( 'A collection of full page layouts.', 'twentytwentyfive' ),
			)
		);

		register_block_pattern_category(
			'twentytwentyfive_post-format',
			array(
				'label'       => __( 'Post formats', 'twentytwentyfive' ),
				'description' => __( 'A collection of post format patterns.', 'twentytwentyfive' ),
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_pattern_categories' );

// Registers block binding sources.
if ( ! function_exists( 'twentytwentyfive_register_block_bindings' ) ) :
	/**
	 * Registers the post format block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return void
	 */
	function twentytwentyfive_register_block_bindings() {
		register_block_bindings_source(
			'twentytwentyfive/format',
			array(
				'label'              => _x( 'Post format name', 'Label for the block binding placeholder in the editor', 'twentytwentyfive' ),
				'get_value_callback' => 'twentytwentyfive_format_binding',
			)
		);
	}
endif;
add_action( 'init', 'twentytwentyfive_register_block_bindings' );

// Registers block binding callback function for the post format name.
if ( ! function_exists( 'twentytwentyfive_format_binding' ) ) :
	/**
	 * Callback function for the post format name block binding source.
	 *
	 * @since Twenty Twenty-Five 1.0
	 *
	 * @return string|void Post format name, or nothing if the format is 'standard'.
	 */
	function twentytwentyfive_format_binding() {
		$post_format_slug = get_post_format();

		if ( $post_format_slug && 'standard' !== $post_format_slug ) {
			return get_post_format_string( $post_format_slug );
		}
	}
endif;

// Start session

add_action('init', function() {
    if (isset($_GET['clear_cart'])) {
        session_start();
        unset($_SESSION['cart']);
        wp_redirect(home_url('/cart/'));
        exit;
    }
});

add_action('init', function() {
    if (!session_id()) {
        session_start();
    }
});



// Handle Add to Cart
add_action('init', function() {
    if (isset($_GET['add_to_cart'])) {
        $product_id = intval($_GET['add_to_cart']);
        
        // Only allow adding real posts (products) that have a "price" field
        if (get_post_type($product_id) === 'post' && get_post_meta($product_id, 'price', true) !== '') {
            if (!session_id()) {
                session_start();
            }
            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = [];
            }
            if (!in_array($product_id, $_SESSION['cart'])) {
                $_SESSION['cart'][] = $product_id;
            }
            // Redirect
            wp_redirect(home_url('/cart/'));
            exit;
        }
    }
});

// Handle Remove from Cart
add_action('init', function() {
    if (isset($_GET['remove_from_cart'])) {
        if (isset($_SESSION['cart'][intval($_GET['remove_from_cart'])])) {
            unset($_SESSION['cart'][intval($_GET['remove_from_cart'])]);
            $_SESSION['cart'] = array_values($_SESSION['cart']);
        }
        wp_redirect(home_url('/cart/'));
        exit;
    }
});

// Show Cart
add_shortcode('show_cart', function() {
    if (empty($_SESSION['cart'])) {
        return '<p>Din kurv er tom.</p>';
    }

    $output = '<div style="padding:2rem;">';
    $output .= '<table style="width:100%;border-collapse:collapse;">';
    $output .= '<thead><tr>';
    $output .= '<th style="text-align:left;padding:0.5rem;border-bottom:1px solid #ccc;">Produkt</th>';
    $output .= '<th style="text-align:left;padding:0.5rem;border-bottom:1px solid #ccc;">Pris</th>';
    $output .= '</tr></thead><tbody>';

    $total = 0;
    foreach ($_SESSION['cart'] as $product_id) {
        $title = get_the_title($product_id);
        $price = get_post_meta($product_id, 'price', true); // <- Fix here: Capital P

        if (!$price) {
            $price = 0;
        }

        $total += (float)$price;

        $output .= '<tr>';
        $output .= '<td style="padding:0.5rem;border-bottom:1px solid #ccc;">' . esc_html($title) . '</td>';
        $output .= '<td style="padding:0.5rem;border-bottom:1px solid #ccc;">' . esc_html($price) . ' DKK</td>';
        $output .= '</tr>';
    }

    $output .= '</tbody></table>';
    $output .= '<p style="margin-top:1rem;"><strong>Total:</strong> ' . esc_html($total) . ' DKK</p>';

    $checkout_url = esc_url(site_url('/checkout/'));
    $output .= '<div style="margin-top:2rem;">';
    $output .= '<a href="' . $checkout_url . '" class="wp-block-button__link" style="background-color:#dc3545;color:#fff;padding:1rem 2rem;border-radius:0.3rem;text-decoration:none;">Checkout</a>';
    $output .= '</div>';
    $output .= '</div>';

    return $output;
});

// Shortcode to show cart items inside checkout
add_shortcode('show_cart_items', function() {
    if (!session_id()) {
        session_start();
    }

    if (empty($_SESSION['cart'])) {
        return '<p>Din kurv er tom.</p>';
    }

    $output = '<div style="padding:2rem;">';
    $output .= '<table style="width:100%;border-collapse:collapse;">';
    $output .= '<thead><tr>';
    $output .= '<th style="text-align:left;padding:0.5rem;border-bottom:1px solid #ccc;">Produkt</th>';
    $output .= '<th style="text-align:left;padding:0.5rem;border-bottom:1px solid #ccc;">Pris</th>';
    $output .= '</tr></thead><tbody>';

    $total = 0;
    foreach ($_SESSION['cart'] as $product_id) {
        $title = get_the_title($product_id);
        $price = get_post_meta($product_id, 'price', true);

        if (!$price) {
            $price = 0;
        }

        $total += (float)$price;

        $output .= '<tr>';
        $output .= '<td style="padding:0.5rem;border-bottom:1px solid #ccc;">' . esc_html($title) . '</td>';
        $output .= '<td style="padding:0.5rem;border-bottom:1px solid #ccc;">' . esc_html($price) . ' DKK</td>';
        $output .= '</tr>';
    }

    $output .= '</tbody></table>';
    $output .= '<p style="margin-top:1rem;"><strong>Total:</strong> ' . esc_html($total) . ' DKK</p>';
    $output .= '</div>';

    return $output;
});