<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        body {
            background-color: #A3C1DA; /* Màu xanh dương pastel */
        }
        .footer {
            display: flex;
            justify-content: space-between;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .footer-column {
            flex: 1;
            padding: 10px;
        }
    </style>
    {{ title }}
    <title>@yield('title', 'Trang Layout')</title>
</head>
<body>
    <header class="d-flex justify-content-between align-items-center p-3">
        <div class="logo">
            <h1>Logo</h1>
        </div>
        <div>
            <button class="btn btn-primary">Đăng Nhập</button>
            <button class="btn btn-secondary">Đăng Ký</button>
        </div>
    </header>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="#">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Thông tin cá nhân</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Danh sách sân</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Quản lý lịch đặt</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Liên hệ</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Đánh giá</a></li>
            </ul>
        </div>
    </nav>

    <main class="container mt-4">
        @yield('content')
    </main>

    <footer class="footer">
        <div class="footer-column">
            <h5>Thông tin liên hệ</h5>
            <p>Số điện thoại: 0123456789</p>
            <p>Email: example@example.com</p>
            <p><a href="#">Facebook</a></p>
        </div>
        <div class="footer-column">
            <h5>Các chính sách và điều khoản</h5>
            <p>Chính sách bảo mật</p>
            <p>Điều khoản sử dụng</p>
        </div>
        <div class="footer-column text-center">
            <button onclick="window.scrollTo(0, 0);" class="btn btn-info">Quay lại đầu trang</button>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
