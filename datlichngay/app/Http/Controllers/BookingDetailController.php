<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\SubField;

class BookingDetailController extends Controller
{
    public function show($id)
    {
        // Lấy thông tin lịch đặt theo ID
        $booking = Booking::with('subField.field')->findOrFail($id);

        return view('bookingsmanagement.booking_detail', compact('booking'));
    }

    public function cancel($id)
{
    $booking = Booking::find($id);
    
    if (!$booking) {
        return response()->json(['success' => false, 'message' => 'Lịch đặt không tồn tại!']);
    }

    // Cập nhật trạng thái thành 'cancelled'
    $booking->status = 'cancelled';
    $booking->save();

    return response()->json(['success' => true]);
}
}
