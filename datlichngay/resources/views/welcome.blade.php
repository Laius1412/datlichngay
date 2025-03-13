@extends('layouts.layout')

@section("title", "Trang Chủ")

@section('content')
<div class="container">
    <!-- Phần Banner -->
    <div class="banner position-relative text-center text-white">
        <div class="banner-overlay d-flex flex-column justify-content-center align-items-center">
            <h3 class="fw-bold">HỆ THỐNG ĐẶT LỊCH SÂN BÓNG ONLINE</h3>
            <div class="search-bar d-flex justify-content-center mt-3 align-items-center">
                <!-- Lọc loại sân -->
                <select class="form-select w-25 me-1 h-100">
                    <option value="">Loại sân</option>
                    <option value="7x7">7x7</option>
                    <option value="9x9">9x9</option>
                    <option value="11x11">11x11</option>
                </select>
                <!-- Nhập tên hoặc địa chỉ sân -->
                <input type="text" class="form-control w-50 me-1 h-40" placeholder="Nhập tên sân hoặc địa chỉ">
                <!-- Nút tìm kiếm -->
                <button class="btn btn-primary h-40">Tìm kiếm</button>
            </div>
        </div>
    </div>

    <!-- Phần Lợi Ích -->
    <div class="row text-center my-5">
        <div class="col-md-4">
            <div class="benefit">
                <i class="fas fa-search fa-3x text-primary"></i>
                <h4 class="mt-3">Tìm kiếm nhanh chóng</h4>
                <p>Dễ dàng tìm kiếm sân bóng gần bạn với bộ lọc thông minh.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="benefit">
                <i class="fas fa-calendar-alt fa-3x text-success"></i>
                <h4 class="mt-3">Đặt lịch dễ dàng</h4>
                <p>Chỉ vài cú click chuột để chọn sân và đặt lịch nhanh chóng.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="benefit">
                <i class="fas fa-credit-card fa-3x text-danger"></i>
                <h4 class="mt-3">Thanh toán thuận tiện</h4>
                <p>Nhiều phương thức thanh toán an toàn và tiện lợi.</p>
            </div>
        </div>
    </div>
</div>

<!-- CSS tùy chỉnh -->
<style>
    .banner {
        position: relative;
        height: 400px;
        background: url('{{ asset('images/banner_web.jpg') }}') no-repeat center center;
        background-size: cover;
    }
    .banner-overlay {
        background: rgba(0, 0, 0, 0.5);
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
        padding: 40px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
    }
    .search-bar {
        background: rgba(255, 255, 255, 0.9);
        padding: 2px;
        border-radius: 5px;
    }
    .benefit i {
        display: block;
        margin-bottom: 10px;
    }
</style>

@endsection
