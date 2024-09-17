@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('main')
<div class="content">
  @foreach($shops as $shop)
    <div class="shop_card">
      <div class="shop_img">
        <img src="{{ $shop->img_url ?? '画像がありません' }}" alt="{{ $shop->name ?? '' }}">
      </div>
      <div class="shop_contents">
        <div class="shop_name">
          {{ $shop->name ?? '' }}
        </div>
        <div class="shop_tag">
          #{{ $shop->area ?? '' }}
          #{{ $shop->category ?? ''}}
        </div>
        <div class="form_buttons">
          <div class="shop_detail">
            <form action="" method="post" value="{{ $shop->id }}">
              <input type="hidden" name="shop_id" value="{{ $shop->id }}">
              <button class="shop_detail_button" type="submit">詳しくみる</button>
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
