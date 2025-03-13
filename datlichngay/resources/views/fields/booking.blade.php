@extends('layouts.layout')

@section('title', 'Danh Sách Sân')

@section('content')
<div class="container">
    <h2>Chọn sân cho ngày: {{ $date }}</h2>
    <form id="bookingForm">
        @csrf
        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
        <input type="hidden" name="date" value="{{ $date }}">

        <table border="1">
            <tr>
                <th>Giờ</th>
                @foreach ($field->subFields as $subField)
                    <th>{{ $subField->name }} ({{ $subField->type }})</th>
                @endforeach
            </tr>

            @foreach ($timeSlots as $slot)
                <tr>
                    <td>{{ $slot['start_time'] }} - {{ $slot['end_time'] }}</td>
                    @foreach ($field->subFields as $subField)
                        @php
                            $isBooked = isset($bookings[$subField->id]) 
                                        && $bookings[$subField->id]->where('start_time', $slot['start_time'])->count() > 0;
                            $price = $subField->prices->firstWhere('start_time', $slot['start_time'])->price ?? 0;
                        @endphp
                        <td>
                            @if ($isBooked)
                                ❌ <!-- Đã được đặt -->
                            @else
                                @if ($price == 0)
                                    ⛔ <!-- Không được đặt vì giá là 0đ -->
                                @else
                                    <input type="radio" name="booking" value="{{ $subField->id }}|{{ $slot['start_time'] }}|{{ $slot['end_time'] }}|{{ $price }}" required>
                                    {{ number_format($price) }} đ
                                @endif
                            @endif
                        </td>
                    @endforeach
                </tr>
            @endforeach
        </table>

        <button type="button" onclick="redirectToPayment()">Thanh toán</button>
    </form>
</div>

<script>
    function redirectToPayment() {
        const form = document.getElementById('bookingForm');
        const formData = new FormData(form);

        // Lấy giá trị từ radio button
        const bookingValue = formData.get('booking');
        if (!bookingValue) {
            alert('Vui lòng chọn khung giờ để đặt sân.');
            return;
        }

        // Tách giá trị từ chuỗi booking
        const [subFieldId, startTime, endTime, price] = bookingValue.split('|');

        // Kiểm tra nếu giá là 0đ
        if (parseInt(price) === 0) {
            alert('Khung giờ này không được phép đặt vì giá là 0đ.');
            return;
        }

        // Chuyển hướng đến trang thanh toán
        const url = "{{ route('payment.show', ['booking' => 'BOOKING_ID']) }}"
            .replace('BOOKING_ID', subFieldId)
            + `?date={{ $date }}&start_time=${startTime}&end_time=${endTime}&price=${price}`;

        window.location.href = url;
    }
</script>
@endsection