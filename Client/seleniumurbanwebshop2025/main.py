from selenium import webdriver
from selenium.webdriver.common.by import By
import time
import random

# --- SETTINGS ---
BASE_URL = "http://localhost:8888/urbanshop2025"
PRODUCTS_PAGE = BASE_URL + "/shop/"
NUMBER_OF_PRODUCTS_TO_ADD = 3
LOOPS = 1
DELAY_BETWEEN_ACTIONS = 2  # seconds

# --- Setup driver ---
driver = webdriver.Chrome()
driver.get(PRODUCTS_PAGE)
time.sleep(DELAY_BETWEEN_ACTIONS)

for loop in range(LOOPS):
    print(f"\n🔁 Loop {loop + 1} of {LOOPS}")

    # Find all product links (filter real products only)
    links = driver.find_elements(By.TAG_NAME, "a")
    product_links = []

    for link in links:
        href = link.get_attribute("href")
        if href and "/urbanshop2025/" in href and not any(x in href for x in ["/cart", "/checkout", "?add_to_cart="]):
            product_links.append(href)

    product_links = list(set(product_links))  # Unique
    print(f"🛍️ Found {len(product_links)} products")

    # Pick random products
    selected = random.sample(product_links, NUMBER_OF_PRODUCTS_TO_ADD)
    print(f"🎯 Selected: {selected}")

    for product_url in selected:
        driver.get(product_url)
        time.sleep(DELAY_BETWEEN_ACTIONS)

        try:
            # Look for a link with ?add_to_cart
            add_to_cart_link = driver.find_element(By.XPATH, "//a[contains(@href, '?add_to_cart=')]")
            add_to_cart_link.click()
            print(f"✅ Added: {product_url}")
        except Exception as e:
            print(f"⚠️ Could not add product from {product_url}: {str(e)}")

        # Go back to Shop
        driver.get(PRODUCTS_PAGE)
        time.sleep(DELAY_BETWEEN_ACTIONS)

    # Go to Cart
    driver.get(BASE_URL + "/cart/")
    print("🛒 Visited Cart")
    time.sleep(DELAY_BETWEEN_ACTIONS)

    # Go to Checkout
    driver.get(BASE_URL + "/checkout/")
    print("💳 Visited Checkout")
    time.sleep(DELAY_BETWEEN_ACTIONS)

    # Clear Cart (optional)
    driver.get(BASE_URL + "/?clear_cart=1")
    print("🧹 Cleared Cart")
    time.sleep(DELAY_BETWEEN_ACTIONS)

driver.quit()
print("\n🏁 Finished all loops.")