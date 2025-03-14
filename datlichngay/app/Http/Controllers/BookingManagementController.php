<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\SubField;
use App\Models\Field;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingManagementController extends Controller
{
    public function index()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->join('sub_fields', 'bookings.sub_field_id', '=', 'sub_fields.id')
            ->join('fields', 'sub_fields.field_id', '=', 'fields.id')
            ->select(
                'bookings.id',
                'fields.name as field_name',
                'sub_fields.name as sub_field_name',
                'bookings.date',
                'bookings.start_time',
                'bookings.end_time',
                'bookings.status'
            )
            ->orderBy('bookings.date', 'desc')
            ->get();

        return view('bookingsmanagement.index', compact('bookings'));
    }

    public function show($id)
    {
        $booking = DB::table('bookings')
            ->join('sub_fields', 'bookings.sub_field_id', '=', 'sub_fields.id')
            ->join('fields', 'sub_fields.field_id', '=', 'fields.id')
            ->where('bookings.id', $id)
            ->select(
                'bookings.*', 
                'sub_fields.name as sub_field_name',
                'sub_fields.type as sub_field_type', 
                'fields.name as field_name', 
                DB::raw("CONCAT(fields.location, ', ', fields.ward, ', ', fields.district, ', ', fields.city) as address")
            )
            ->first();

        if (!$booking) {
            return redirect()->route('bookingsmanagement.index')->with('error', 'Lịch đặt không tồn tại.');
        }

        return view('bookingsmanagement.detail', compact('booking'));
    }

    public function cancel($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Lịch đặt không tồn tại.',
            ], 404);
        }

        if ($booking->status === 'cancelled') {
            return response()->json([
                'success' => false,
                'message' => 'Lịch đặt này đã bị hủy trước đó.',
            ], 400);
        }

        // Chỉ người đặt hoặc admin mới có thể hủy
        if ($booking->user_id != Auth::id() && !Auth::user()->isAdmin()) {
            return response()->json([
                'success' => false,
                'message' => 'Bạn không có quyền hủy lịch đặt này.',
            ], 403);
        }

        $booking->update(['status' => 'cancelled']);

        return response()->json([
            'success' => true,
            'message' => 'Bạn đã hủy lịch đặt thành công, thông tin hủy đã được gửi qua email!',
        ]);
    }
}
