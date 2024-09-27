@extends('layouts.after_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
@endsection

@section('main')
<div class="contents">
  <div class="reservation-list">
    <h2>予約状況</h2>
    <form action="/reservation_confirm" method="post">
      @csrf
      <input type="hidden" name="shop_id" value="{{ $shop->id }}">
      <button class="remove-btn" type="submit"></button>
    </form>
  <div class="favorite-list">
    <h2>{{ $user['name'] ?? '' }}さん</h2>
    <div class="shop_img">
      <img src="{{ $shop['img_url'] }}" alt="{{ $shop['name'] }}">
    </div>
    <div class="shop_tags">
      #{{ $shop->area->name }}
      #{{ $shop->category->name }}
    </div>
    <div class="shop_detail">
      {{ $shop['detail'] }}
    </div>
</div>
@endsection

@section('script')
<script type="text/javascript">
$(function(){
  $("#submit_select").change(function(){
    $("#submit_form").submit();
  });
});
</script>
@endsection