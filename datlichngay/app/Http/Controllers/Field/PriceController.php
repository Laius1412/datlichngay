<?php

namespace App\Http\Controllers\Field;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubField;
use App\Models\Price;

class PriceController extends Controller
{
    public function index()
    {
        $subFields = SubField::with('prices', 'field')->get();
        return view('admin.price', compact('subFields'));
    }

    public function edit($id)
    {
        $subField = SubField::with('prices', 'field')->findOrFail($id);
        return view('admin.edit_price', compact('subField'));
    }

public function update(Request $request, $id)
{
    try {
        // Tìm SubField cần cập nhật
        $subField = SubField::findOrFail($id);

        // Xóa giá cũ
        Price::where('sub_field_id', $id)->delete();

        // Kiểm tra xem request có dữ liệu không
        if (!$request->has('prices') || empty($request->prices)) {
            return back()->with('error', 'Dữ liệu giá không hợp lệ');
        }

        // Thêm giá mới
        foreach ($request->prices as $price) {
            Price::create([
                'sub_field_id' => $subField->id,
                'start_time' => $price['start_time'],
                'end_time' => $price['end_time'],
                'price' => $price['price'],
            ]);
        }

        return redirect()->route('prices.index')->with('success', 'Cập nhật giá thành công');
    } catch (\Exception $e) {
        return back()->with('error', 'Lỗi cập nhật: ' . $e->getMessage());
    }
}

}