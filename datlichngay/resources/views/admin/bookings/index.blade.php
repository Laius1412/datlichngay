@extends('layouts.layout_admin')

@section('content')
<div class="container">
    <h2>Quản lý lịch đặt sân</h2>

    <!-- Bộ lọc tìm kiếm -->
    <div class="row mb-2 d-flex align-items-center">
        <label class="col-auto col-form-label">Tên sân:</label>
        <div class="col-auto">
            <select class="form-control form-control-sm" id="select-field">
                <option value="">Chọn sân</option>
                @foreach($fields as $field)
                    <option value="{{ $field->id }}" {{ request('field_id') == $field->id ? 'selected' : '' }}>
                        {{ $field->name }}
                    </option>
                @endforeach
            </select>
        </div>
    
        <label class="col-auto col-form-label">Từ ngày:</label>
        <div class="col-auto">
            <input type="date" class="form-control form-control-sm" id="from-date" 
                   value="{{ request('from_date', now()->format('Y-m-d')) }}">
        </div>
    
        <label class="col-auto col-form-label">Đến ngày:</label>
        <div class="col-auto">
            <input type="date" class="form-control form-control-sm" id="to-date" 
                   value="{{ request('to_date', now()->addDays(7)->format('Y-m-d')) }}">
        </div>
    
        <div class="col-auto">
            <button class="btn btn-success btn-sm" id="btn-filter">Xem lịch</button>
        </div>
    </div>

    @if(request('field_id'))
    <!-- Lịch đặt sân -->
    <table class="table table-bordered text-center">
        <thead>
            <tr>
                <th rowspan="2">Giờ/Ngày</th>
                @foreach ($dates as $date)
                    <th colspan="{{ $subFields->count() }}">{{ \Carbon\Carbon::parse($date)->format('D d/m') }}</th>
                @endforeach
            </tr>
            <tr>
                @foreach ($dates as $date)
                    @foreach ($subFields as $subField)
                        <th>{{ $subField->name }}</th>
                    @endforeach
                @endforeach
            </tr>
        </thead>
        <tbody>
            @foreach ($timeSlots as $slot)
            <tr>
                <td>{{ $slot->start_time }} - {{ $slot->end_time }}</td>
                @foreach ($dates as $date)
                    @foreach ($subFields as $subField)
                        @php
                            $booking = $bookings->where('date', $date)
                                                ->where('start_time', $slot->start_time)
                                                ->where('sub_field_id', $subField->id)
                                                ->first();
                        @endphp
                        <td class="booking-cell" 
                        data-id="{{ $booking && $booking->status != 'cancelled' ? $booking->id : '' }}" 
                        data-field-id="{{ request('field_id') }}" 
                        data-sub-field-id="{{ $subField->id }}"
                        data-date="{{ $date }}" 
                        data-time="{{ $slot->start_time }}" 
                        style="cursor: pointer; background: 
                            {{ $booking && $booking->status != 'cancelled' ? 
                                ($booking->status == 'confirmed' ? '#28a745' : '#ffc107') 
                                : 'white' }};"
                        title="{{ $booking && $booking->status != 'cancelled' ? ($subField->name . ' - ' . ($booking->status == 'confirmed' ? 'Đã đặt' : 'Đang chờ')) : 'Chưa có khách' }}">
                        {{ $booking && $booking->status != 'cancelled' ? 
                            ($booking->status == 'confirmed' ? '✔' : 'O') 
                            : '' }}
                    </td>
                    
                    @endforeach
                @endforeach
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <p class="text-center text-muted">Vui lòng chọn sân để xem lịch đặt.</p>
    @endif
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $(".booking-cell").click(function() {
        let bookingId = $(this).data('id');
        let fieldId = $(this).data('field-id');
        let subFieldId = $(this).data('sub-field-id');
        let date = $(this).data('date');
        let time = $(this).data('time');

        if (bookingId) {
            window.location.href = "/admin/bookings/" + bookingId;
        } else {
            alert(`Sân: ${fieldId}\nSân con: ${subFieldId}\nNgày: ${date}\nGiờ: ${time}\nTrạng thái: Chưa có khách đặt`);
        }
    });

    $("#btn-filter").click(function() {
        let field = $("#select-field").val();
        let fromDate = $("#from-date").val();
        let toDate = $("#to-date").val();
        if (field) {
            window.location.href = `?field_id=${field}&from_date=${fromDate}&to_date=${toDate}`;
        } else {
            alert("Vui lòng chọn sân để xem lịch đặt!");
        }
    });

    $(".booking-cell").hover(function() {
        $(this).css("opacity", "0.8");
    }, function() {
        $(this).css("opacity", "1");
    });
});
</script>
@endsection
