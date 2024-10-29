@extends('layouts.after_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/my_page.css') }}">
@endsection

@section('main')
<div class="contents">
  <div class="reservation-list">
    <div class="user-name hidden-lg">{{ $user_name ?? '' }}さん</div>
    <div class="list-title">
      <h2>予約状況</h2>
    </div>
    @foreach ($reserved_shops as $key=>$reserved_shop)
      <div class="reservation-card">
        <div class="reservation-card__header">
          <div class="reservation-card__header--inner">
            @if($reserved_shop->date > $today)
              <form action="/update_reservation" method="get">
                @csrf
                <input type="hidden" name="reservation_id" value="{{ $reserved_shop->id }}">
                <button class="modal--open no-btn-shape">
                  <i class="fa-solid fa-clock fa-xl"></i>
                </button>
              </form>
            @endif
            <div class="reservation-card__header--title">予約 {{ $key+1 }}</div>
          </div>

          @if($reserved_shop->date > $today)
            <form action="/cancel_reservation" method="post">
              @csrf
              <input type="hidden" name="shop_id" value="{{ $reserved_shop->shop_id }}">
              <button class="cancel-btn" type="submit">×</button>
            </form>
          @endif
        </div>

        @if($reserved_shop->date <= $today)
          ※当日の予約変更はできません
        @endif
        <table class="reservation-table">
          <tr class="reservation-table__row">
            <th class="reservation-table__header">Shop</th>
            <td>{{ $reserved_shop->shop->name ?? '' }}</td>
          </tr>
          <tr class="reservation-table__row">
            <th class="reservation-table__header">Date</th>
            <td>{{ $reserved_shop['date'] ?? '' }}</td>
          </tr>
          <tr class="reservation-table__row">
            <th class="reservation-table__header">Time</th>
            <td>{{ date('H:i', strtotime($reserved_shop['time'])) ?? '' }}</td>
          </tr>
          <tr class="reservation-table__row">
            <th class="reservation-table__header">Number</th>
            <td>{{ $reserved_shop['number'] ??'' }}人</td>
          </tr>
        </table>
      </div>
    @endforeach
  </div>

  <div class="favorite-list">
    <div class="user-name hidden-sm">{{ $user_name ?? '' }}さん</div>
    <div class="list-title"><h2>お気に入り店舗</h2></div>
    <div class="favorite-list__items">
      @foreach ($favorite_shops as $favorite_shop)
        <div class="shop-card">
          <div class="shop__img">
            <img src="{{ $favorite_shop->img_url ?? '画像がありません' }}" alt="{{ $favorite_shop->name ?? '' }}">
          </div>
          <div class="shop__contents">
            <div class="shop__name">
              {{ $favorite_shop['name'] ?? '' }}
            </div>
            <div class="shop__tags">
              #{{ $favorite_shop->area->name ?? '' }}
              #{{ $favorite_shop->category->name ?? ''}}
            </div>
            <div class="form-buttons">
              <div class="form-buttons__detail">
                <form action="/shop_details" method="get">
                  @csrf
                  <input type="hidden" name="shop_id" value="{{ $favorite_shop->id }}">
                  <button class="common-btn" type="submit">詳しくみる</button>
                </form>
              </div>
              <div class="form-buttons__favorite">
                @if (in_array($favorite_shop->id, $favorite_shop_ids))
                  <form action="/unfavorite" method="post">
                    @csrf
                    <input type="hidden" name="shop_id" value="{{ $favorite_shop->id }}">
                      <button class="favorite-btn--on" type="submit"></button>
                  </form>
                @else
                  <form action="/favorite" method="post">
                    @csrf
                    <input type="hidden" name="shop_id" value="{{ $favorite_shop->id }}">
                    <button class="favorite-btn--off" type="submit"></button>
                  </form>
                @endif
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
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