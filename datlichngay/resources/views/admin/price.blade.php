@extends('layouts.layout_admin')

@section('title', 'Quản lý giá sân')

@section('content')
    <h2>Quản lý giá sân</h2>

    <!-- Bảng danh sách giá sân -->
    <table class="table table-bordered">
    <thead>
        <tr>
            <th onclick="sortTable()" style="cursor: pointer;">
                Tên sân 
                <span id="sortIcon">🔽</span> <!-- Biểu tượng sắp xếp -->
            </th>
            <th>Phần sân</th>
            <th>Loại sân</th>
            <th>Khung giờ</th>
            <th>Giá</th>
            <th>Tác vụ</th>
        </tr>
    </thead>
    <tbody>
        @foreach($subFields as $index => $subField)
            @foreach($subField->prices as $priceIndex => $price)
                <tr>
                    @if($priceIndex === 0)
                        <td rowspan="{{ count($subField->prices) }}" class="field-name">{{ $subField->field->name }}</td>
                        <td rowspan="{{ count($subField->prices) }}">{{ $subField->name }}</td>
                        <td rowspan="{{ count($subField->prices) }}">{{ $subField->type }}</td>
                    @endif
                    <td>{{ $price->start_time }} -> {{ $price->end_time }}</td>
                    <td>{{ number_format($price->price, 0, ',', '.') }}K/ca</td>
                    @if($priceIndex === 0)
                        <td rowspan="{{ count($subField->prices) }}">
                            <!-- Nút chỉnh sửa, mở modal -->
                            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editPriceModal"
                                data-subfield-id="{{ $subField->id }}"
                                data-subfield-name="{{ $subField->field->name }}"
                                data-subfield-type="{{ $subField->type }}"
                                data-prices="{{ json_encode($subField->prices) }}">
                                Sửa
                            </button>
                        </td>
                    @endif
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>

    <!-- Modal chỉnh sửa giá sân -->
    <div class="modal fade" id="editPriceModal" tabindex="-1" aria-labelledby="editPriceModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editPriceModalLabel">Chỉnh sửa giá sân</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editPriceForm" method="POST">
                        @csrf
                        <!-- Không sử dụng @method('PUT') nữa -->

                        <div class="mb-3">
                            <label>Tên sân</label>
                            <input type="text" class="form-control" id="editSubFieldName" readonly>
                        </div>

                        <div class="mb-3">
                            <label>Loại sân</label>
                            <input type="text" class="form-control" id="editSubFieldType" readonly>
                        </div>

                        <h3>Khung giờ và giá</h3>
                        <div id="priceContainer">
                            <!-- Các khung giờ và giá sẽ được thêm vào đây -->
                        </div>

                        <button type="button" class="btn btn-secondary" onclick="addPriceField()">+ Thêm khung giờ</button>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                            <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Hàm thêm khung giờ và giá vào modal
    function addPriceField() {
        let container = document.getElementById('priceContainer');
        let index = container.querySelectorAll('.price-item').length;
        let newPrice = document.createElement('div');
        newPrice.classList.add('price-item', 'mb-3');
        newPrice.innerHTML = `
            <div class="row">
                <div class="col">
                    <label>Khung giờ</label>
                    <input type="time" name="prices[${index}][start_time]" class="form-control" required>
                    <input type="time" name="prices[${index}][end_time]" class="form-control" required>
                </div>
                <div class="col">
                    <label>Giá</label>
                    <input type="number" name="prices[${index}][price]" class="form-control" required>
                </div>
            </div>
        `;
        container.appendChild(newPrice);
    }

    // Xử lý khi modal chỉnh sửa được hiển thị
    document.getElementById('editPriceModal').addEventListener('show.bs.modal', function (event) {
        let button = event.relatedTarget;
        let subFieldId = button.getAttribute('data-subfield-id');
        let subFieldName = button.getAttribute('data-subfield-name');
        let subFieldType = button.getAttribute('data-subfield-type');
        let prices = JSON.parse(button.getAttribute('data-prices'));

        // Điền thông tin vào modal
        document.getElementById('editSubFieldName').value = subFieldName;
        document.getElementById('editSubFieldType').value = subFieldType;

        // Xóa các khung giờ cũ
        let container = document.getElementById('priceContainer');
        container.innerHTML = '';

        // Thêm các khung giờ và giá vào modal
        prices.forEach((price, index) => {
            let newPrice = document.createElement('div');
            newPrice.classList.add('price-item', 'mb-3');
            newPrice.innerHTML = `
                <div class="row">
                    <div class="col">
                        <label>Khung giờ</label>
                        <input type="time" name="prices[${index}][start_time]" class="form-control" value="${price.start_time}" required>
                        <input type="time" name="prices[${index}][end_time]" class="form-control" value="${price.end_time}" required>
                    </div>
                    <div class="col">
                        <label>Giá</label>
                        <input type="number" name="prices[${index}][price]" class="form-control" value="${price.price}" required>
                    </div>
                </div>
            `;
            container.appendChild(newPrice);
        });

        // Cập nhật action của form
        document.getElementById('editPriceForm').action = `/admin/prices/update/${subFieldId}`;
    });
    let sortAscending = true; // Mặc định sắp xếp tăng dần

    function sortTable() {
        let table = document.querySelector(".table"); // Chọn bảng
        let rows = Array.from(table.querySelectorAll("tbody tr")); // Lấy tất cả hàng trong tbody
        let tbody = table.querySelector("tbody");

        // Sắp xếp các hàng dựa trên tên sân
        rows.sort((a, b) => {
            let nameA = a.querySelector("td.field-name").textContent.trim().toLowerCase();
            let nameB = b.querySelector("td.field-name").textContent.trim().toLowerCase();
            return sortAscending ? nameA.localeCompare(nameB) : nameB.localeCompare(nameA);
        });

        sortAscending = !sortAscending; // Đảo trạng thái sắp xếp

        // Cập nhật biểu tượng sắp xếp
        document.getElementById("sortIcon").textContent = sortAscending ? "🔽" : "🔼";

        // Gán lại các hàng đã sắp xếp vào tbody
        tbody.innerHTML = "";
        rows.forEach(row => tbody.appendChild(row));
    }

</script>
@endsection