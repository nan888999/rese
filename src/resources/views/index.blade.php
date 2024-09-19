@extends('layouts.after_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
@foreach($shops as $shop)
  <div class="shop-card">
    <div class="shop__img">
      <img src="{{ $shop->img_url ?? '画像がありません' }}" alt="{{ $shop->name ?? '' }}">
    </div>
    <div class="shop__contents">
      <div class="shop__name">
        {{ $shop['name'] ?? '' }}
      </div>
      <div class="shop__tags">
        #{{ $shop->area->name ?? '' }}
        #{{ $shop->category->name ?? ''}}
      </div>
      <div class="form-buttons">
        <div class="form-buttons__detail">
          <form action="/shop_details" method="get">
            @csrf
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            <button class="common-btn" type="submit">詳しくみる</button>
          </form>
        </div>
        <div class="form-buttons__favorite">
          <form action="/favorite" method="post">
            <button class="favorite-btn" type="submit"></button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endforeach
@endsection
