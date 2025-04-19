

# Urban Shop — Custom WordPress Theme

This project is a simple webshop built using WordPress **Posts as Products**, with a **custom lightweight theme** made from scratch.

It uses:
- Posts to create Products
- Pages to create Shop, Cart, and Checkout flows
- PHP Sessions to handle the cart (no plugins required)

---

## Step-by-Step Setup Guide

Follow these steps **in this exact order** to avoid errors (especially the WordPress JSON error).

### 1. Set Permalinks
Before creating anything:
- Go to **Settings → Permalinks**
- Choose **"Post name"** structure
- Click **Save Changes**

This ensures nice URLs like `/shop` and `/cart`.

---

### 2. Create Products (Posts)

- Go to **Posts → Add New**
- Create posts for your products
- Set a **Featured Image** for each product
- Add a **Custom Field** called `price` with the product's price (DKK)

For this project, 12 products were created - remember to upload the images before you activate your theme:
- Vintage Leather Backpack
- Minimalist Desk Lamp
- Handmade Ceramic Mug
- Succulent Plant Set
- Wireless Bluetooth Speaker
- Artisan Scented Candles
- Canvas Wall Art - Ocean Waves
- Fitness Resistance Bands Set
- Eco-Friendly Tote Bag
- Classic Aviator Sunglasses
- Handwoven Throw Blanket
- Portable Espresso Maker

---

### 3. Create Pages

Go to **Pages → Add New** and create:

| Page Title | Template to Assign |
|:---|:---|
| Shop | `Shop` template (page-all-posts.php) |
| Cart | `Cart` template (page-cart.php) |
| Checkout | `Checkout` template (page-checkout.php) |

⚡ Important: Assign the correct template under **Page Attributes → Template** when creating each page.

---

### 4. Activate the Urban Shop Theme

Now you are ready to:
- Go to **Appearance → Themes**
- Activate **Urban Shop** (the custom theme you built)

After activation, everything should work immediately:
- `/shop` shows all your products
- `/cart` shows your cart with remove options
- `/checkout` shows a final static list and thank-you message

---

## ⚠️ Very Important Note

**You must create your Posts (products) and Pages (shop, cart, checkout) _before_ activating the custom theme.**

If you activate the theme without existing Posts and Pages, WordPress may show:

The response is not a valid JSON response.

This happens because the theme expects posts and pages to exist for dynamic content.

✅ **To avoid this error:**
1. Set Permalinks
2. Create Posts (Products)
3. Create Pages (Shop, Cart, Checkout)
4. Only then activate the theme

---

## 🛠 Folder Structure

urban-shop/

├── functions.php
├── header.php
├── footer.php
├── index.php
├── page-all-posts.php  (Shop page)
├── page-cart.php       (Cart page)
├── page-checkout.php   (Checkout page)
├── single.php          (Single product page)
├── style.css
└── README.md

---

## Features
- Add to Cart from Shop and Product pages
- Remove items from Cart
- Checkout page with final product list
- Total price calculation
- Minimal custom styling
- No external plugins needed

---

## Future Improvements (Ideas)
- Add quantity controls (change item amounts)
- Add payment integration (e.g., Stripe or PayPal)
- Improve styling with CSS Grid or Flexbox
- Add success messages on "Add to Cart"

---

Created with ❤️ by [Christian](https://github.com/criller-github) and [Nilma](https://github.com/Nilma) 
Urban Shop — 2025



