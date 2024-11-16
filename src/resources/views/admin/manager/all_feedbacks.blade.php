@extends('layouts.admin')

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
              <button class="common-btn" type="submit">
                <a href="/manager/shop_details?shop_id={{ $shop->id }}" class="common-btn-link">詳しくみる</a></button>
            </form>
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
        @if($user_role == 1)
          <div class="delete-feedback-area">
            <button class="common-btn">
              <a href="/admin/feedback/delete?feedback_id={{ $feedback->id }}" class="common-btn-link">口コミを削除</a>
            </button>
          </div>
        @endif
      </div>
      <hr class="feedback-line">
    @endforeach
  </div>

</div>
@endsection