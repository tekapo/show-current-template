import { expect, test } from '@playwright/test';

test('test of show_template_file_name_on_top', async ({ page }) => {
	await page.goto('https://wp.plugin.sct.test/wp-login.php');
	// await page.getByLabel('ツールバー').getByRole('link', { name: 'ログアウト' }).click();
	// await page.getByLabel('ユーザー名またはメールアドレス').click();
	await page.getByLabel('ユーザー名またはメールアドレス').fill('test');
	// await page.getByLabel('パスワード', { exact: true }).click();
	await page.getByLabel('パスワード', { exact: true }).fill('test');
	await page.getByRole('button', { name: 'ログイン' }).click();
	// Takes a screenshot named example.png
	await page.screenshot({ path: `example.png` });
	// Record a video of the test.
	// await page.video().path();
	await page.getByRole('link', { name: 'サイトを表示' }).click();
	// locate #wp-admin-bar-show_template_file_name_on_top and to have text "Template: index.php"

	// await page.locator(
	// 	'#tsf > div:nth-child(2) > div.A8SBwf > div.RNNXgb > div > div.a4bIc > input'
	// ).click();
	const sctTitle = await page.locator('#wp-admin-bar-show_template_file_name_on_top').innerText();

	expect(sctTitle).toBe('Template: index.php');
	// await expect(page).toHaveURL(/.*wp.plugin.sct.test/);
	// await page.getByText('Template: index.php').click();
	// await page.getByRole('link', { name: 'テーマ', exact: true }).click();
	// await page.getByLabel('Twenty Twenty-Two を有効化').click();
	// await page.getByLabel('ツールバー').getByRole('link', { name: 'サイトを表示' }).click();
	// await page.getByText('Template: !!Block Theme!!').click();
	// await page.getByRole('link', { name: 'テーマ', exact: true }).click();
	// await page.getByLabel('Twenty Twenty-Three を有効化').click();
	// await page.getByLabel('ツールバー').getByRole('link', { name: 'サイトを表示' }).click();
	// await page.getByText('Template: !!Block Theme!!').click();
});
