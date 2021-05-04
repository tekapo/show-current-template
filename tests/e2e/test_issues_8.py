# https://github.com/tekapo/show-current-template/issues/8
# https://wordpress.org/support/topic/js-error-when-no-admin-bar/

# How to reproduce
#  open https://wp.plugin.sct.test/wp-admin/profile.php
#  uncheck checkbox input#admin_bar_front
#  open https://wp.plugin.sct.test/
#  no js error occurs.

# So, to test this issue, uncheck the checkbox and confirm not output show-current-template/assets/js/replace.js


from playwright.sync_api import Page
import pytest


@pytest.fixture()
def wp_login(page: Page):
    """
    Log in local WP admin.
    """
    page.goto("https://wp.plugin.sct.test/wp-login.php")
    page.fill('input[name="log"]', "tai")
    page.fill('input[name="pwd"]', "tai")
    with page.expect_navigation():
        page.click("#wp-submit")


@pytest.fixture()
def uncheck_toolbar(page: Page):
    """
    uncheck input[name="admin_bar_front"]
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
    check input[name="admin_bar_front"]
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
    assert substring in jsSrc
