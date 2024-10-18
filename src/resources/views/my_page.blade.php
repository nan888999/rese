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
        <button class="modalOpen">
          <i class="fa-solid fa-clock" style="color:white;"></i>
        </button>
        <div class="easyModal modal">
          <div class="modal-content">
            <div class="modal-header">
              <h1>予約変更</h1>
              <span class="modalClose">×</span>
            </div>
            <div class="modal-body">
              <form action="/update_reservation" method="post">
              @csrf
                <input type="hidden" name="reservation_id" value="{{ $reserved_shop->id ?? '' }}">
                <input type="hidden" name="shop_id" value="{{ $reserved_shop->shop_id ?? '' }}">
                <input class="date_form" type="date" name="date" min="{{ $today }}" value="{{ old('date', $reservation['date'] ?? '') }}" placeholder="{{ $reservation->date ?? '' }}">
                <div class="form__error">
                  @error('date')
                  ※ {{ $message }}
                  @enderror
                </div>
                <input class="time_form" type="time" name="time" value="{{ old('time', $reservation['time'] ?? '') }}" placeholder="$reservation->time">
                <div class="form__error">
                  @error('time')
                  ※ {{ $message }}
                  @enderror
                </div>
                <select name="number" class="number_form">
                  @foreach($number_options as $number_option)
                    <option value="{{ $number_option }}"
                      @if (!empty($reservation['number']) && $reservation['number'] == $number_option )
                        selected
                      @endif
                    >
                    {{ $number_option }}人
                    </option>
                  @endforeach
                </select>
                <button type="submit">予約を変更する</button>
              </form>
            </div>
          </div>
        </div>

        <form action="/cancel_reservation" method="post">
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
    <h2>{{ $user_name ?? '' }}さん</h2>
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
document.addEventListener('DOMContentLoaded', function () {
  // モーダルを開くボタンをすべて取得
  const buttonsOpen = document.querySelectorAll('.modalOpen');
  const modals = document.querySelectorAll('.easyModal');
  const buttonsClose = document.querySelectorAll('.modalClose');

  // 各ボタンにイベントリスナーを設定
  buttonsOpen.forEach((button, index) => {
    button.addEventListener('click', function () {
      modals[index].style.display = 'block';
    });
  });

  // 各モーダルの閉じるボタンにイベントリスナーを設定
  buttonsClose.forEach((button, index) => {
    button.addEventListener('click', function () {
      modals[index].style.display = 'none';
    });
  });

  // モーダルの外側をクリックしたら閉じる
  window.addEventListener('click', function (event) {
    modals.forEach(modal => {
      if (event.target == modal) {
        modal.style.display = 'none';
      }
    });
  });
});

</script>
@endsection