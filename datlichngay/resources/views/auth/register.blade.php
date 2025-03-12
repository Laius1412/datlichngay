@extends('layouts.layout')
@section("title", "Đăng ký")
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header text-center"><h3>Sign up</h3></div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    <form method="POST" action="{{ route('register') }}">
                        @csrf

                        <div class="form-group">
                            <label>* Họ và tên:</label>
                            <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>* Số điện thoại:</label>
                            <input type="text" name="phone" class="form-control" required value="{{ old('phone') }}">
                            @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>* Ngày sinh:</label>
                            <input type="date" name="dob" class="form-control" required value="{{ old('dob') }}">
                            @error('dob') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>* Email:</label>
                            <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>* Mật khẩu:</label>
                            <input type="password" name="password" class="form-control" required>
                            @error('password') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="form-group">
                            <label>* Xác nhận mật khẩu:</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>

                        <div class="form-group form-check">
                            <input type="checkbox" name="agree" class="form-check-input" required>
                            <label class="form-check-label">Đồng ý với <a href="#">Điều khoản</a> và <a href="#">Chính sách</a></label>
                            @error('agree') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Đăng ký</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
