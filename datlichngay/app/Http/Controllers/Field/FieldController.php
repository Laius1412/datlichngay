<?php

namespace App\Http\Controllers\Field;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\SubField;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    public function index()
    {
        $fields = Field::with('subFields')->get(); // Lấy cả sub-fields
        return view('admin.field', compact('fields'));
    }

    public function create()
    {
        return view('admin.field_create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'ward' => 'required|string',
            'district' => 'required|string',
            'city' => 'required|string',
            'sub_fields' => 'nullable|array', // Không bắt buộc nhập sub_fields
            'sub_fields.*.name' => 'required_with:sub_fields|string',
            'sub_fields.*.type' => 'required_with:sub_fields|string',
            'sub_fields.*.status' => 'required_with:sub_fields|string',
        ]);

        // Tạo sân chính
        $field = Field::create($request->only(['name', 'location', 'ward', 'district', 'city']));

        // Thêm các sub-fields nếu có
        if ($request->has('sub_fields')) {
            foreach ($request->sub_fields as $subField) {
                $field->subFields()->create($subField);
            }
        }

        return redirect()->route('fields.index')->with('success', 'Sân bóng và các sân con được thêm thành công.');
    }

    public function edit($id)
    {
        $field = Field::with('subFields')->findOrFail($id);
        return view('admin.field_edit', compact('field'));
    }
    

    public function update(Request $request, $id)
    {
        $field = Field::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'location' => 'required|string',
            'ward' => 'required|string',
            'district' => 'required|string',
            'city' => 'required|string',
            'sub_fields' => 'nullable|array',
            'sub_fields.*.name' => 'required_with:sub_fields|string',
            'sub_fields.*.type' => 'required_with:sub_fields|string',
            'sub_fields.*.status' => 'required_with:sub_fields|string',
        ]);

        // Cập nhật sân chính
        $field->update($request->only(['name', 'location', 'ward', 'district', 'city']));

        // Cập nhật hoặc tạo mới sub-fields
        if ($request->has('sub_fields')) {
            foreach ($request->sub_fields as $subFieldData) {
                SubField::updateOrCreate(
                    ['field_id' => $field->id, 'name' => $subFieldData['name']],
                    $subFieldData
                );
            }
        }

        return redirect()->route('fields.index')->with('success', 'Sân bóng và các sân con được cập nhật thành công.');
    }

    public function destroy($id)
    {
        $field = Field::findOrFail($id);
        
        // Xóa các sub-fields trước khi xóa sân chính
        $field->subFields()->delete();
        $field->delete();

        return redirect()->route('fields.index')->with('success', 'Sân bóng đã bị xóa.');
    }
}
