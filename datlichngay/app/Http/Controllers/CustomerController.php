<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class CustomerController extends Controller
{
    // Hiển thị danh sách khách hàng
    public function index()
    {
        $customers = User::where('role', 'customer')->get(); // Lọc danh sách khách hàng
        return view('admin.customers.index', compact('customers'));
    }

    // Hiển thị chi tiết khách hàng
    public function show($id)
    {
        $customer = User::findOrFail($id);
        return view('admin.customers.show', compact('customer'));
    }

    // Xóa khách hàng
    public function destroy($id)
    {
        $customer = User::findOrFail($id);
        $customer->delete();
        return redirect()->route('admin.customers.index')->with('success', 'Khách hàng đã bị xóa.');
    }
}
