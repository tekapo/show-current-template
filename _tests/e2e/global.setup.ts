import { expect, test as setup } from '@playwright/test';
import path from 'path';

const STORAGE_STATE = path.join(__dirname, '../playwright/.auth/user.json');

setup('login', async ({ page }) => {
    await page.goto('/wp-login.php');

    const tryLogin = async (user: string, pass: string) => {
        await page.locator('#user_login').fill(user);
        await page.locator('#user_pass').fill(pass);
        await page.locator('#wp-submit').click();
    };

    await tryLogin('admin', 'password');
    await page.waitForLoadState('domcontentloaded');

    if (page.url().includes('wp-admin')) {
        // Success
    } else if (await page.locator('#login_error').isVisible()) {
        await tryLogin('tai', 'tai');
        await page.waitForURL(/wp-admin/);
    } else {
        // Retry waiting for URL if redirect is slow
        await page.waitForURL(/wp-admin/);
    }

    await expect(page.locator('#wp-admin-bar-my-account')).toBeVisible();

    await page.context().storageState({ path: STORAGE_STATE });
});
