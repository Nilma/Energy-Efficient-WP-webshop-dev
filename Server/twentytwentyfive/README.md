# UrbanShop 2025 WordPress Setup

## Overview
UrbanShop 2025 is a lightweight **webshop** built with:
- WordPress 6.5+
- TwentyTwentyFive Theme
- Only custom PHP (`functions.php`)
- **No plugins** (no WooCommerce)

## Structure

### Products
- **12 Products** (Posts)
- Each Post has:
  - A **Custom Field** called `price`
  - A manual "Add to Cart" button linking to:
    ```
    /?add_to_cart=POST-ID
    ```
    (Example: `/urbanshop2025/?add_to_cart=30`)

### Pages
- **Shop**: Displays products (menu link)
- **Cart**: Shows cart content (`[show_cart]` shortcode)
- **Checkout**: Shows checkout (`[show_checkout]` shortcode)

##  How It Was Built
1. WordPress installed with TwentyTwentyFive theme.
2. 12 products created as simple Posts.
3. `price` custom field added to each post.
4. "Add to Cart" button manually placed inside post content.
5. 3 Pages created: Shop, Cart, and Checkout.
6. `functions.php` updated to:
   - Manage session-based cart
   - Handle adding/removing items
   - Display Cart and Checkout pages via shortcodes

## Technical Details
- PHP sessions used for storing cart.
- No plugins.
- Cart cleared after checkout.
- Minimalistic shop. 

---

