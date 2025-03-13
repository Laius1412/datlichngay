@extends('layouts.layout_admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Chi tiết khách hàng</h2>
    <div class="card p-4">
        <div class="row">
            <!-- Khu vực hiển thị ảnh đại diện -->
            <div class="col-md-4 text-center">
                <div style="width: 150px; height: 150px; border: 2px solid #ccc; display: flex; align-items: center; justify-content: center; margin: auto; position: relative;">
                    <img src="{{ asset($customer->avatar ?? 'default-avatar.png') }}" alt="Avatar" class="img-thumbnail" style="width: 100%; height: 100%; object-fit: cover;">
                </div>
                <p class="mt-2">Avatar</p>
            </div>
            
            <!-- Khu vực hiển thị thông tin khách hàng -->
            <div class="col-md-8">
                <table class="table table-bordered">
                    <tr><th>Họ tên:</th><td>{{ $customer->name }}</td></tr>
                    <tr><th>Giới tính:</th><td>{{ $customer->gender }}</td></tr>
                    <tr><th>SDT:</th><td>{{ $customer->phone }}</td></tr>
                    <tr><th>Ngày sinh:</th><td>{{ $customer->dob }}</td></tr>
                    <tr><th>CCCD:</th><td>{{ $customer->cccd }}</td></tr>
                    <tr><th>Email:</th><td>{{ $customer->email }}</td></tr>
                    <tr><th>Số lần đặt sân:</th><td>{{ $customer->booking_count }}</td></tr>
                    <tr><th>Lịch sử đặt sân:</th><td>{{ $customer->booking_history }}</td></tr>
                    <tr>
                        <th>Địa chỉ:</th>
                        <td>
                            <strong>Tỉnh/Thành phố:</strong> {{ $customer->city }}<br>
                            <strong>Quận/Huyện:</strong> {{ $customer->district }}<br>
                            <strong>Phường/Xã:</strong> {{ $customer->ward }}<br>
                            <strong>Số nhà:</strong> {{ $customer->address }}
                        </td>
                    </tr>
                </table>
                <a href="{{ route('admin.customers.index') }}" class="btn btn-danger">Thoát</a>
            </div>
        </div>
    </div>
</div>
@endsection
