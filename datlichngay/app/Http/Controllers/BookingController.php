<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Field;
use App\Models\SubField;
use App\Models\Booking;
use Carbon\Carbon;

class BookingController extends Controller
{
    // Hiển thị chi tiết sân + chọn ngày
    public function showField($id)
    {
        $field = Field::with('subFields')->findOrFail($id);
        return view('fields.detail', compact('field'));
    }

    // Hiển thị trang chọn sân theo ngày đã chọn
    public function showBookingPage(Request $request, $id)
    {
        $date = $request->query('date', now()->toDateString());
        $field = Field::with('subFields.prices')->findOrFail($id);
    
        // Lấy danh sách đặt chỗ theo ngày
        $bookings = Booking::whereDate('date', $date)->get()->groupBy('sub_field_id');
    
        // Lấy danh sách giờ động từ bảng prices
        $timeSlots = collect();
        foreach ($field->subFields as $subField) {
            foreach ($subField->prices as $price) {
                $timeSlots->push(['start_time' => $price->start_time, 'end_time' => $price->end_time]);
            }
        }
    
        // Loại bỏ các khung giờ trùng lặp
        $timeSlots = $timeSlots->unique()->sortBy('start_time');
    
        return view('fields.booking', compact('field', 'date', 'bookings', 'timeSlots'));
    }
    

    // Lưu thông tin đặt sân
    public function storeBooking(Request $request)
    {
        \Log::info('Dữ liệu nhận được:', $request->all());
    
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'booking' => 'required',
            'date' => 'required|date',
        ]);
    
        list($subFieldId, $startTime, $endTime, $price) = explode('|', $request->booking);
    
        $exists = Booking::where('sub_field_id', $subFieldId)
                         ->where('date', $request->date)
                         ->where('start_time', $startTime)
                         ->exists();
    
        if ($exists) {
            return back()->with('error', 'Khung giờ này đã được đặt.');
        }
    
        $booking = Booking::create([
            'user_id' => $request->user_id,
            'sub_field_id' => $subFieldId,
            'date' => $request->date,
            'start_time' => $startTime,
            'end_time' => $endTime,
            'price' => $price,
            'status' => 'pending', // Trạng thái ban đầu là "pending"
        ]);
    
        return redirect()->route('payment.show', $booking);
    }
// app/Http/Controllers/BookingController.php
public function showPayment(Request $request, $subFieldId)
{
    // Lấy thông tin từ query string
    $date = $request->query('date');
    $startTime = $request->query('start_time');
    $endTime = $request->query('end_time');
    $price = $request->query('price');

    // Lấy thông tin sân
    $subField = SubField::findOrFail($subFieldId);

    // Hiển thị trang thanh toán
    return view('fields.payment', compact('subField', 'date', 'startTime', 'endTime', 'price'));
}

public function confirmPayment(Request $request, $subFieldId)
{
    // Xác nhận thanh toán và lưu vào CSDL
    $booking = Booking::create([
        'user_id' => auth()->id(),
        'sub_field_id' => $subFieldId,
        'date' => $request->date,
        'start_time' => $request->start_time,
        'end_time' => $request->end_time,
        'price' => $request->price,
        'status' => 'confirmed', // Trạng thái thanh toán thành công
    ]);

    return redirect()->route('payment.show', $subFieldId)->with('success', 'Thanh toán thành công!');
}
}
