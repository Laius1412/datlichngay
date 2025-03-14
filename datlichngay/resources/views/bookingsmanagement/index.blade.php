@extends('layouts.layout')

@section('title', 'Quản lý lịch đặt')

@section('content')
<div class="container">
    <h2 class="text-center my-4">Quản lý lịch đặt</h2>
    <table class="table table-bordered">
        <thead class="text-center">
            <tr>
                <th>STT</th>
                <th>Tên sân</th>
                <th>Phần sân</th>
                <th>Khung giờ</th>
                <th>Thời gian đặt</th>
                <th>Trạng thái</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $key => $booking)
            <tr>
                <td class="text-center">{{ $key + 1 }}</td>
                <td>{{ $booking->field_name }}</td>
                <td>{{ $booking->sub_field_name }}</td>
                <td>{{ date('H\h i', strtotime($booking->start_time)) }} - {{ date('H\h i', strtotime($booking->end_time)) }}</td>
                <td class="text-center">{{ date('d/m/Y', strtotime($booking->date)) }}</td>
                <td class="text-center">
                    @if($booking->status == 'confirmed')
                        <span class="badge bg-success">Đã xác nhận</span>
                    @elseif($booking->status == 'pending')
                        <span class="badge bg-warning text-dark">Đang chờ</span>
                    @else
                        <span class="badge bg-danger">Đã hủy</span>
                    @endif
                </td>
                <td class="text-center">
                    <a href="{{ route('bookingsmanagement.show', $booking->id) }}" class="btn btn-outline-secondary">
                        ➝
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
