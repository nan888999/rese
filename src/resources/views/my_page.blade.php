@extends('layouts.after_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/my_page.css') }}">
@endsection

@section('main')
<div class="contents">
  <div class="reservation-list">
    <h2>予約状況</h2>
    @foreach ($reserved_shops as $reserved_shop)
    <div class="reservation-card">
        <form action="/cancel" method="post">
          @csrf
          <input type="hidden" name="shop_id" value="{{ $reserved_shop->shop_id }}">
          <button class="cancel-btn" type="submit">×</button>
        </form>
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
              <td>{{ $reserved_shop['time'] ?? '' }}</td>
            </tr>
            <tr class="reservation-table__row">
              <th class="reservation-table__header">Number</th>
              <td>{{ $reserved_shop['number'] ??'' }}人</td>
            </tr>
          </table>
      </div>
    @endforeach

  <div class="favorite-list">
    <h2>{{ $user['name'] ?? '' }}さん</h2>
  @foreach ($favorite_shops as $favorite_shop)
    <div class="shop-card">
      <div class="shop__img">
        <img src="{{ $favorite_shop->img_url ?? '画像がありません' }}" alt="{{ $favorite_shop->name ?? '' }}">
      </div>
      <div class="shop-contents">
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