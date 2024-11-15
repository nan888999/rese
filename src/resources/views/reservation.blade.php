@extends('layouts.after_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
@endsection

@section('main')
<div class="contents">
  <div class="shop-details">
    <div class="shop__name">
      <a class="return-btn" href="/"><</a>
      <h2>{{ $shop->name ?? '' }}</h2>
    </div>
    <div class="shop__img">
      <img src="{{ $shop->img_url ?? '' }}" alt="
      @if($shop->img_url) {{ $shop->name ?? '' }}
      @else No Image @endif
      ">
    </div>
    <div class="shop__tags">
      #{{ $shop->area->name ?? '' }}
      #{{ $shop->category->name ?? '' }}
    </div>
    <div class="shop__detail">
      {{ $shop->detail ?? ''}}
    </div>
    @if(!$previous_feedback)
      <div class="feedback">
        <a href="/feedback?shop_id={{ $shop->id }}" class="feedback-link">口コミを投稿する</a>
      </div>
    @else
      <a href="/all_feedbacks" class="show-feedbacks-btn">
        全ての口コミ情報
      </a>
      <div class="edit-feedback-menu">
        <a href="/feedback">口コミを編集</a>
        <a href="/delete_feedback">口コミを削除</a>
      </div>
      <div class="my-feedback">
        <div class="rating-form">
          <input class="rating-form__input" id="star1" name="rating" type="radio" value="1" checked readonly>
          <label class="rating-form__label" for="star1"><i class="fa-solid fa-star"></i></label>

          <input class="rating-form__input" id="star2" name="rating" type="radio" value="2" {{ $previous_feedback->rating == 2 ? 'checked' : '' }} readonly>
          <label class="rating-form__label" for="star2"><i class="fa-solid fa-star"></i></label>

          <input class="rating-form__input" id="star3" name="rating" type="radio" value="3" {{ $previous_feedback->rating == 3 ? 'checked' : '' }} readonly>
          <label class="rating-form__label" for="star3"><i class="fa-solid fa-star"></i></label>

          <input class="rating-form__input" id="star4" name="rating" type="radio" value="4" {{ $previous_feedback->rating == 4 ? 'checked' : '' }} readonly>
          <label class="rating-form__label" for="star4"><i class="fa-solid fa-star"></i></label>

          <input class="rating-form__input" id="star5" name="rating" type="radio" value="5" {{ $previous_feedback->rating == 5 ? 'checked' : '' }} readonly>
          <label class="rating-form__label" for="star5"><i class="fa-solid fa-star"></i></label>
        </div>
        {{ $previous_feedback->comment ?? '' }}
      </div>
  </div>

  <div class="reservation-form">
    @if($unreviewed_reservation)
      <div class="reserved">
        <h2>予約状況</h2>
        <table class="confirm__table">
          <tr class="confirm__table--row">
            <th class="confirm__table--header">Shop</th>
            <td>{{ $shop->name ?? '' }}</td>
          </tr>
          <tr class="confirm__table--row">
            <th class="confirm__table--header">Date</th>
            <td>{{ $unreviewed_reservation->date ?? ''}}</td>
          </tr>
          <tr class="confirm__table--row">
            <th class="confirm__table--header">Time</th>
            <td>{{ $unreviewed_reservation_time ?? ''}}</td>
          </tr>
          <tr class="confirm__table--row">
            <th class="confirm__table--header">Number</th>
            <td>{{ $unreviewed_reservation->number ?? ''}} 人</td>
          </tr>
        </table>
        @if($unreviewed_reservation->date < $today || ($unreviewed_reservation->date == $today && $unreviewed_reservation_time < $now))
          <button class="reservation-btn modal--open">このお店を評価する</button>
        @else
          <button class="reservation-btn" type="button">まだ評価できません</button>
        @endif
          <div class="easy-modal modal" id="review-modal">
            <div class="modal__content">
              <div class="modal__header">
                <h1>{{ $shop->name }}</h1>
                <span class="modal--close">×</span>
              </div>
              <div class="modal__body">
                <div class="review-form">
                  <h2>来店記録</h2>
                  <div class="reserved-table">
                    <table>
                      <tr class="reserved-table__row">
                        <th class="reserved-table__header">Date</th>
                        <td>{{ $unreviewed_reservation->date ?? ''}}</td>
                      </tr>
                      <tr class="reserved-table__row">
                        <th class="reserved-table__header">Time</th>
                        <td>{{ $unreviewed_reservation_time ?? ''}}</td>
                      </tr>
                      <tr class="reserved-table__row">
                        <th class="reserved-table__header">Number</th>
                        <td>{{ $unreviewed_reservation->number ?? ''}} 人</td>
                      </tr>
                    </table>
                  </div>
                  <form action="/review" method="post">
                  @csrf
                    <input type="hidden" name="reservation_id" value="{{ $unreviewed_reservation->id }}">
                    <h2 class="rating__title">お店の評価</h2>
                    <span class="red">※必須</span>
                    <div class="rating-form">
                      <input class="rating-form__input" id="star1" name="rating" type="radio" value="1">
                      <label class="rating-form__label" for="star1"><i class="fa-solid fa-star"></i></label>

                      <input class="rating-form__input" id="star2" name="rating" type="radio" value="2">
                      <label class="rating-form__label" for="star2"><i class="fa-solid fa-star"></i></label>

                      <input class="rating-form__input" id="star3" name="rating" type="radio" value="3">
                      <label class="rating-form__label" for="star3"><i class="fa-solid fa-star"></i></label>

                      <input class="rating-form__input" id="star4" name="rating" type="radio" value="4">
                      <label class="rating-form__label" for="star4"><i class="fa-solid fa-star"></i></label>

                      <input class="rating-form__input" id="star5" name="rating" type="radio" value="5">
                      <label class="rating-form__label" for="star5"><i class="fa-solid fa-star"></i></label>
                    </div>
                      <div class="review-form__error">
                        @error('rating')
                        ※ {{ $message }}
                        @enderror
                      </div>
                    <h2 class="comment__title">ご意見・ご感想(100字以内)</h2>
                    <input class="comment-form" type="text" name="comment" value="{{ old('comment') }}">
                    <div class="review-form__error">
                      @error('comment')
                      ※ {{ $message }}
                      @enderror
                    </div>
                    <div class="center">
                      <button class="common-btn" type="submit">評価を送信する</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
      </div>
    @else
      <h2>予約</h2>
      <form action="/reservation_confirm" method="post">
        @csrf
        <input type="hidden" name="shop_id" value="{{ $shop->id ?? '' }}">
        <input class="date-form" type="date" name="date" min="{{ $today }}" value="{{ old('date', $reservation['date'] ?? '') }}" onchange="submit(this.form)">
        <div class="form__error">
          @error('date')
          ※ {{ $message }}
          @enderror
        </div>
        <input class="time-form" type="time" name="time" value="{{ old('time', $reservation['time'] ?? '') }}" onchange="submit(this.form)">
        <div class="form__error">
          @error('time')
          ※ {{ $message }}
          @enderror
        </div>
        <select name="number" class="number-form" onchange="submit(this.form)">
          <option value="" disabled class="option__title" selected>人数を選択してください</option>
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
        <div class="form__error">
          @error('number')
          ※ {{ $message }}
          @enderror
        </div>
        <div class="confirm">
          <table class="confirm__table">
            <tr class="confirm__table--row">
              <th class="confirm__table--header">Shop</th>
              <td>{{ $shop->name ?? '' }}</td>
            </tr>
            <tr class="confirm__table--row">
              <th class="confirm__table--header">Date</th>
              <td class="date-area"></td>
            </tr>
            <tr class="confirm__table--row">
              <th class="confirm__table--header">Time</th>
              <td class="time-area"></td>
            </tr>
            <tr class="confirm__table--row">
              <th class="confirm__table--header">Number</th>
              <td class="number-area"></td>
            </tr>
          </table>
        </div>
      </form>
      <form action="/reservation" method="post">
        @csrf
        <input type="hidden" name="shop_id" value="{{ $shop->id ?? '' }}">
        <input type="hidden" name="date" value="{{ old('date', $reservation['date'] ?? '' ) }}">
        <input type="hidden" name="time" value="{{ old('time', $reservation['time'] ?? '' ) }}">
        <input type="hidden" name="number" value="{{ old('number', $reservation['number'] ?? '' ) }}">
        <button class="reservation-btn" type="submit">予約する</button>
      </form>
    @endif
  </div>
</div>
<div class="QR-code">
  {!! $qr_code !!}
</div>
@endsection

@section('script')
<script type="text/javascript">
$(function(){
  $("#submit_select").change(function(){
    $("#submit_form").submit();
  });

  var date = $('.date-form').val();
  $('.date-area').html(date);

  var time = $('.time-form').val();
  $('.time-area').html(time);

  var number = $('.number-form').val();
  if (!number) {
    $('.number-area').html('');
  } else {
    $('.number-area').html(number + "人");
  }
});

document.addEventListener('DOMContentLoaded', function () {
  const buttonsOpen = document.querySelectorAll('.modal--open');
  const modals = document.querySelectorAll('.easy-modal');
  const buttonsClose = document.querySelectorAll('.modal--close');

  // モーダルを開くボタンのイベントリスナーを設定
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
      if (event.target === modal) {
        modal.style.display = 'none';
      }
    });
  });

  // バリデーションエラーがあった場合、モーダルを開く
  @if (session('open_modal'))
    document.getElementById('review-modal').style.display = 'block';
  @endif
});
</script>
@endsection