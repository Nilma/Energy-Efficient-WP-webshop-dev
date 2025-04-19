from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
import random
import csv
import time 
from datetime import datetime


# Configuration
BASE_URL = "http://localhost:8888/urbanshop"  # Change this to your URL if needed
REPEAT_TIMES = 1  # How many times to repeat the full test
PRODUCTS_TO_ADD = 2  # How many products to add each cycle
DELAY_BETWEEN_ACTIONS = 2  # seconds

# Setup WebDriver. Use correct path to chromedriver
# Note: Make sure to have the correct version of ChromeDriver installed
# and that it matches your Chrome version.
# You can download it from https://sites.google.com/chromium.org/driver/ or use Homebrew:
# brew install chromedriver
service = Service('/opt/homebrew/bin/chromedriver')  # Make sure this is correct
options = webdriver.ChromeOptions()
options.add_argument('--start-maximized')
# options.add_argument('--headless')  # Uncomment if you want faster (invisible) testing
driver = webdriver.Chrome(service=service, options=options)
LOG_FILE = "urban_shop_log.csv"

# Setup CSV Logging
with open(LOG_FILE, mode='w', newline='') as file:
    writer = csv.writer(file)
    # Write the header
    writer.writerow(["Timestamp", "Cycle", "Action", "Product Number"])

    try:
        for cycle in range(REPEAT_TIMES):
            print(f"\n--- Test cycle {cycle + 1} ---")

            # 1. Visit Shop page
            driver.get(f"{BASE_URL}/shop")
            time.sleep(DELAY_BETWEEN_ACTIONS)

            # 2. Find all product links (titles)
            product_links = driver.find_elements(By.CSS_SELECTOR, ".post-title a")

            if not product_links:
                print("No products found on shop page!")
                break

            # 3. Browse (click and view) every product once
            total_products = len(product_links)
            for i in range(total_products):
                fresh_links = driver.find_elements(By.CSS_SELECTOR, ".post-title a")
                fresh_links[i].click()
                print(f"Browsed product {i + 1}.")
                time.sleep(DELAY_BETWEEN_ACTIONS)

                # Go back to shop after viewing each product
                driver.back()
                time.sleep(DELAY_BETWEEN_ACTIONS)

            # 4. Now randomly pick products to add to cart
            indexes_to_add = random.sample(range(total_products), min(PRODUCTS_TO_ADD, total_products))

            for index in indexes_to_add:
                fresh_links = driver.find_elements(By.CSS_SELECTOR, ".post-title a")
                selected_product = fresh_links[index]

                selected_product.click()
                print(f"Opened product {index + 1} for adding to cart.")
                time.sleep(DELAY_BETWEEN_ACTIONS)

                try:
                    add_to_cart_button = driver.find_element(By.LINK_TEXT, "Tilføj til Kurv")
                    add_to_cart_button.click()
                    print(f"Added product {index + 1} to cart.")
                except Exception as e:
                    print(f"Failed to add product {index + 1}: {e}")

                time.sleep(DELAY_BETWEEN_ACTIONS)

                driver.get(f"{BASE_URL}/shop")
                time.sleep(DELAY_BETWEEN_ACTIONS)

            # 5. Visit Cart
            driver.get(f"{BASE_URL}/cart")
            time.sleep(DELAY_BETWEEN_ACTIONS)

            # 6. Visit Checkout
            driver.get(f"{BASE_URL}/checkout")
            time.sleep(DELAY_BETWEEN_ACTIONS)

            # 7. Reset session
            driver.delete_all_cookies()
            print("Cart cleared.\n")
            time.sleep(DELAY_BETWEEN_ACTIONS)

    finally:
        driver.quit()
        print("\nTest completed successfully.")