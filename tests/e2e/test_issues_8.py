# https://github.com/tekapo/show-current-template/issues/8
# https://wordpress.org/support/topic/js-error-when-no-admin-bar/

# How to reproduce
#  open https://wp.plugin.sct.test/wp-admin/profile.php
#  uncheck checkbox input#admin_bar_front
#  open https://wp.plugin.sct.test/
#  no js error occoured.

# So, to test this issue, uncheck the checkbox and confirm not output show-current-template/assets/js/replace.js


# When you disable "Show Toolbar when viewing site" option, JavaScript error occurs.
# https://wp.plugin.sct.test/wp-admin/profile.php

# from playwright.sync_api import sync_playwright

# def run(playwright):
#     browser = playwright.chromium.launch(headless=False)
#     context = browser.new_context()

#     # Open new page
#     page = context.new_page()

#     # Go to https://wp.plugin.sct.test/wp-login.php?redirect_to=https%3A%2F%2Fwp.plugin.sct.test%2Fwp-admin%2Fprofile.php&reauth=1
#     page.goto("https://wp.plugin.sct.test/wp-login.php?redirect_to=https%3A%2F%2Fwp.plugin.sct.test%2Fwp-admin%2Fprofile.php&reauth=1")

#     # Click input[name="log"]
#     page.click("input[name=\"log\"]")

#     # Fill input[name="log"]
#     page.fill("input[name=\"log\"]", "tai")

#     # Press Tab
#     page.press("input[name=\"log\"]", "Tab")

#     # Fill input[name="pwd"]
#     page.fill("input[name=\"pwd\"]", "tai")

#     # Press Tab
#     page.press("input[name=\"pwd\"]", "Tab")

#     # Press Tab
#     page.press("[aria-label=\"Show password\"]", "Tab")

#     # Check input[name="rememberme"]
#     page.check("input[name=\"rememberme\"]")

#     # Press Tab
#     page.press("input[name=\"rememberme\"]", "Tab")

#     # Press Enter
#     # with page.expect_navigation(url="https://wp.plugin.sct.test/wp-admin/profile.php"):
#     with page.expect_navigation():
#         page.press("text=Log In", "Enter")
#     # assert page.url == "https://wp.plugin.sct.test/wp-admin/profile.php"

#     # Uncheck input[name="admin_bar_front"]
#     page.uncheck("input[name=\"admin_bar_front\"]")

#     # Click input:has-text("Update Profile")
#     # with page.expect_navigation(url="https://wp.plugin.sct.test/wp-admin/profile.php"):
#     with page.expect_navigation():
#         page.click("input:has-text(\"Update Profile\")")
#     # assert page.url == "https://wp.plugin.sct.test/wp-admin/profile.php?updated=1"

#     # Click text=Visit Site
#     page.click("text=Visit Site")
#     # assert page.url == "https://wp.plugin.sct.test/"

#     # ---------------------
#     context.close()
#     browser.close()

# with sync_playwright() as playwright:
#     run(playwright)

from playwright.sync_api import Page
import pytest


@pytest.fixture()
def wp_login(page: Page):
    """
    docstring
    """
    page.goto("https://wp.plugin.sct.test/wp-login.php")
    page.fill('input[name="log"]', "tai")
    page.fill('input[name="pwd"]', "tai")
    with page.expect_navigation():
        page.click("#wp-submit")


@pytest.fixture()
def uncheck_toolbar(page: Page):
    """
    docstring
    """
    page.goto("https://wp.plugin.sct.test/wp-admin/profile.php")
    page.fill('input[name="log"]', "tai")
    page.fill('input[name="pwd"]', "tai")
    with page.expect_navigation():
        page.click("#wp-submit")
    page.uncheck('input[name="admin_bar_front"]')
    page.click("#submit")


@pytest.fixture()
def check_toolbar(page: Page):
    """
    docstring
    """
    page.goto("https://wp.plugin.sct.test/wp-admin/profile.php")
    page.fill('input[name="log"]', "tai")
    page.fill('input[name="pwd"]', "tai")
    with page.expect_navigation():
        page.click("#wp-submit")
    page.check('input[name="admin_bar_front"]')
    page.click("#submit")


def test_not_output_replace_js(page: Page, uncheck_toolbar):
    """
    replace.jsが出力されていないことを確認する。
    """

    page.hover("#wp-admin-bar-site-name")
    page.click("#wp-admin-bar-view-site a")
    jsSrc = page.query_selector("#current-template-js-js")
    print("jsSrc::")
    print(jsSrc)
    assert jsSrc is None


def test_output_replace_js(page: Page, check_toolbar):
    """
    replace.jsが出力されていることを確認する。
    """

    page.hover("#wp-admin-bar-site-name")
    page.click("#wp-admin-bar-view-site a")
    jsSrc = page.get_attribute("#current-template-js-js", "src")
    substring = "show-current-template/assets/js/replace.js"
    # print(jsSrc)
    assert substring in jsSrc
