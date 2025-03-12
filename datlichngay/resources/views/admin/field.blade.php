@extends('layouts.layout_admin')

@section("title", "Quản lý sân bóng")

@section('content')
    <h2>Quản lý sân bóng</h2>

    <!-- Nút Thêm Sân -->
    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addFieldModal">+ Thêm sân</button>

    <!-- Bảng danh sách sân -->
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên sân</th>
                <th>Địa điểm</th>
                <th>Phần sân</th>
                <th>Loại sân</th>
                <th>Tình trạng</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($fields as $field)
                <tr>
                    <td rowspan="{{ count($field->subFields) }}">{{ $field->name }}</td>
                    <td rowspan="{{ count($field->subFields) }}">{{ $field->location }}</td>
                    @foreach($field->subFields as $index => $subField)
                        @if($index > 0)
                            <tr>
                        @endif
                        <td>{{ $subField->name }}</td>
                        <td>{{ $subField->type }}</td>
                        <td>{{ $subField->status }}</td>
                        @if($index == 0)
                            <td rowspan="{{ count($field->subFields) }}">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editFieldModal" 
                                    data-id="{{ $field->id }}" 
                                    data-name="{{ $field->name }}" 
                                    data-location="{{ $field->location }}" 
                                    data-ward="{{ $field->ward }}" 
                                    data-district="{{ $field->district }}" 
                                    data-city="{{ $field->city }}" 
                                    data-subfields="{{ json_encode($field->subFields) }}">
                                    Sửa
                                </button>
                                <form action="{{ route('fields.destroy', $field->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        @endif
                        @if($index > 0)
                            </tr>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Modal Thêm Sân -->
    <div class="modal fade" id="addFieldModal" tabindex="-1" aria-labelledby="addFieldModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addFieldModalLabel">Thêm mới sân</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('fields.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="name">Tên sân ★</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="location">Vị trí ★</label>
                            <input type="text" name="location" class="form-control" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="ward">Phường/Xã ★</label>
                                <input type="text" name="ward" class="form-control" required>
                            </div>
                            <div class="col">
                                <label for="district">Quận/Huyện ★</label>
                                <input type="text" name="district" class="form-control" required>
                            </div>
                            <div class="col">
                                <label for="city">Tỉnh/Thành phố ★</label>
                                <input type="text" name="city" class="form-control" required>
                            </div>
                        </div>

                        <h3>Phần sân ★</h3>
                        <div id="subFieldsContainer">
                            <div class="subField mb-3">
                                <div class="row">
                                    <div class="col">
                                        <label>Phần sân ★</label>
                                        <input type="text" name="sub_fields[0][name]" class="form-control" required>
                                    </div>
                                    <div class="col">
                                        <label>Loại sân ★</label>
                                        <select name="sub_fields[0][type]" class="form-control">
                                            <option value="7vs7">7vs7</option>
                                            <option value="9vs9">9vs9</option>
                                            <option value="11vs11">11vs11</option>
                                        </select>
                                    </div>
                                    <div class="col">
                                        <label>Tình trạng sân ★</label>
                                        <select name="sub_fields[0][status]" class="form-control">
                                            <option value="Hoạt động">Hoạt động</option>
                                            <option value="Bảo trì">Bảo trì</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="button" class="btn btn-secondary" onclick="addSubField()">+ Thêm phần sân</button>

                        <div class="mb-3">
                            <label for="images">Ảnh của sân (Cần ít nhất 3 ảnh) ★</label>
                            <input type="file" name="images[]" class="form-control" multiple required>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Thêm mới</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Chỉnh Sửa Sân -->
    <div class="modal fade" id="editFieldModal" tabindex="-1" aria-labelledby="editFieldModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editFieldModalLabel">Chỉnh sửa sân</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editFieldForm" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="edit_name">Tên sân ★</label>
                            <input type="text" name="name" id="edit_name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="edit_location">Vị trí ★</label>
                            <input type="text" name="location" id="edit_location" class="form-control" required>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="edit_ward">Phường/Xã ★</label>
                                <input type="text" name="ward" id="edit_ward" class="form-control" required>
                            </div>
                            <div class="col">
                                <label for="edit_district">Quận/Huyện ★</label>
                                <input type="text" name="district" id="edit_district" class="form-control" required>
                            </div>
                            <div class="col">
                                <label for="edit_city">Tỉnh/Thành phố ★</label>
                                <input type="text" name="city" id="edit_city" class="form-control" required>
                            </div>
                        </div>

                        <h3>Phần sân ★</h3>
                        <div id="editSubFieldsContainer">
                            <!-- Phần sân sẽ được thêm động ở đây -->
                        </div>

                        <button type="button" class="btn btn-secondary" onclick="addEditSubField()">+ Thêm phần sân</button>

                        <div class="mb-3">
                            <label for="edit_images">Ảnh của sân (Cần ít nhất 3 ảnh) ★</label>
                            <input type="file" name="images[]" id="edit_images" class="form-control" multiple>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Chỉnh sửa</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Hàm thêm phần sân trong modal thêm mới
    function addSubField() {
        let container = document.getElementById('subFieldsContainer');
        let subFieldCount = container.querySelectorAll('.subField').length;
        let newField = document.createElement('div');
        newField.classList.add('subField', 'mb-3');
        newField.innerHTML = `
            <div class="row">
                <div class="col">
                    <label>Phần sân ★</label>
                    <input type="text" name="sub_fields[${subFieldCount}][name]" class="form-control" required>
                </div>
                <div class="col">
                    <label>Loại sân ★</label>
                    <select name="sub_fields[${subFieldCount}][type]" class="form-control">
                        <option value="7vs7">7vs7</option>
                        <option value="9vs9">9vs9</option>
                        <option value="11vs11">11vs11</option>
                    </select>
                </div>
                <div class="col">
                    <label>Tình trạng sân ★</label>
                    <select name="sub_fields[${subFieldCount}][status]" class="form-control">
                        <option value="Hoạt động">Hoạt động</option>
                        <option value="Bảo trì">Bảo trì</option>
                    </select>
                </div>
            </div>
        `;
        container.appendChild(newField);
    }

    // Hàm thêm phần sân trong modal chỉnh sửa
    function addEditSubField() {
        let container = document.getElementById('editSubFieldsContainer');
        let subFieldCount = container.querySelectorAll('.subField').length;
        let newField = document.createElement('div');
        newField.classList.add('subField', 'mb-3');
        newField.innerHTML = `
            <div class="row">
                <div class="col">
                    <label>Phần sân ★</label>
                    <input type="text" name="sub_fields[${subFieldCount}][name]" class="form-control" required>
                </div>
                <div class="col">
                    <label>Loại sân ★</label>
                    <select name="sub_fields[${subFieldCount}][type]" class="form-control">
                        <option value="7vs7">7vs7</option>
                        <option value="9vs9">9vs9</option>
                        <option value="11vs11">11vs11</option>
                    </select>
                </div>
                <div class="col">
                    <label>Tình trạng sân ★</label>
                    <select name="sub_fields[${subFieldCount}][status]" class="form-control">
                        <option value="Hoạt động">Hoạt động</option>
                        <option value="Bảo trì">Bảo trì</option>
                    </select>
                </div>
            </div>
        `;
        container.appendChild(newField);
    }

    // Xử lý khi modal chỉnh sửa được hiển thị
    document.getElementById('editFieldModal').addEventListener('show.bs.modal', function (event) {
        let button = event.relatedTarget;
        let id = button.getAttribute('data-id');
        let name = button.getAttribute('data-name');
        let location = button.getAttribute('data-location');
        let ward = button.getAttribute('data-ward');
        let district = button.getAttribute('data-district');
        let city = button.getAttribute('data-city');
        let subFields = JSON.parse(button.getAttribute('data-subfields'));

        // Điền thông tin vào form
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_location').value = location;
        document.getElementById('edit_ward').value = ward;
        document.getElementById('edit_district').value = district;
        document.getElementById('edit_city').value = city;

        // Xóa các phần sân cũ
        let container = document.getElementById('editSubFieldsContainer');
        container.innerHTML = '';

        // Thêm các phần sân mới
        subFields.forEach((subField, index) => {
            let newField = document.createElement('div');
            newField.classList.add('subField', 'mb-3');
            newField.innerHTML = `
                <div class="row">
                    <div class="col">
                        <label>Phần sân ★</label>
                        <input type="text" name="sub_fields[${index}][name]" class="form-control" value="${subField.name}" required>
                    </div>
                    <div class="col">
                        <label>Loại sân ★</label>
                        <select name="sub_fields[${index}][type]" class="form-control">
                            <option value="7vs7" ${subField.type === '7vs7' ? 'selected' : ''}>7vs7</option>
                            <option value="9vs9" ${subField.type === '9vs9' ? 'selected' : ''}>9vs9</option>
                            <option value="11vs11" ${subField.type === '11vs11' ? 'selected' : ''}>11vs11</option>
                        </select>
                    </div>
                    <div class="col">
                        <label>Tình trạng sân ★</label>
                        <select name="sub_fields[${index}][status]" class="form-control">
                            <option value="Hoạt động" ${subField.status === 'Hoạt động' ? 'selected' : ''}>Hoạt động</option>
                            <option value="Bảo trì" ${subField.status === 'Bảo trì' ? 'selected' : ''}>Bảo trì</option>
                        </select>
                    </div>
                </div>
            `;
            container.appendChild(newField);
        });

        // Cập nhật action của form
        document.getElementById('editFieldForm').action = `/admin/fields/update/${id}`;
    });
</script>
@endsection