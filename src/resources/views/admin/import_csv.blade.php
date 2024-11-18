@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/import_csv.css') }}">
@endsection

@section('main')
<h2 class="title">Import CSV</h2>
<form action="/admin/import_csv" class="import-form" method="post" enctype="multipart/form-data">
  @csrf
  <div class="comment">
    <p>CSVファイル内の1行目はヘッダーにしてください。<br>
    左から「店舗名」「エリアID」「ジャンルID」「店舗概要」「画像URL」です。</p>
    <p>エリア・ジャンルIDは以下の通りです。</p>
    <p><h3 class="subtitle">【エリアID】</h3>
    1：東京都<br>
    2：大阪府<br>
    3：福岡県</p>
    <p><h3 class="subtitle">【ジャンルID】</h3>
    1：イタリアン<br>
    2：ラーメン<br>
    3：居酒屋<br>
    4：寿司<br>
    5：焼肉</p>
  </div>
  <input class="import-csv" type="file" name="file" accept="text/csv">
  <div class="form__error">
    @error('file')
      {{ $message }}
    @enderror
@if ($errors->has('upload_errors'))
    @foreach ($errors->get('upload_errors') as $error)
      {{ $error }}<br>
    @endforeach
@endif

  </div>
  <div class="button-area">
    <button type="submit" class="common-btn">送信</button>
  </div>

</form>
@endsection