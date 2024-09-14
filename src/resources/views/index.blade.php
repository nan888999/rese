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
      <div class="shop_name">
        {{ $shop->name ?? '' }}
      </div>
      <div class="shop_tag">
        #{{ $shop->area ?? '' }}
        #{{ $shop->category ?? ''}}
      </div>
      <div class="shop_detail">
        <form action="" method="post">
          <input type="hidden" name="shop_id" value="{{ $shop->id }}">
          <button type="submit">詳しくみる</button>
        </form>
      </div>
      <div class="favorite">
        <form action="/favorite" method="post">
          <button type="submit">heart</button>
        </form>
      </div>
    </div>
  @endforeach
</div>
@endsection
