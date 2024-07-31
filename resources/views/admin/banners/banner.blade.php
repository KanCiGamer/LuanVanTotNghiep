<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Quản lý Banner</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
        }

        .sidebar {
            height: 100vh;
            width: 200px;
            background-color: #f0f0f0;
            position: fixed;
            left: 0;
            top: 0;
        }

        .sidebar .profile {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid #ddd;
        }

        .sidebar .profile img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar li {
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }

        .sidebar li a {
            text-decoration: none;
            color: #333;
        }

        .content {
            margin-left: 200px;
            padding: 20px;
        }

        .modal-header {
            background-color: #f0f0f5;
        }

        .card-header {
            background-color: #e9ecef;
        }
        .container{
            margin-top: 30px;
        }
    </style>
</head>
<body>
    <div class="sidebar">
        <div class="profile">
            <i class="bi bi-person-circle"></i>
            <h3>Administrator</h3>
            <a href="#">Đăng xuất</a>
        </div>
        <ul>
            <li><a href="{{ route('AdminPage') }}">Số liệu</a></li>
            <li><a href="{{ route('ShowMovies') }}">Phim</a></li>
            <li><a href="{{ route('ShowCategories') }}">Thể loại</a></li>
            <li><a href="{{ route('ShowCinemas') }}">Rạp phim</a></li>
            <li><a href="{{ route('ShowCinemaRoom') }}">Phòng chiếu</a></li>
            <li><a href="{{ route('ShowSType') }}">Loại ghế</a></li>
            <li><a href="{{ route('ShowSeat') }}">Ghế</a></li>
            <li><a href="{{ route('ShowTime') }}">Suất chiếu</a></li>
            <li><a href="{{ route('ShowUser')}}">Người dùng</a></li>
            <li><a href="{{ route('ShowDiscount') }}">Mã giảm giá</a></li>
            <li><a href="{{ route('ShowBanners') }}">Banner</a></li>
        </ul>
    </div>

    <div class="content" id="content">
        <h1 style="text-align: center;">QUẢN LÝ BANNER</h1>
        <div class="container" style="margin-top: 30px;">
            <div class="text-right" style="margin-bottom: 30px;">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">
                    <i class="bi bi-plus"></i> Thêm Banner
                </button>
            </div>

            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            <table id="bannersTable" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th class="text-center">ID</th>
                        <th class="text-center">Hình ảnh</th>
                        <th class="text-center">Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($banner as $value)
                        <tr>
                            <td class="text-center">{{ $value->id }}</td>
                            <td class="text-center">
                                @if ($value->image_path)
                                    <img src="{{ asset('images/banner/' . $value->image_path) }}" alt="Banner Image" width="100">
                                @else
                                    Không có hình ảnh
                                @endif
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-primary edit-button" data-toggle="modal"
                                    data-target="#editModal" data-id="{{ $value->id }}"
                                    data-image-path="{{ $value->image_path }}" style="margin-right: 10px;">
                                    Chỉnh sửa
                                </button>
                                <form action="{{ route('DeleteBanners', $value->id) }}" method="POST"
                                    style="display: inline; margin-left: 10px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Xóa</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Modal Thêm Banner -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Thêm Banner</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('AddBanners') }}" method="POST" id="addBannerForm" enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="image_path">Hình ảnh:</label>
                                <input type="file" class="form-control-file" id="image_path" name="banner" required>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Thêm</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Chỉnh Sửa Banner -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Chỉnh Sửa Banner</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="" method="POST" id="updateBannerForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" id="edit_banner_id" name="id">
                            <div class="form-group">
                                <label for="edit_image_path">Banner:</label>
                                <input type="file" class="form-control-file" id="edit_image_path" name="banner">
                                <label for="">Banner hiện tại:</label>
                                <img id="current-image" src="" alt="Current Banner Image" width="100" style="display:none;">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
                            <button type="submit" class="btn btn-primary">Cập nhật</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var imagePath = button.data('image-path');
            var modal = $(this);
            modal.find('.modal-body #edit_banner_id').val(id);
            modal.find('form').attr('action', '/admin/banner/' + id);

            if (imagePath) {
                modal.find('#current-image').attr('src', `{{ asset('images/banner/${imagePath}') }}`).show();
            } else {
                modal.find('#current-image').hide();
            }
        });

        $(document).ready(function() {
            // Ẩn phần thông báo thành công sau 2 giây
            setTimeout(function() {
                $('.alert-success').fadeOut('slow');
            }, 2000);

            // Ẩn phần thông báo lỗi sau 2 giây
            setTimeout(function() {
                $('.alert-danger').fadeOut('slow');
            }, 2000);
        });
    </script>
</body>
</html>