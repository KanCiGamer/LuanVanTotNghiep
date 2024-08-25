@extends('layouts.admin_home')

@section('content')


        <h1 style="text-align: center;">QUẢN LÝ PHÒNG CHIẾU</h1>
        <div class="container" style="margin-top: 30px;">
            <div style="margin-bottom: 30px;text-align:right;">
                <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#addModal"><i class="bi bi-plus"></i> Thêm</button>
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
                @foreach ($cinemaroom as $room)
                    <div class="col-md-4 mb-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Phòng: {{ $room->cinema_room_name }}</h5>
                                <p class="card-text">
                                    <strong>Rạp:</strong> {{ $room->cinema->name }}
                                </p>
                                <div class="d-flex justify-content-end">
                                    <button type="button" class="btn btn-primary btn-sm mr-2 edit-button"
                                        data-toggle="modal" data-target="#editModal"
                                        data-id="{{ $room->cinema_room_id }}"
                                        data-name="{{ $room->cinema_room_name }}"
                                        data-cinema-id="{{ $room->cinema_id }}">
                                        Chỉnh sửa
                                    </button>
                                    <form action="{{ route('DeleteCinemaRoom', $room->cinema_room_id) }}"
                                        method="POST" style="display: inline;">
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

        <!-- Modal Thêm Phòng Chiếu -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">Thêm Phòng Chiếu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="{{ route('AddCinemaRoom') }}" method="POST" id="addCinemaRoomForm">
                        @csrf
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="cinema_room_name">Tên Phòng Chiếu:</label>
                                <input type="text" class="form-control" id="cinema_room_name" name="cinema_room_name"
                                    required>
                            </div>
                            <div class="form-group">
                                <label for="cinema_id">Rạp:</label>
                                <select class="form-control" id="cinema_id" name="cinema_id">
                                    @foreach ($cinemas as $cinema)
                                        <option value="{{ $cinema->cinema_id }}">{{ $cinema->name }}</option>
                                    @endforeach
                                </select>
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

        <!-- Modal Chỉnh Sửa Phòng Chiếu -->
        <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Chỉnh Sửa Phòng Chiếu</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <form action="" method="POST" id="updateCinemaRoomForm">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <input type="hidden" id="edit_cinema_room_id" name="id">
                            <div class="form-group">
                                <label for="edit_cinema_room_name">Tên Phòng Chiếu:</label>
                                <input type="text" class="form-control" id="edit_cinema_room_name"
                                    name="cinema_room_name" required>
                            </div>
                            <div class="form-group">
                                <label for="edit_cinema_id">Rạp:</label>
                                <select class="form-control" id="edit_cinema_id" name="cinema_id">
                                    @foreach ($cinemas as $cinema)
                                        <option value="{{ $cinema->cinema_id }}">{{ $cinema->name }}</option>
                                    @endforeach
                                </select>
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var roomId = button.data('id');
            var roomName = button.data('name');
            var cinemaId = button.data('cinema-id');

            console.log('Room ID:', roomId);
            console.log('Room Name:', roomName);

            var modal = $(this);
            modal.find('.modal-body #edit_cinema_room_id').val(roomId);
            modal.find('.modal-body #edit_cinema_room_name').val(roomName);
            modal.find('.modal-body #edit_cinema_id').val(cinemaId);

            modal.find('form').attr('action', '/admin/room/' + roomId);
        });

        //         $('#updateCinemaRoomForm').on('submit', function(event) {
        //     event.preventDefault(); 

        //     var formData = new FormData(this);
        //     formData.forEach((value, key) => {
        //         console.log(key + ": " + value);
        //     });

        //     $.ajax({
        //         url: $(this).attr('action'),
        //         type: 'PUT', // Chú ý phương thức là PUT
        //         data: formData,
        //         processData: false,
        //         contentType: false,
        //         success: function(response) {
        //             console.log('Phòng chiếu đã được cập nhật thành công!');
        //             $('#editModal').modal('hide'); 
        //             // Thêm logic để cập nhật bảng danh sách phòng chiếu
        //         },
        //         error: function(error) {
        //             console.error('Lỗi khi cập nhật phòng chiếu:', error);
        //         }
        //     });
        // });
        // Xử lý submit form thêm phòng chiếu (sử dụng Ajax)
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