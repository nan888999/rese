@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/shop_manage.css') }}">
@endsection

@section('header__contents')
<div class="search-form">
  <form action="/manager/search" method="get">
    @csrf
    <select name="area" class="search-form__select" id="area-select" onchange="submit(this.form)">
      <option value="" disabled class="option__title" selected>All area</option>
      @foreach($areas as $area)
        <option value="{{ $area->id }}"
          @if(!empty($area_id) && $area_id == $area->id )
            selected
          @endif
        >
        {{ $area->name }}
        </option>
      @endforeach
    </select>
    <select name="category" class="search-form__select" id="category-select" onchange="submit(this.form)">
      <option value="" disabled class="option__title" selected>All genre</option>
      @foreach($categories as $category)
        <option value="{{ $category->id }}"
          @if(!empty($category_id) && $category_id == $category->id )
            selected
          @endif
        >
        {{ $category->name }}
        </option>
      @endforeach
    </select>
    <button type="submit" class="no-btn-shape">
      <i class="fa-solid fa-magnifying-glass light-gray-icon"></i>
    </button>
    <input type="text" class="search-form__keyword" name="keyword" placeholder="Search..." value="{{ $keyword ?? '' }}">
  </form>
</div>
@endsection

@section('main')
<!-- Add モーダル　ここから -->
<div class="shop_register">
  <button class="common-btn modal--open">Shop Registration</button>
  <div class="easy-modal modal" id="add-shop-modal">
    <div class="modal__content">
      <div class="modal__header">
        <h1>Shop Registration</h1>
        <span class="modal--close">×</span>
      </div>
      <div class="modal__body">
        <div class="manage-shop">
          <form class="manage-shop-form" action="/admin/add_shop" method="post">
            @csrf
            <input type="text" class="manage-shop-form__name" name="name" value="{{ old('name') }}" placeholder="店舗名">
            <div class="form__error">
              @error('name')
                {{ $message }}
              @enderror
            </div>
            <select name="area_id" class="manage-shop-form__select">
              <option value="" disabled class="option__title" selected>Area</option>
              @foreach($areas as $area)
                <option value="{{ $area->id }}"
                  @if(!empty($area_id) && $area_id == $area->id )
                    selected
                  @endif
                >
                {{ $area->name }}
                </option>
              @endforeach
            </select>
            <div class="form__error">
              @error('area_id')
                {{ $message }}
              @enderror
            </div>
            <select name="category_id" class="manage-shop-form__select">
              <option value="" disabled class="option__title" selected>Genre</option>
              @foreach($categories as $category)
                <option value="{{ $category->id }}"
                  @if(!empty($category_id) && $category_id == $category->id )
                    selected
                  @endif
                >
                {{ $category->name }}
                </option>
              @endforeach
            </select>
            <div class="form__error">
              @error('category_id')
                {{ $message }}
              @enderror
            </div>
            <textarea class="manage-shop-form__detail" name="detail" value="{{ old('detail') }}" placeholder="Shop説明文(200字以内)"></textarea>
            <div class="form__error">
              @error('detail')
                {{ $message }}
              @enderror
            </div>
            <input type="url" class="manage-shop-form__img" name="img_url" value="{{ old('img_url') }}" placeholder="画像URL">
            <div class="form__error">
              @error('img_url')
                {{ $message }}
              @enderror
            </div>
            <div class="right">
              <button class="common-btn" type="submit">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="contents">
  @foreach($shops as $shop)
    <div class="shop-card">
      <div class="shop__img">
        <img src="{{ $shop->img_url ?? '' }}" alt="
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
          <form action="/manager/reservation" method="get">
            @csrf
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            <button type="submit" class="common-btn">予約情報の確認</button>
          </form>
          <form action="/manager/edit_shop" method="get">
            @csrf
            <input type="hidden" name="shop_id" value="{{ $shop->id }}">
            <button type="submit" class="common-btn">編集</button>
          </form>
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
  @if (session('open_modal_add'))
    document.getElementById('add-shop-modal').style.display = 'block';
  @endif
});
</script>
@endsection
