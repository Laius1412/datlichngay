@extends('layouts.layout')

@section('title', 'Chi tiết sân')

@section('content')
<div class="container">
    <div class="row">
        <!-- Cột hình ảnh -->
        <div class="col-md-7">
            <img src="{{ asset('images/banner_web.jpg') }}" class="img-fluid rounded shadow" alt="Sân bóng">
        </div>

        <!-- Cột thông tin sân -->
        <div class="col-md-5">
            <h2 class="fw-bold"><i class="fas fa-futbol"></i> {{ $field->name }}</h2>

            <!-- Chọn ngày -->
            <div class="mb-3">
                <label for="bookingDate" class="form-label">Chọn ngày:</label>
                <input type="date" id="bookingDate" value="{{ now()->toDateString() }}" class="form-control">
            </div>
            <!-- Nút đặt sân -->
            <button onclick="redirectToBooking()" class="btn btn-primary">Đặt sân</button>
        </div>
    </div>

    <!-- Thông tin chi tiết sân -->
    <div class="mt-4">
        <h4 class="fw-bold">Chi tiết sân</h4>
        <p><i class="fas fa-layer-group"></i> <strong>Loại sân:</strong> {{ $field->field_types ?? 'Chưa cập nhật' }}</p>
        <p><i class="fas fa-users"></i> <strong>Số chỗ ngồi:</strong> 500</p>
        <p><i class="fas fa-map-marker-alt"></i> <strong>Vị trí:</strong> {{ $field->location }}, {{ $field->ward }}, {{ $field->district }}</p>
    </div>

    <!-- Tiện nghi -->
    <div class="mt-4">
        <h4 class="fw-bold">Tiện nghi</h4>
        <div class="d-flex gap-3">
            <div class="p-3 border rounded text-center">
                <i class="fas fa-lightbulb fa-2x text-primary"></i>
                <p class="mt-2">Có đèn sáng</p>
            </div>
            <div class="p-3 border rounded text-center">
                <i class="fas fa-door-closed fa-2x text-primary"></i>
                <p class="mt-2">Phòng thay đồ</p>
            </div>
            <div class="p-3 border rounded text-center">
                <i class="fas fa-parking fa-2x text-primary"></i>
                <p class="mt-2">Chỗ để xe</p>
            </div>
        </div>
    </div>

    <!-- Google Map -->
    <div class="mt-4">
        <h4 class="fw-bold">Location</h4>
        <div id="map" style="height: 300px;"></div>
    </div>
</div>

<!-- Google Maps API -->
<script>
    function initMap() {
        var location = { lat: 20.985, lng: 105.798 }; // Tọa độ ví dụ
        var map = new google.maps.Map(document.getElementById('map'), {
            zoom: 15,
            center: location
        });
        new google.maps.Marker({
            position: location,
            map: map
        });
    }

    function redirectToBooking() {
        let date = document.getElementById('bookingDate').value;
        window.location.href = "{{ route('fields.booking', $field->id) }}?date=" + date;
    }
</script>

<script async defer
    src="https://maps.googleapis.com/maps/api/js?key=YOUR_API_KEY&callback=initMap">
</script>

<style>
    .border {
        width: 120px;
        text-align: center;
    }
</style>

@endsection
