# Developer Documentation / 開発者向けドキュメント

## English (English)

This plugin uses [Playwright](https://playwright.dev/) and [@wordpress/env](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/) for End-to-End (E2E) testing.

### Prerequisites

- [Node.js](https://nodejs.org/)
- [Docker](https://www.docker.com/) (required for `wp-env`)

### Setup

Install the necessary dependencies:

```bash
npm install
```

### Running E2E Tests

To run the full E2E test suite (which handles starting the environment automatically):

```bash
npm run test:e2e
```

### Manual Verification

If you prefer to run the environment manually to inspect the site:

1. Start the local WordPress environment:

    ```bash
    npm run env:start
    ```

2. Open `http://localhost:8888` in your browser.
3. Log in with the following credentials:
    - **Username:** `admin`
    - **Password:** `password`
4. Ensure a Classic Theme (e.g., Twenty Twenty-One) is active, as Block Themes are not supported by this plugin.
5. When finished, stop the environment:

    ```bash
    npm run env:stop
    ```

***

## 日本語 (Japanese)

このプラグインは End-to-End (E2E) テストに [Playwright](https://playwright.dev/) と [@wordpress/env](https://developer.wordpress.org/block-editor/reference-guides/packages/packages-env/) を使用しています。

### 前提条件

- [Node.js](https://nodejs.org/)
- [Docker](https://www.docker.com/) (`wp-env`の使用に必要です)

### セットアップ

必要な依存関係をインストールします：

```bash
npm install
```

### E2Eテストの実行

環境の起動からテスト実行までを自動で行う完全なE2Eテストスイートを実行するには：

```bash
npm run test:e2e
```

### 手動検証

手動で環境を起動してサイトを確認したい場合：

1. ローカルWordPress環境を起動します：

    ```bash
    npm run env:start
    ```

2. ブラウザで `http://localhost:8888` を開きます。
3. 以下の認証情報でログインします：
    - **ユーザー名:** `admin`
    - **パスワード:** `password`
4. クラシックテーマ（例：Twenty Twenty-One）が有効になっていることを確認してください。ブロックテーマはこのプラグインではサポートされていません。
5. 終了したら、環境を停止します：

    ```bash
    npm run env:stop
    ```
