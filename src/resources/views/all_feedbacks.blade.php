@extends('layouts.after_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/feedback.css') }}">
@endsection

@section('main')
<div class="contents-flex">
  <div class="shop-view">
    <div class="shop-card">
      <div class="shop__img-area">
        <img class="shop__img-body" src="{{ $shop->img_url ?? '' }}" alt="
        @if($shop->img_url) {{ $shop->name ?? '' }}
        @else No Image @endif
        ">
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
            @if ($favorite_shop)
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
  </div>

  <div class="all-feedbacks">
    <h1 class="page-title">口コミ一覧</h1>
    @if (!$feedbacks)
      <p>口コミはありません</p>
    @endif
    @foreach ($feedbacks as $feedback)
      <div class="show-feedback">
        <div class="feedback__rating-area">
          <div class="feedback__rating--blue">★</div>
          <div class="@if($feedback->rating >= 2) feedback__rating--blue @else feedback__rating--gray @endif">★</div>
          <div class="@if($feedback->rating >= 3) feedback__rating--blue @else feedback__rating--gray @endif">★</div>
          <div class="@if($feedback->rating >= 4) feedback__rating--blue @else feedback__rating--gray @endif">★</div>
          <div class="@if($feedback->rating == 5) feedback__rating--blue @else feedback__rating--gray @endif">★</div>
        </div>
        <div class="feedback__comment-area">
          {{ $feedback->comment ?? '' }}
        </div>
        @if($feedback->img_path)
          <div class="feedback__img-area">
            <img class="feedback__img" src="{{ $feedback->img_path}}" ?? '' >
          </div>
        @endif
      </div>
      <hr class="feedback-line">
    @endforeach
  </div>

</div>
@endsection