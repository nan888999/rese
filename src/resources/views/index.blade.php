@extends('layouts.after_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
@endsection

@section('header__contents')
<form action="/search" method="get">
  @csrf
  <div class="sort-form">
    <select name="sort" id="sort-form__select" class="sort__select" onchange="submit(this.form)">
      <option value="" disabled class="option__title" selected>並び替え：高/低</option>
      <option value="random" class="sort__option"
        @if(!empty($sort_option) && $sort_option === 'random' )
          selected
        @endif >ランダム</option>
      <option value="high" class="sort__option"
        @if(!empty($sort_option) && $sort_option === 'high' )
          selected
        @endif >評価が高い順</option>
      <option value="low" class="sort__option"
        @if(!empty($sort_option) && $sort_option === 'low' )
          selected
        @endif >評価が低い順</option>
    </select>
  </div>
  <div class="search-form">
    <div class="search-form__select-area">
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
    </div>
    <div class="search-form__keyword-area">
      <button type="submit" class="no-btn-shape">
        <i class="fa-solid fa-magnifying-glass light-gray-icon"></i>
      </button>
      <input type="text" class="search-form__keyword" name="keyword" placeholder="Search..." value="{{ $keyword ?? '' }}">
    </div>
  </div>
</form>
@endsection

@section('main')
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
          <div class="form-buttons__detail">
            <form action="/shop_details" method="get">
              @csrf
              <input type="hidden" name="shop_id" value="{{ $shop->id }}">
              <button class="common-btn" type="submit">詳しくみる</button>
            </form>
          </div>
          <div class="form-buttons__favorite">
            @if (in_array($shop->id, $favorite_shop_ids))
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
</div>
@endsection
