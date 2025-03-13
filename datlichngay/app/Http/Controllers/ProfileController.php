<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Hiển thị form chỉnh sửa thông tin cá nhân.
     *
     * @return \Illuminate\View\View
     */
    // Chỉnh sửa thông tin của chủ sân
    public function editAdmin()
    {
        $user = Auth::user();
        
        // Kiểm tra nếu user không phải admin thì chặn lại
        // if ($user->role !== 'admin') {
        //     return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập!');
        // }

        return view('profile.edit', compact('user'));
    }

    // Chỉnh sửa thông tin của khách hàng
    public function editCustomer()
    {
        $user = Auth::user();

        // Kiểm tra nếu user không phải khách hàng thì chặn lại
        if ($user->role !== 'customer') {
            return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập!');
        }

        return view('profile.edit_customer', compact('user'));
    }

    /**
     * Cập nhật thông tin cá nhân của người dùng.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Validate dữ liệu đầu vào
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'phone' => ['required', 'string', 'max:15', Rule::unique('users')->ignore($user->id)],
            'dob' => 'required|date',
            'gender' => 'required|string|in:Nam,Nữ,Khác',
            'cccd' => ['required', 'string', 'max:12', Rule::unique('users')->ignore($user->id)],
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'ward' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'password' => 'nullable|min:6|confirmed',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Chỉ chấp nhận file ảnh dưới 2MB
        ]);

        // Xử lý upload ảnh đại diện
        if ($request->hasFile('avatar')) {
            // Lưu ảnh vào thư mục storage/app/public/avatars
            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $avatarPath;
        }

        // Cập nhật thông tin người dùng
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'cccd' => $request->cccd,
            'city' => $request->city,
            'district' => $request->district,
            'ward' => $request->ward,
            'address' => $request->address,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
            'avatar' => $user->avatar, // Cập nhật avatar nếu có
        ]);

        return redirect()->route('profile.edit')->with('success', 'Cập nhật thông tin thành công!');
    }
}
