@extends('layouts.before_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/auth.css') }}">
@endsection

@section('main')
<div class="title">メール送信完了</div>
<div class="verify-message">
  <p>ご本人様確認のため、ご登録いただいたメールアドレスに、本登録のご案内メールが届きます。</p>
  <p>そちらに記載されているURLにアクセスし、本登録を完了させてください。</p>
</div>
@endsection