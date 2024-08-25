<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Document</title>
    <style>
        * {
            margin: 0px;
            padding: 0px;
            box-sizing: border-box;
            font-family: "Anton", sans-serif;
        }

        .menu input[type=text] {
            width: 100%;
            padding: 12px 20px;
            margin: 8px 0;
            display: inline-block;
            border: 1px solid #ccc;
            box-sizing: border-box;
            border-radius: 5px;
        }

        a {
            text-decoration: none;
            font-size: 23px;
            color: black;
            transition: 0.5s;
        }

        a:hover {
            color: #f9f9f9;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2);
            z-index: 9999;
        }

        .dropdown-content a {
            color: black;
            padding: 5px 15px;
            text-decoration: none;
            display: block;
        }

        .drop-down:hover .dropdown-content {
            display: block;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .filter-button {
            background-color: #FFFAE6;
            /* Màu nền cho nút lọc */
            color: black;
            /* Màu chữ */
            border-radius: 5px;
            /* Bo góc nút */
            padding: 5px;
            height: 50px;
            /* Khoảng cách bên trong nút */
            cursor: pointer;
            /* Con trỏ chuột khi hover */
            margin-right: 5px;
            /* Khoảng cách giữa nút lọc và thanh tìm kiếm */
        }

        .filter-button:hover {
            background-color: #f9f9f9;
            /* Màu nền khi hover */
        }

        /* CSS cho footer */
        .footer {
            background-color: #FF5F00;
            padding: 30px 0;
            margin-top: 30px;
            /* Tạo khoảng cách với nội dung chính */
            text-align: -webkit-center;
        }

        .footer-container {
            display: flex;
            justify-content: space-around;
            /* Chia cột đều nhau */
            flex-wrap: wrap;
            /* Cho phép xuống dòng trên màn hình nhỏ */
        }

        .footer .col {
            width: 25%;
            /* Điều chỉnh độ rộng cột tùy ý */
            margin-bottom: 20px;
        }

        .footer h4 {
            color: #333;
            margin-bottom: 15px;
        }

        .footer ul {
            list-style: none;
            padding: 0;
        }

        .footer ul li {
            margin-bottom: 10px;
        }

        .footer ul li a {
            color: #555;
            font-size: 14px;
        }
    </style>
</head>

<body>
    <div class="navbar2" style="background-color: #FF5F00; padding: 25px; ">
        <div class="content" style="display: flex; align-items:center; justify-content: space-between;">
            <div class="logo">
                <a href="{{ route('home') }}">
                    <div
                        style="padding: 35px; background-image: url('{{ asset('images/logo/logo.png') }}'); margin-left: 100px; background-size:cover;">
                    </div>
                </a>

            </div>
            <div class="menu" style="display: flex; align-items:center; width: 60%; justify-content: space-evenly;">
                <div style="display: flex; align-items:center;">
                    <button class="filter-button">
                        <i class="bi bi-funnel"></i> Lọc
                    </button>
                    <div class="filter-menu"
                        style="display: none; position: absolute; background-color: #f9f9f9; border: 1px solid #ddd; box-shadow: 0px 8px 16px 0px rgba(0, 0, 0, 0.2); z-index: 9999; margin-top: 100px;">
                        <form action="{{route('Filter')}}" method="GET">
                            <!-- Thêm các tùy chọn lọc ở đây -->
                            <label for="category">Thời gian:</label>
                            <select name="start_time" id="category">
                                <option value="all">Tất cả</option>
                                <option value="morning">06:00 - 11:59</option>
                                <option value="afternoon">12:00 - 17:59</option>
                                <option value="evening">18:00 - 21:59</option>
                                <option value="night">22:00 - 23:59</option>
                            </select>
                            <button type="submit"
                                style="margin-top: 10px; padding: 10px; background-color: #FF5F00; color: white; border: none; border-radius: 5px;">Áp
                                dụng</button>
                        </form>
                    </div>
                    {{-- <input type="text" placeholder="Tìm phim, rạp"
                        style="border-radius: 100rem; font-size: 1.4rem; font-weight:400; height: 4rem; line-height: 1; width: 100%; padding: 0 3rem 0 1.6rem;"> --}}
                    <form action="{{ route('Search') }}" method="GET"
                        style="display: flex; align-items: center; width: 100%;">
                        <input type="text" name="query" placeholder="Tìm phim"
                            style="border-radius: 100rem; font-size: 1.4rem; font-weight: 400; height: 4rem; line-height: 1; width: 100%; padding: 0 3rem 0 1.6rem; margin-right:5px;">
                        <button type="submit" style="border: none; background-color: transparent; cursor: pointer;">
                            <i class="bi bi-search" style="font-size: 1.4rem; color: #FF5F00;"></i>
                        </button>
                    </form>
                </div>
                @if (Auth::guard('users')->check())
                    <div class="drop-down">
                        <a class="link" href="#"
                            style="    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;"><i
                                class="bi bi-person-circle"></i>
                            {{ Auth::guard('users')->user()->user_name }}
                            {{-- Tài khoản --}}
                        </a>
                        <div class="dropdown-content">
                            <a href="{{ route('UserPage', Auth::guard('users')->user()->user_id) }}">Thông tin</a>
                            <a href="#" id="logout">Đăng xuất</a>
                        </div>
                    </div>
                @else
                    <a class="link" href="{{ route('LoginPage') }}"><i class="bi bi-person-circle"></i> Tài khoản</a>
                @endif
            </div>
        </div>
    </div>
    <div class="noi-dung">
        @yield('noi-dung')
    </div>

    <footer class="footer">
        <div class="footer-container">
            <div class="col">
                <h4>Thông tin</h4>
                <ul>
                    <li><a href="#">Về chúng tôi</a></li>
                    <li><a href="#">Liên hệ</a></li>
                    <li><a href="#">Điều khoản dịch vụ</a></li>
                    <li><a href="#">Chính sách bảo mật</a></li>
                </ul>
            </div>

            <div class="col">
                <h4>Hỗ trợ</h4>
                <ul>
                    <li><a href="#">Câu hỏi thường gặp</a></li>
                    <li><a href="#">Hướng dẫn đặt vé</a></li>
                    <li><a href="#">Phương thức thanh toán</a></li>
                    <li><a href="#">Liên hệ: 0931987215</a></li>
                </ul>
            </div>

            <div class="col">
                <h4>Kết nối</h4>
                <ul>
                    <li><a href="https://www.facebook.com/KanCiGamer" target="_blank"><i class="bi bi-facebook"></i>
                            Facebook</a></li>
                    <li><a href="https://github.com/KanCiGamer" target="_blank"><i class="bi bi-github"></i> Github</a>
                    </li>
                    <li><a href="https://www.youtube.com/c/KanCiGamer" target="_blank"><i class="bi bi-youtube"></i>
                            YouTube</a></li>
                </ul>
            </div>
        </div>
        <p style="text-align: center; margin-top: 20px;">© 2024 My Website. All rights reserved.</p>
    </footer>

    <script>
        $(document).ready(function() {
            $('#logout').click(function(e) {
                e.preventDefault();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('UserLogout') }}',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function() {
                        window.location.href = '{{ route('home') }}';
                    }
                });
            });
        });
        $(document).ready(function() {
            $('.filter-button').click(function() {
                $('.filter-menu').toggle(); // Hiển thị hoặc ẩn menu lọc
            });
        });
    </script>
</body>

</html>
