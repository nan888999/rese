@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('header')
<div class="header_title">Rese</div>
@endsection

@section('main')
<div class="contents">
  @foreach($shops as $shop)
    <div class="shop_card">
      <div class="shop_img">
        <img src="{{ $shop->img_url ?? '画像がありません' }}" alt="{{ $shop->name ?? '' }}">
      </div>
      <div class="shop_contents">
        <div class="shop_name">
          {{ $shop['name'] ?? '' }}
        </div>
        <div class="shop_tag">
          #{{ $shop->area->name ?? '' }}
          #{{ $shop->category->name ?? ''}}
        </div>
        <div class="form_buttons">
          <div class="shop_detail">
            <form action="/shop_details" method="get">
              @csrf
              <input type="hidden" name="shop_id" value="{{ $shop->id }}">
              <button class="common_btn" type="submit">詳しくみる</button>
            </form>
          </div>
          <div class="favorite">
            <form action="/favorite" method="post">
              <button class="favorite_button" type="submit"></button>
            </form>
          </div>
        </div>
      </div>
    </div>
  @endforeach
</div>
@endsection
