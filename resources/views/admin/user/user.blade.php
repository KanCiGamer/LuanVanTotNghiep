@extends('layouts.admin_home')

@section('content')
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Quản lý người dùng</h4>
                           
                        </div>
                        <div class="card-body">
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
                            <div class="table-responsive">
                                <table class="table">
                                    <thead class="text-primary">
                                        <th>Tên người dùng</th>
                                        <th>Email</th>
                                        <th>Số điện thoại</th>
                                        <th>Giới tính</th>
                                        <th>Ngày sinh</th>
                                        <th>Trạng thái</th>
                                        <th></th>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->user_name }}</td>
                                            <td>{{ $user->user_email }}</td>
                                            <td>{{ $user->user_phone }}</td>
                                            <td>{{ $user->user_gender == 1 ? 'Nam' : 'Nữ'}}</td>
                                            <td>{{ $user->user_date_of_birth }}</td>
                                            <td>
                                                <form action="{{ route('UpdateStatus', $user->user_id) }}" method="POST">
                                                    @csrf
                                                    @method('PUT')
                                                    <select name="block" class="form-control" onchange="this.form.submit()"> 
                                                        <option value="0" {{ $user->block == 0 ? 'selected' : '' }}>Hoạt động</option>
                                                        <option value="1" {{ $user->block == 1 ? 'selected' : '' }}>Bị khóa</option>
                                                    </select>
                                                </form>
                                            </td>
                                            <td>
                                                {{-- <form action="{{ route('ShowUserInfor', $user->user_id) }}" method="POST">
                                                    @csrf
                                                    @method('GET')
                                                    <button type="submit" value="Chi tiết"></button>
                                                </form> --}}
                                                <a href="{{ route('ShowUserInfor', $user->user_id) }}" class="btn btn-info btn-sm mr-2">
                                                    <i class="bi bi-eye"></i> Xem
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="d-flex justify-content-center">
                                {{ $users->links() }} 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Lấy dữ liệu từ nút "Sửa" và hiển thị lên modal
            $('.edit-showtime').click(function() {
                console.log("da nhan");
                const showtimeId = $(this).data('id');
                const movieId = $(this).data('movie-id');
                const cinemaRoomId = $(this).data('cinema-room-id');
                const startTime = $(this).data('start-time');
                const startDate = $(this).data('start-date');

                $('#edit_showtime_id').val(showtimeId);
                $('#edit_movie_id').val(movieId);
                $('#edit_cinema_room_id').val(cinemaRoomId);
                $('#edit_start_time').val(startTime);
                $('#edit_start_date').val(startDate);

                $('#editShowtimeForm').attr('action', `/admin/stime/${showtimeId}`);
            });
        });
        $(document).ready(function() {
            $('#cinema_id').change(function() {
                let cinemaId = $(this).val();
                console.log("da nhan 2");
                if (cinemaId) {
                    $.ajax({
                        url: '/get-cinema-rooms/' + cinemaId,
                        type: 'GET',
                        success: function(data) {
                            $('#cinema_room_id').empty();
                            $('#cinema_room_id').append(
                                '<option value="">Chọn phòng chiếu</option>');
                            $('#cinema_room_id').show();
                            $.each(data, function(key, room) {
                                $('#cinema_room_id').append('<option value="' + room
                                    .cinema_room_id + '">' + room.cinema_room_name +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('#cinema_room_id').empty();
                    $('#cinema_room_id').hide();
                }
            });
        });
        $(document).ready(function() {
            $('#edit_cinema_id').change(function() {
                let cinemaId = $(this).val();
                console.log("da nhan 2");
                if (cinemaId) {
                    $.ajax({
                        url: '/get-cinema-rooms/' + cinemaId,
                        type: 'GET',
                        success: function(data) {
                            $('#edit_cinema_room_id').empty();
                            $('#edit_cinema_room_id').append(
                                '<option value="">Chọn phòng chiếu</option>');
                            $('#edit_cinema_room_id').show();
                            $.each(data, function(key, room) {
                                $('#edit_cinema_room_id').append('<option value="' +
                                    room
                                    .cinema_room_id + '">' + room.cinema_room_name +
                                    '</option>');
                            });
                        }
                    });
                } else {
                    $('#edit_cinema_room_id').empty();
                    $('#edit_cinema_room_id').hide();
                }
            });
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