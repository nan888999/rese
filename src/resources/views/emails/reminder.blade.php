<!DOCTYPE html>
<html lang="ja">
<style>
  body {
    margin: 20px auto;
    max-width: 1020px;
  }

  h1 {
    font-size: 16px;
  }
</style>

<body>
  <h1>ご予約のお知らせ</h1>
  <p>本日以下の予約があります。<br>
    ご来店をお待ちしております。</p>
  <p>予約店名：{{ $shop_name }}</p>
  <p>時刻：{{ $time }}</p>
</body>
</html>