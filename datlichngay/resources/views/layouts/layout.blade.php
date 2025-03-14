<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trang Layout')</title>
    
    <!-- Bootstrap & Font Awesome -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <style>
        /* Màu chủ đạo */
        :root {
            --main-color: #A3C1DA; /* Xanh dương pastel */
            --text-color: #333;
            --white: #fff;
        }

        body {
            background-color: var(--main-color);
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Header */
        .header {
            background-color: var(--main-color);
            color: var(--white);
            padding: 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        .header .logo {
            font-size: 24px;
            font-weight: bold;
            display: flex;
            align-self: center;
            justify-self: center;
        }

        .header-buttons {
            display: flex;
            gap: 10px;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            height: calc(100vh - 60px); /* Trừ đi chiều cao header */
            background-color: var(--main-color);
            position: fixed;
            left: 0;
            top: 60px; /* Để không bị đè lên header */
            display: flex;
            flex-direction: column;
            align-items: center;
            padding-top: 20px;
        }

        .sidebar .logo {
            font-size: 28px;
            font-weight: bold;
            color: var(--white);
            margin-bottom: 20px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            width: 100%;
            margin-top: 0;
        }

        .sidebar ul li {
            padding: 12px;
            text-align: left;
        }

        .sidebar ul li a {
            color: var(--white);
            text-decoration: none;
            display: flex;
            align-items: center;
            padding-left: 20px;
        }

        .sidebar ul li a i {
            margin-right: 10px;
        }

        .menu {
            margin-top: 0; /* Giữ menu bắt đầu ngay dưới header */
        }

        /* Nội dung chính */
        .content {
            margin-left: 250px;
            padding: 20px;
            background-color: var(--white);
            min-height: calc(100vh - 120px); /* Trừ đi header + footer */
            margin-top: 60px; /* Để không bị che bởi header */
        }

        /* Footer */
        .footer {
            background-color: var(--main-color);
            color: var(--white);
            padding: 20px;
            text-align: center;
            position: relative;
            width: 100%;
        }

        .footer .footer-column {
            padding: 0 20px;
            display: inline-block;
            vertical-align: top;
        }

        /* Nút quay lại đầu trang */
        .scroll-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            background-color: var(--main-color);
            color: var(--white);
            border: 1px solid black;
            height: 30px;
            width: 30px;
            border-radius: 50%;
            display: none;
            font-size: 14px;
            cursor: pointer;
        }

        .scroll-to-top:hover {
            background-color: #8aa8c0;
        }

        .dropdown-menu {
            z-index: 1050; /* Đảm bảo nó hiển thị trên các phần khác */
        }
    </style>
</head>
<body>

    <!-- Header -->
    <div class="header">
        <div class="logo">Logo</div>
        <div class="header-buttons">
            <div class="ml-auto">
                @auth
                <div class="d-flex align-items-center">
                    <span class="mr-2"><i class="fas fa-user"></i> {{ Auth::user()->email }}</span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
                @else
                    <a href="{{ route('login') }}" class="btn btn-light">Đăng nhập</a>
                    <a href="{{ route('register') }}" class="btn btn-light">Đăng ký</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">LOGO</div>
        <ul class="menu">
            <li><a href="{{ url('/') }}" class="text-light"><i class="fas fa-home"></i> Trang chủ</a></li>
            <li><a href="{{ route('profile.edit_customer') }}" class="text-light"><i class="fas fa-user"></i> Thông tin cá nhân</a></li>
            <li><a href="{{ route('fields.index') }}" class="text-light"><i class="fas fa-futbol"></i> Danh sách sân</a></li>
            <li><a href="{{ route('bookingsmanagement.index') }}"><i class="fas fa-calendar-alt" class="text-light"></i> Quản lý lịch đặt</a></li>
            <li><a href="#"><i class="fas fa-envelope" class="text-light"></i> Liên hệ</a></li>
            <li><a href="#"><i class="fas fa-star" class="text-light"></i> Đánh giá</a></li>
        </ul>
    </div>

    <!-- Nội dung -->
    <div class="content">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer">
        <div class="footer-column">
            <h5>Thông tin liên hệ</h5>
            <p>📞 Số điện thoại: 0123456789</p>
            <p>📧 Email: example@example.com</p>
            <p><a href="#" class="text-light"><i class="fab fa-facebook"></i> Facebook</a></p>
        </div>
        <div class="footer-column">
            <h5>Các chính sách và điều khoản</h5>
            <p>🔒 Chính sách bảo mật</p>
            <p>📜 Điều khoản sử dụng</p>
        </div>
    </footer>

    <!-- Nút quay lại đầu trang -->
    <button class="scroll-to-top" onclick="window.scrollTo({ top: 0, behavior: 'smooth' });">
        <i class="fas fa-arrow-up"></i>
    </button>

    <script>
        // Hiển thị nút khi cuộn xuống
        window.onscroll = function () {
            let btn = document.querySelector(".scroll-to-top");
            if (document.documentElement.scrollTop > 100) {
                btn.style.display = "block";
            } else {
                btn.style.display = "none";
            }
        };

        // Đóng dropdown khi click ra ngoài
        $(document).on("click", function (event) {
            var $trigger = $(".dropdown");
            if ($trigger !== event.target && !$trigger.has(event.target).length) {
                $(".dropdown-menu").removeClass("show");
            }
        });

        // Hiển thị dropdown đúng cách
        $("#userDropdown").on("click", function (event) {
            event.stopPropagation();
            $(".dropdown-menu").toggleClass("show");
        });
    </script>

    <!-- jQuery & Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</htm>
