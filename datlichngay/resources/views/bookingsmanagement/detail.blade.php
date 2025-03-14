@extends('layouts.layout')

@section('title', 'Chi tiết lịch đặt')

@section('content')
<div class="container">
    <h2>Chi tiết lịch đặt</h2>
    <div class="booking-info">
        <p><i class="fas fa-futbol"></i> <b>Tên sân:</b> {{ $booking->field_name }}</p>
        <p><i class="fas fa-th-large"></i> <b>Phần sân:</b> {{ $booking->sub_field_name }}</p>
        <p><i class="fas fa-layer-group"></i> <b>Loại sân:</b> {{ $booking->sub_field_type }}</p>
        <p><i class="fas fa-calendar-alt"></i> <b>Ngày đặt:</b> {{ date('d/m/Y', strtotime($booking->date)) }}</p>
        <p><i class="fas fa-clock"></i> <b>Giờ đặt:</b> {{ date('H:i', strtotime($booking->start_time)) }} - {{ date('H:i', strtotime($booking->end_time)) }}</p>
        <p><i class="fas fa-dollar-sign"></i> <b>Giá sân:</b> {{ number_format($booking->price) }} VNĐ</p>
        <p><i class="fas fa-map-marker-alt"></i> <b>Địa chỉ sân:</b> {{ $booking->address }}</p>
        <p><i class="fas fa-info-circle"></i> <b>Trạng thái:</b> 
            @if ($booking->status == 'confirmed')
                <span class="badge bg-success">Đã xác nhận</span>
            @elseif ($booking->status == 'pending')
                <span class="badge bg-warning">Đang chờ</span>
            @else
                <span class="badge bg-danger">Đã hủy</span>
            @endif
        </p>
    </div>

    @if ($booking->status != 'cancelled')
        <button class="btn btn-danger" id="cancelBooking">Hủy đặt sân</button>
    @endif
</div>

<!-- Modal Xác nhận hủy -->
<div id="confirmCancelModal" class="modal">
    <div class="modal-content">
        <p><b>Xác nhận hủy?</b></p>
        <p>Bạn đồng ý với <a href="#">Điều khoản & Chính sách</a>.</p>
        <button class="btn btn-success" id="confirmCancel">Xác nhận</button>
        <button class="btn btn-secondary" id="closeModal">Từ chối</button>
    </div>
</div>

<!-- Modal Thành công -->
<div id="successModal" class="modal">
    <div class="modal-content">
        <p><b>Thông báo</b></p>
        <p>Bạn đã hủy thành công, email xác nhận đã được gửi.</p>
        <button class="btn btn-primary" id="closeSuccess">Đóng</button>
    </div>
</div>

<style>
/* CSS cho modal */
.modal {
    display: none;
    position: fixed;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: white;
    padding: 20px;
    border-radius: 8px;
    text-align: center;
    width: 300px;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function() {
    let cancelBtn = document.getElementById("cancelBooking");

    if (cancelBtn) {
        cancelBtn.addEventListener("click", function() {
            if (!confirm("Bạn có chắc chắn muốn hủy lịch đặt này không?")) return;

            fetch("{{ route('bookingmanagement.cancel', $booking->id) }}", {
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ _method: "POST" }) 
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    window.location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error("Lỗi:", error));
        });
    }
});
</script>

@endsection
