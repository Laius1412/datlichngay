@extends('layouts.layout')

@section('title', 'Danh Sách Sân')

@section('content')
<div class="container">
    <!-- Thanh tìm kiếm -->
    <div class="search-bar d-flex justify-content-center my-4">
        <select class="form-select w-25 me-2">
            <option value="">Loại sân</option>
            <option value="5x5">5x5</option>
            <option value="7x7">7x7</option>
            <option value="9x9">9x9</option>
            <option value="11x11">11x11</option>
        </select>
        <input type="text" class="form-control w-50 me-2" placeholder="Nhập tên sân hoặc địa chỉ">
        <button class="btn btn-primary">Tìm kiếm</button>
    </div>

    <!-- Danh sách sân -->
    <div class="row">
        @foreach($fields as $field)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm">
                <!-- Hình ảnh sân -->
                <img src="{{ asset('images/banner_web.jpg') }}" class="card-img-top" alt="Sân bóng">
                
                <div class="card-body">
                    <h5 class="card-title fw-bold">{{ $field->name }}</h5>
                    <p class="card-text"><i class="fas fa-map-marker-alt text-danger"></i> <strong>Địa chỉ:</strong> {{ $field->location }}, {{ $field->ward }}, {{ $field->district }}</p>
                    <p class="card-text"><i class="fas fa-futbol text-success"></i> <strong>Loại sân:</strong> {{ $field->field_types }}</p>
                    <a href="{{ route('fields.show', $field->id) }}" class="btn btn-success w-100">Xem chi tiết</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    .card-img-top {
        height: 200px;
        object-fit: cover;
    }
    .card {
        transition: transform 0.2s ease-in-out;
    }
    .card:hover {
        transform: scale(1.05);
    }
</style>

<!-- FontAwesome để hiển thị icon -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
@endsection
