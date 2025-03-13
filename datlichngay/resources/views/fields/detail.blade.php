@extends('layouts.layout')

@section('title', 'Danh Sách Sân')

@section('content')
<div class="container">
    <h2>Thông tin sân: {{ $field->name }}</h2>
    <p>Vị trí: {{ $field->location }}</p>
    
    <label>Chọn ngày:</label>
    <input type="date" id="bookingDate" value="{{ now()->toDateString() }}">

    <button onclick="redirectToBooking()">Đặt sân</button>
</div>

<script>
    function redirectToBooking() {
        let date = document.getElementById('bookingDate').value;
        window.location.href = "{{ route('fields.booking', $field->id) }}?date=" + date;
    }
</script>
@endsection
