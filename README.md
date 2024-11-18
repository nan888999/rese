# 飲食店予約サービスRese
飲食店の予約サービスシステムです。
![newUI](https://github.com/user-attachments/assets/68e337d2-748d-409f-a264-2e708814c206)

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
- QRコードを読み取ることで、本日のショップごとの予約状況表示（店舗代表者権限）
- スケジューラー
  - 認証メールアドレス送信後、60分以内に会員登録されなければusersテーブルよりユーザーを自動削除
  - 毎朝7時に本日の予約があるユーザーにリマインダーメール送信
- 口コミ機能
  - 一般利用者は口コミ投稿及び自身の口コミの編集・削除が可能
  - 管理者は全ての口コミを削除可能
- 店舗一覧ソート機能
- CSVインポート機能（管理者権限）

## 使用技術
- PHP 8.3.13
- Laravel Framework 8.83.27
- MySQL  8.0.26

## テーブル設計
![newTables](https://github.com/user-attachments/assets/6dba087f-30d4-4703-b236-3863c35d8272)

## ER図
![newER](https://github.com/user-attachments/assets/9bcf1b8b-fb30-468c-940d-d46af36e2e6c)

## 環境構築
### Dockerビルド
1. git clone リンク
2. docker compose up -d --build

### Laravel環境構築
1. docker-compose exec php bash
2. composer install
3. composer require simplesoftwareio/simple-qrcode
4. .env.exampleファイルから.envを作成し、環境変数を変更<br>
    mailhog設定は下記を参照<br>
        MAIL_MAILER=smtp<br>
        MAIL_HOST=mail<br>
        MAIL_PORT=1025<br>
        MAIL_USERNAME=null<br>
        MAIL_PASSWORD=null<br>
        MAIL_ENCRYPTION=null<br>
        MAIL_FROM_ADDRESS=rese@example.com<br>
        MAIL_FROM_NAME="${APP_NAME}"<br>
5. php artisan:key generate
6. php artisan migrate
7. php artisan schedule:work（スケジューラー起動）

## テストユーザー
- メールアドレス
  - 管理者権限「admin@test」
  - 店舗代表者「shop@test」
  - 一般利用者「user@test」
- パスワード「password」(全アカウント共通)

## CSVインポート機能について
下記のようなCSVファイルを作成しインポートすることで、店舗作成をすることができます。<br>
エリアIDとジャンルIDはareasテーブルとcategoriesテーブルのIDにそれぞれ対応します。<br>
![csv_example](https://github.com/user-attachments/assets/f9be6c99-21ba-4ae3-8fa3-9f2a6b34b22f)
