<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\SubField;
use App\Models\User;
use App\Models\Field;
use App\Models\Price;
use Carbon\Carbon;

class AdminBookingController extends Controller
{
    // Hiển thị danh sách lịch đặt của khách hàng
    public function index(Request $request)
{
    $fields = Field::with('subFields')->get();

    $fieldId = $request->query('field_id');
    
    $subFields = collect(); // Danh sách sân con
    $subFieldIds = [];

    if ($fieldId) {
        $subFields = SubField::where('field_id', $fieldId)->get();
        $subFieldIds = $subFields->pluck('id')->toArray();
    }

    $bookings = Booking::with(['user', 'subField'])
        ->when(!empty($subFieldIds), function ($query) use ($subFieldIds) {
            return $query->whereIn('sub_field_id', $subFieldIds);
        })
        ->when($request->query('from_date'), function ($query) use ($request) {
            return $query->where('date', '>=', $request->query('from_date'));
        })
        ->when($request->query('to_date'), function ($query) use ($request) {
            return $query->where('date', '<=', $request->query('to_date'));
        })
        ->orderBy('date', 'asc')
        ->get();

    $fromDate = $request->query('from_date', now()->format('Y-m-d'));
    $toDate = $request->query('to_date', now()->addDays(7)->format('Y-m-d'));
    $dates = collect();
    for ($date = Carbon::parse($fromDate); $date->lte(Carbon::parse($toDate)); $date->addDay()) {
        $dates->push($date->format('Y-m-d'));
    }

    $timeSlots = Price::select('start_time', 'end_time')->distinct()->get();

    // Truyền danh sách sân con sang view
    return view('admin.bookings.index', compact('fields', 'subFields', 'bookings', 'dates', 'timeSlots'));
}


    // Xem chi tiết đặt sân
    public function show($id)
    {
        $booking = Booking::with(['user', 'subField'])->findOrFail($id);
        return view('admin.bookings.show', compact('booking'));
    }

    // Xác nhận đặt sân
    public function confirm($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'confirmed']);

        return redirect()->route('admin.bookings.index')->with('success', 'Lịch đặt đã được xác nhận!');
    }

    // Hủy đặt sân
    public function cancel($id)
    {
        $booking = Booking::findOrFail($id);
        $booking->update(['status' => 'cancelled']);

        return redirect()->route('admin.bookings.index')->with('error', 'Lịch đặt đã bị hủy!');
    }
}