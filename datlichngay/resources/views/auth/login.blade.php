@extends('layouts.layout')

@section("title", "Đăng nhập")

@section('content')
<div class="container d-flex justify-content-center align-items-center" style="height: 80vh;">
    <div class="card p-4" style="width: 350px;">
        <h4 class="text-center">Đăng nhập</h4>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-3">
                <select name="role" class="form-control" required>
                    <option value="">Chọn vai trò*</option>
                    <option value="customer">Khách hàng</option>
                    <option value="owner">Chủ sân</option>
                </select>
            </div>
            <div class="mb-3">
                <input type="text" name="login" class="form-control" placeholder="Địa chỉ email hoặc số điện thoại*" required>
            </div>
            <div class="mb-3">
                <input type="password" name="password" class="form-control" placeholder="Mật khẩu*" required>
            </div>
            <div class="d-flex justify-content-between mb-3">
                <a href="#">Quên mật khẩu?</a>
            </div>
            <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
        </form>
        <div class="text-center mt-3">
            Bạn chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a>
        </div>
        <div class="text-center mt-2">
            <a href="#">Điều khoản</a> | <a href="#">Chính sách</a>
        </div>
    </div>
</div>
@endsection
