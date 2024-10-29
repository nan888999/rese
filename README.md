# 飲食店予約サービスRese
飲食店の予約サービスシステムです。
<img width="1710" alt="rese_index" src="https://github.com/user-attachments/assets/902282a3-5a36-4dd8-8797-014ad0ab5ad4">

## 作成した目的
ある企業のグループ会社の飲食店予約をするために作成しました。

## アプリケーションURL
- 開発環境：http://localhost/
- phpMyAdmin : http://localhost:8080/
- mailhog : http://localhost:8025/

## 機能一覧
- メールアドレス認証・会員登録
- ログイン
- ログアウト
- ユーザー情報取得
- ユーザー飲食店お気に入り一覧取得
- ユーザー飲食店予約情報取得
- 飲食店一覧取得
- 飲食店詳細取得
- 飲食店お気に入り追加・削除
- 飲食店予約情報追加・変更・削除
- エリア検索
- ジャンル検索
- 店名検索
- 飲食店評価機能
- 店舗追加・編集機能(店舗代表者権限)
- 店舗ごとの予約情報取得機能（店舗代表者権限）
- 店舗代表者作成機能（管理者権限）
- 利用者への一斉メール送信機能（管理者権限）
- スケジューラー
  - 認証メールアドレス送信後、60分以内に会員登録されなければusersテーブルよりユーザーを自動削除
  - 毎朝7時に本日の予約があるユーザーにリマインダーメール送信

## 使用技術
- PHP 7.4.9
- Laravel Framework 8.83.27
- MySQL  8.0.26

## テーブル設計
<img width="1292" alt="rese_tables" src="https://github.com/user-attachments/assets/71a72ab1-a268-4541-bb47-5102107ad3d6">

## ER図
<img width="878" alt="Rese_ER" src="https://github.com/user-attachments/assets/9c4a0ef4-93db-4fcb-a9f0-90fcd24d7e62">

## 環境構築
Dockerビルド
1. git clone リンク
2. docker-compose up -d —build

Laravel環境構築
1. docker-compose exec php bash
2. composer install
3. .env.exampleファイルから.envを作成し、環境変数を変更<br>
    mailhog設定は下記を参照<br>
        MAIL_MAILER=smtp<br>
        MAIL_HOST=mail<br>
        MAIL_PORT=1025<br>
        MAIL_USERNAME=null<br>
        MAIL_PASSWORD=null<br>
        MAIL_ENCRYPTION=null<br>
        MAIL_FROM_ADDRESS=rese@example.com<br>
        MAIL_FROM_NAME="${APP_NAME}"<br>
4. php artisan:key generate
5. php artisan migrate
6. php artisan schedule:work（スケジューラー起動）

## テストユーザー
- メールアドレス
  - 管理者権限「admin@test」
  - 店舗代表者「shop@test」
  - 一般利用者「user@test」
- パスワード「password」(全アカウント共通)
