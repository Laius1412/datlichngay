@extends('layouts.layout_admin')

@section('content')
<div class="container">
    <h2>Quản lý khách hàng</h2>

    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th></th>
                <th>Tên KH</th>
                <th>Ngày Sinh</th>
                <th>SDT</th>
                <th>Địa Chỉ</th>
                <th>Tác Vụ</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($customers as $customer)
            <tr>
                <td><input type="checkbox"></td>
                <td>{{ $customer->name }}</td>
                <td>{{ $customer->dob }}</td>
                <td>{{ $customer->phone }}</td>
                <td>{{ $customer->address }}</td>
                <td>
                    <a href="{{ route('admin.customers.show', $customer->id) }}" class="btn btn-warning">Chi tiết</a>
                    <button class="btn btn-danger" onclick="confirmDelete({{ $customer->id }})">Xóa</button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal xác nhận xóa -->
<div id="deleteModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Thông báo</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Bạn có chắc chắn muốn xóa khách hàng này không?</p>
            </div>
            <div class="modal-footer">
                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-success">YES</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">NO</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal thông báo xóa thành công -->
<div id="successModal" class="modal fade" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">Thông báo</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <p>Tài khoản đã được xóa thành công!</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<!-- Script -->
<script>
    function confirmDelete(customerId) {
        let form = document.getElementById("deleteForm");
        form.action = "/admin/customers/" + customerId;
        $('#deleteModal').modal('show');
    }

    @if(session('success'))
        $(document).ready(function() {
            $('#successModal').modal('show');
        });
    @endif
</script>
@endsection
