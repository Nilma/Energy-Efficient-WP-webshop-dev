# Directory structure I will prepare for you:
# 
# urban-shop-selenium-test/
# ├─ README.md
# ├─ requirements.txt
# └─ test_urban_shop.py

# Let's start with the files:

# ========================
# File: requirements.txt
# ========================
selenium


# ========================
# File: README.md
# ========================
"""
# Urban Shop Selenium Test

This project automatically tests the Urban Shop custom WordPress theme using Selenium.
It simulates a real user:
- Visiting the shop
- Adding 2 random products to cart
- Visiting the cart
- Visiting the checkout
- Resetting the cart

## Setup

1. Install Python 3.12+
2. Install pip (already installed in most cases)
3. Install requirements:

```bash
pip3 install -r requirements.txt
```

4. Install ChromeDriver (matching your Chrome browser version):

```bash
brew install chromedriver
```

## Running the Test

Edit `BASE_URL` inside `test_urban_shop.py` if needed.

Then run:

```bash
python3 test_urban_shop.py
```


## Notes
- Make sure your Urban Shop WordPress site is running.
- Adjust `REPEAT_TIMES` to simulate more test cycles.
- Default delay between actions is 2 seconds.

---

Created with ❤️ for Urban Shop Testing 2025.
"""


# ========================
# File: test_urban_shop.py
# ========================
from selenium import webdriver
from selenium.webdriver.common.by import By
from selenium.webdriver.chrome.service import Service
import random
import time

# Configuration
BASE_URL = "http://localhost:8888/urbanshop"  # Change this to your local server URL
REPEAT_TIMES = 10  # How many times to repeat the test
PRODUCTS_TO_ADD = 2  # How many products to add each cycle
DELAY_BETWEEN_ACTIONS = 2  # seconds

# Setup WebDriver
service = Service('/path/to/chromedriver')  # <-- Change path if needed
options = webdriver.ChromeOptions()
options.add_argument('--start-maximized')
# options.add_argument('--headless')  # Uncomment for headless mode (no visible browser)
driver = webdriver.Chrome(service=service, options=options)

try:
    for cycle in range(REPEAT_TIMES):
        print(f"\n--- Test cycle {cycle + 1} ---")

        # 1. Visit Shop page
        driver.get(f"{BASE_URL}/shop")
        time.sleep(DELAY_BETWEEN_ACTIONS)

        # 2. Find all 'Add to Cart' buttons
        add_to_cart_buttons = driver.find_elements(By.LINK_TEXT, "Tilføj til Kurv")
        if not add_to_cart_buttons:
            print("No products found!")
            break

        # 3. Randomly select products
        selected_buttons = random.sample(add_to_cart_buttons, min(PRODUCTS_TO_ADD, len(add_to_cart_buttons)))
        for button in selected_buttons:
            button.click()
            time.sleep(DELAY_BETWEEN_ACTIONS)

        # 4. Visit Cart page
        driver.get(f"{BASE_URL}/cart")
        time.sleep(DELAY_BETWEEN_ACTIONS)

        # 5. Visit Checkout page
        driver.get(f"{BASE_URL}/checkout")
        time.sleep(DELAY_BETWEEN_ACTIONS)

        # 6. Clear session (reset cart)
        driver.delete_all_cookies()
        time.sleep(DELAY_BETWEEN_ACTIONS)

finally:
    driver.quit()
    print("\nTest completed.")


# ========================
# End of files.
# ========================

# Quick Instructions:
# 1. Save this in a folder urban-shop-selenium-test/
# 2. Run 'pip3 install -r requirements.txt'
# 3. Update '/path/to/chromedriver' to your real chromedriver path
# 4. Run 'python3 test_urban_shop.py'

# Optional: You can adjust REPEAT_TIMES, DELAY_BETWEEN_ACTIONS, etc. easily.

# Let me know if you also want me to show how to LOG each cycle to a CSV for energy tracking 🔹📊!
