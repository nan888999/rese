@extends('layouts.admin')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin/reservation.css') }}">
@endsection

@section('main')
<h1>Reservations（{{ $shop_name ?? '' }}）</h1>
<div class="contents">
  <table class="reservation-table">
    <tr class="reservation-table__row">
      <th class="reservation-table__header">来店日</th>
      <th class="reservation-table__header">来店時刻</th>
      <th class="reservation-table__header">予約者名</th>
      <th class="reservation-table__header">人数</th>
      <th class="reservation-table__header">更新日時</th>
    @foreach ($reservations as $reservation)
    <tr class="reservation-table__row">
      <td class="reservation-table__data">{{ $reservation->date ?? '' }}</td>
      <td class="reservation-table__data">{{ \Carbon\Carbon::parse($reservation->time)->format('H:i') ?? '' }}</td>
      <td class="reservation-table__data">{{ $reservation->user->name ?? '' }}</td>
      <td class="reservation-table__data">{{ $reservation->number ?? '' }}人</td>
      <td class="reservation-table__data">{{ $reservation->updated_at->format('Y/m/d H:i') ?? '' }}</td>
    </tr>
  @endforeach
  </table>
</div>
@endsection
