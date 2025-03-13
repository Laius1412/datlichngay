@extends('layouts.layout')

@section('title', 'Thanh Toán')

@section('content')
<div class="container">
    <h2>Thông Tin Thanh Toán</h2>
    <div class="row">
        <div class="col-md-6">
            <h3>Thông Tin Người Đặt</h3>
            <p><strong>Họ Tên:</strong> {{ auth()->user()->name }}</p>
            <p><strong>Số Điện Thoại:</strong> {{ auth()->user()->phone }}</p>
            <p><strong>Email:</strong> {{ auth()->user()->email }}</p>
        </div>
        <div class="col-md-6">
            <h3>Thông Tin Sân</h3>
            <p><strong>Tên Sân:</strong> {{ $subField->field->name }}</p>
            <p><strong>Loại Sân:</strong> {{ $subField->type }}</p>
            <p><strong>Ngày Đặt:</strong> {{ $date }}</p>
            <p><strong>Thời Gian:</strong> {{ $startTime }} - {{ $endTime }}</p>
            <p><strong>Giá:</strong> {{ number_format($price) }} đ</p>
        </div>
    </div>

    <div class="text-center my-4">
        <h3>Quét Mã QR Để Thanh Toán</h3>
        <!-- Thay thế bằng mã QR thực tế -->
        <img src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data={{ urlencode(route('payment.confirm', $subField->id)) }}" alt="QR Code">
    </div>

    <form action="{{ route('payment.confirm', $subField->id) }}" method="POST">
        @csrf
        <input type="hidden" name="date" value="{{ $date }}">
        <input type="hidden" name="start_time" value="{{ $startTime }}">
        <input type="hidden" name="end_time" value="{{ $endTime }}">
        <input type="hidden" name="price" value="{{ $price }}">
        <button type="submit" class="btn btn-primary">Xác Nhận Thanh Toán</button>
    </form>
</div>
@endsection