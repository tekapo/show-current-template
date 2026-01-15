import { expect, test } from '@playwright/test';

test.describe('Show Current Template', () => {
    test('show template on front page', async ({ page }) => {
        await page.goto('/');
        await expect(page.locator('#wpadminbar')).toBeVisible();
        await expect(page.locator('#wp-admin-bar-show_template_file_name_on_top')).toContainText('Template: index.php');
    });

    test('show template on single post', async ({ page }) => {
        await page.goto('/?p=1');
        await expect(page.locator('#wp-admin-bar-show_template_file_name_on_top')).toContainText('Template: single.php');
    });

    test('show template on page', async ({ page }) => {
        await page.goto('/?page_id=2');
        await expect(page.locator('#wp-admin-bar-show_template_file_name_on_top')).toContainText('Template: page.php');
    });
});
