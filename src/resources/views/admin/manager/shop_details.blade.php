@extends('layouts.after_auth')

@section('css')
<link rel="stylesheet" href="{{ asset('css/reservation.css') }}">
<link rel="stylesheet" href="{{ asset('css/feedback.css') }}">
@endsection

@section('main')
<div class="contents">
  <div class="shop-details">
    <div class="shop__name">
      <a class="return-btn" href="{{ route('admin.index') }}"><</a>
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
  </div>

  <div class="reservation-form">
    <h2>予約</h2>
    <button class="reservation-btn">管理者は予約できません</button>
  </div>
</div>
<div class="QR-code">
  {!! $qr_code !!}
</div>
@endsection