@extends('layouts.admin_home')

@section('content')
        <h1 style="text-align: center;">QUẢN LÝ RẠP PHIM</h1>
        <div class="container" style="margin-top: 30px;">

            <div style="margin-bottom: 30px;text-align:right;">
                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addModal"><i
                        class="bi bi-plus"></i> Thêm</button>
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

            <div class="row">
                @foreach ($cinemas as $cinema)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">{{ $cinema->name }}</h5>
                                <p class="card-text">
                                    <strong>Địa chỉ:</strong> {{ $cinema->address }}
                                </p>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary mr-2 btn-sm edit-button"
                                        data-toggle="modal" data-target="#editModal" data-id="{{ $cinema->cinema_id }}"
                                        data-name="{{ $cinema->name }}" data-address="{{ $cinema->address }}">
                                        Chỉnh sửa
                                    </button>
                                    <form action="{{ route('DeleteCinema', $cinema->cinema_id) }}" method="POST"
                                        style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Xóa</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Modal Thêm Rạp -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Thêm rạp</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('AddCinema') }}" method="POST" id="addCinemaForm">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="cinema_name">Tên rạp:</label>
                                <input type="text" class="form-control" id="cinema_name" name="cinema_name" required>
                            </div>
                            <div class="form-group">
                                <label for="cinema_address">Địa chỉ:</label>
                                <input type="text" class="form-control" id="cinema_address" name="cinema_address"
                                    required>
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

        <!-- Modal Chỉnh Sửa Rạp -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Chỉnh sửa rạp</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="" method="POST" id="updateCinemaForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" id="cinema_id" name="cinema_id">
                            <div class="form-group">
                                <label for="cinema_name">Tên rạp:</label>
                                <input type="text" class="form-control" id="cinema_name" name="cinema_name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="cinema_address">Địa chỉ:</label>
                                <input type="text" class="form-control" id="cinema_address" name="cinema_address"
                                    required>
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
            var button = $(event.relatedTarget); // Nút "Chỉnh sửa" được click
            var cinemaId = button.data('id');
            var cinemaName = button.data('name');
            var cinemaAddress = button.data('address');

            var modal = $(this);
            modal.find('.modal-body #cinema_id').val(cinemaId);
            modal.find('.modal-body #cinema_name').val(cinemaName);
            modal.find('.modal-body #cinema_address').val(cinemaAddress);
            modal.find('form').attr('action', '/admin/cinema/' + cinemaId);
        });
        $(document).ready(function() {
            // Ẩn phần thông báo thành công sau 5 giây
            setTimeout(function() {
                $('.alert-success').fadeOut('slow');
            }, 2000);

            // Ẩn phần thông báo lỗi sau 5 giây
            setTimeout(function() {
                $('.alert-danger').fadeOut('slow');
            }, 2000);
        });
    </script>
@endsection
