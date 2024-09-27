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
          @if (in_array($shop->id, $favorite_shops))
            <form action="/unfavorite" method="post">
              @csrf
              <input type="hidden" name="shop_id" value="{{ $shop->id }}">
                <button class="favorite-btn--on" type="submit"></button>
            </form>
          @else
            <form action="/favorite" method="post">
              @csrf
              <input type="hidden" name="shop_id" value="{{ $shop->id }}">
              <button class="favorite-btn--off" type="submit"></button>
            </form>
          @endif
        </div>
      </div>
    </div>
  </div>
@endforeach
@endsection
