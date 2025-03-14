@extends('layouts.layout_admin')

@section('content')
<div class="container">
    <h2 class="text-center">Chi tiết lịch đặt sân</h2>
    <div class="row">
        <!-- Thông tin khách hàng -->
        <div class="col-md-6">
            <label><strong>Người đặt:</strong></label>
            <input type="text" class="form-control" value="{{ $booking->user->name }}" disabled>

            <label><strong>Ngày sinh:</strong></label>
            <input type="text" class="form-control" value="{{ $booking->user->dob ?? 'dd/mm/yyyy' }}" disabled>

            <label><strong>SDT:</strong></label>
            <input type="text" class="form-control" value="{{ $booking->user->phone }}" disabled>

            <label><strong>CCCD:</strong></label>
            <input type="text" class="form-control" value="{{ $booking->user->cccd ?? '************' }}" disabled>

            <label><strong>Email:</strong></label>
            <input type="text" class="form-control" value="{{ $booking->user->email }}" disabled>

  
        </div>
        
        <!-- Thông tin sân -->
        <div class="col-md-6">
            <label><strong>Tên sân:</strong></label>
            <input type="text" class="form-control" value="{{ $booking->subField->name }}" disabled>

            <label><strong>Loại sân:</strong></label>
            <input type="text" class="form-control" value="{{ $booking->subField->type ?? 'Không xác định' }}" disabled>

            <label><strong>Ngày đặt:</strong></label>
            <input type="text" class="form-control" value="{{ $booking->date }}" disabled>

            <label><strong>Giờ đặt:</strong></label>
            <input type="text" class="form-control" value="{{ $booking->start_time }} - {{ $booking->end_time }}" disabled>

            <label><strong>Giá sân:</strong></label>
            <input type="text" class="form-control" value="{{ number_format($booking->price) }} VNĐ" disabled>
            
            
        </div>
    </div>

    <!-- Địa chỉ sân -->
    <div class="mt-3">
        <label><strong>Địa chỉ sân:</strong></label>
        <input type="text" class="form-control" value="{{ $booking->subField->address }}" disabled>
    </div>

    <!-- Trạng thái sân -->
    <div class="text-center mt-3">
        <label><strong>Trình trạng sân:</strong></label>
        @if ($booking->status == 'pending')
            <span class="badge bg-warning text-dark">Đang chờ xác nhận</span>
        @elseif ($booking->status == 'confirmed')
            <span class="badge bg-success">Đã đặt</span>
        @else
            <span class="badge bg-danger">Đã hủy</span>
        @endif
    </div>
    
    <!-- Nút xác nhận / hủy -->
    @if ($booking->status == 'pending')
    <div class="text-center mt-3">
        <form action="{{ route('admin.bookings.confirm', $booking->id) }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-success">Xác nhận</button>
        </form>
        
        <form action="{{ route('admin.bookings.cancel', $booking->id) }}" method="POST" style="display: inline;">
            @csrf
            <button type="submit" class="btn btn-danger">Hủy</button>
        </form>
    </div>
    @endif
    
    <!-- Nút quay lại -->
    <div class="text-center mt-3">
        <a href="{{ route('admin.bookings.index') }}" class="btn btn-secondary">Thoát</a>
    </div>
</div>
@endsection