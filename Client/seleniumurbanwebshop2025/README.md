# Selenium Automation for UrbanShop 2025

## Purpose
Automate the testing of UrbanShop 2025 by:
- Visiting random products
- Adding 2-3 products to the cart
- Visiting the Cart and Checkout pages
- Repeating the flow multiple times (for load/energy testing)

## How to Run

1. Install Selenium:
   ```bash
   pip3 install selenium
   ```

2. Install ChromeDriver compatible with your Chrome browser.

3. Clone this repo and run:
   ```bash
   python3 main.py
   ```

---

## Configuration (main.py)

```python
URL = "http://localhost:8888/urbanshop2025/"
NUM_PRODUCTS = 2  # Number of products to add to cart per loop
LOOPS = 5         # How many times to repeat
DELAY = 2         # Delay (seconds) between steps
```

---

## Important Notes
- Selenium clicks inside individual **product pages**.
- Products must have manual "Add to Cart" buttons inside posts.
- Cart contents are cleared after every checkout.
- If "Add to Cart" button is missing, Selenium skips that product.

---

# Summary
|   |   |
|---|---|
| Products  | 12 posts |
| Pages | Shop, Cart, Checkout |
| Shortcodes | `[show_cart]`, `[show_checkout]` |
| Testing | Selenium based navigation |

---

