@extends('layouts.layout_admin')

@section('title', 'Chỉnh sửa thông tin cá nhân')

@section('content')
<div class="container">
    <h2 class="text-center">Quản lý thông tin cá nhân</h2>
    <div class="card p-4">
        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">
                <!-- Cột trái: Avatar -->
                <div class="col-md-4 text-center">
                    <div class="avatar-container">
                        <div class="form-group text-center">
                            <div style="width: 150px; height: 150px; border: 2px solid #ccc; display: flex; align-items: center; justify-content: center; margin: auto; position: relative;">
                                <img id="avatar-preview" 
                                    src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('default-avatar.png') }}" 
                                    width="100%" height="100%" 
                                    style="object-fit: cover; border-radius: 5px;">
                            </div>
                            <input type="file" id="avatar" name="avatar" class="d-none">
                            <button type="button" id="change-avatar-btn" class="btn btn-sm btn-secondary mt-2">
                                <i class="fas fa-camera"></i> Chọn ảnh
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Cột phải: Thông tin cá nhân -->
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-6">
                            <label for="name">Họ và tên</label>
                            <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="gender">Giới tính</label>
                            <select id="gender" name="gender" class="form-control" required>
                                <option value="Nam" {{ old('gender', $user->gender) == 'Nam' ? 'selected' : '' }}>Nam</option>
                                <option value="Nữ" {{ old('gender', $user->gender) == 'Nữ' ? 'selected' : '' }}>Nữ</option>
                                <option value="Khác" {{ old('gender', $user->gender) == 'Khác' ? 'selected' : '' }}>Khác</option>
                            </select>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="phone">Số điện thoại</label>
                            <input type="text" id="phone" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="dob">Ngày sinh</label>
                            <input type="date" id="dob" name="dob" class="form-control" value="{{ old('dob', $user->dob) }}" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label for="cccd">Căn cước công dân (CCCD)</label>
                            <input type="text" id="cccd" name="cccd" class="form-control" value="{{ old('cccd', $user->cccd) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Địa chỉ -->
            <div class="row mt-3">
                <div class="col-md-4">
                    <label for="city">Tỉnh/Thành phố</label>
                    <input type="text" id="city" name="city" class="form-control" value="{{ old('city', $user->city) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="district">Quận/Huyện</label>
                    <input type="text" id="district" name="district" class="form-control" value="{{ old('district', $user->district) }}" required>
                </div>
                <div class="col-md-4">
                    <label for="ward">Phường/Xã</label>
                    <input type="text" id="ward" name="ward" class="form-control" value="{{ old('ward', $user->ward) }}" required>
                </div>
            </div>
            <div class="form-group mt-2">
                <label for="address">Số nhà</label>
                <input type="text" id="address" name="address" class="form-control" value="{{ old('address', $user->address) }}" required>
            </div>

            <!-- Mật khẩu -->
            <div class="row mt-3">
                <div class="col-md-6">
                    <label for="password">Mật khẩu mới (để trống nếu không đổi)</label>
                    <input type="password" id="password" name="password" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="password_confirmation">Xác nhận mật khẩu</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                </div>
            </div>

            <!-- Nút Lưu & Hủy -->
            <div class="text-center mt-4">
                <button type="submit" class="btn btn-success">Lưu</button>
                <a href="{{ route('profile.edit') }}" class="btn btn-danger">Hủy</a>
            </div>
                
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('change-avatar-btn').addEventListener('click', function() {
        document.getElementById('avatar').click();
    });

    document.getElementById('avatar').addEventListener('change', function(event) {
        let file = event.target.files[0];
        if (file) {
            let reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('avatar-preview').src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });
</script>
@endsection