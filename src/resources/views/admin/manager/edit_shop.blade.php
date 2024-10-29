@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/admin/edit_shop.css') }}">
@endsection

@section('main')
<div class="edit-shop">
  <h1>Edit Shop</h1>
  <form class="edit-shop-form" action="/manager/edit_shop" method="post">
    @csrf
    <input type="hidden" name="shop_id" value="{{ $shop->id }}">
    <label class="edit-shop-form__label" for="edit-shop-form__name">Shop Name</label>
    <input type="text" id="edit-shop-form__name" name="name" value="{{ old('name', $shop->name) }}">
    <div class="form__error">
      @error('name')
        {{ $message }}
      @enderror
    </div>

    <label class="edit-shop-form__label" for="edit-shop-form__area">Area</label>
    <select name="area_id" id="edit-shop-form__area" class="edit-shop-form__select">
      <option value="" disabled class="option__title" selected>Area</option>
      @foreach($areas as $area)
        <option value="{{ $area->id }}"
          @if(old('area_id', $shop->area_id) == $area->id)
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

    <label class="edit-shop-form__label" for="edit-shop-form__category">Genre</label>
    <select name="category_id" id="edit-shop-form__category" class="edit-shop-form__select">
      <option value="" disabled class="option__title" selected>Genre</option>
      @foreach($categories as $category)
        <option value="{{ $category->id }}"
          @if(old('category_id', $shop->category_id) == $category->id)
            selected
          @endif
        >
          {{ $category->name }}
        </option>
      @endforeach
    </select>
    <div class="form__error">
      @error('category')
        {{ $message }}
      @enderror
    </div>

    <label class="edit-shop-form__label" for="edit-shop-form__detail">Shop説明文(200字以内)</label>
    <textarea id="edit-shop-form__detail" name="detail">{{ old('detail', $shop->detail) }}</textarea>
    <div class="form__error">
      @error('detail')
        {{ $message }}
      @enderror
    </div>

    <label class="edit-shop-form__label" for="edit-shop-form__img">画像URL</label>
    <input type="url" id="edit-shop-form__img" name="img_url" value="{{ old('img_url', $shop->img_url) }}">
    <div class="form__error">
      @error('img_url')
        {{ $message }}
      @enderror
    </div>

    <div class="center">
      <button class="common-btn" type="submit">Submit</button>
    </div>
  </form>
</div>
@endsection
