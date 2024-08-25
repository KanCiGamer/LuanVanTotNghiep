@extends('layouts.admin_home')

@section('content')

    <h1>Quản lý Ghế</h1>
    <div class="container">
        <h2 class="mt-5 mb-3">Danh sách Ghế</h2>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addModal">Thêm Ghế</button>
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
        <table class="table mt-3">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tên Ghế</th>
                    <th>Loại Ghế</th>
                    <th>Phòng Chiếu</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($seat as $s)
                    <tr>
                        <td>{{ $s->seat_id }}</td>
                        <td>{{ $s->seat_name }}</td>
                        <td>{{ $s->seat_type->name }}</td> 
                        <td>{{ $s->cinema_room->cinema_room_name }}</td> 
                        <td>
                            <button type="button" class="btn btn-primary edit-button" data-toggle="modal" data-target="#editModal" 
                            data-id="{{ $s->seat_id }}" 
                            data-name="{{ $s->seat_name }}" 
                            data-cinema_room_id="{{ $s->cinema_room_id }}" 
                            data-seat_type_id="{{ $s->seat_type_id }}">
                                Chỉnh sửa
                            </button>
                            <form action="{{ route('DeleteSeat', $s->seat_id) }}" method="POST" style="display: inline;">
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
    {{-- <div class="container">
        @foreach ($cinemaRooms as $cinemaRoom) 
            <div class="cinema-room">
                <h2>Phòng chiếu: {{ $cinemaRoom->cinema_room_name }}</h2>
                <table>
                    @php 
                        $seatsPerRow = 10; // Giả sử mỗi hàng có 10 ghế (A-J)
                        $currentRow = null; 
                    @endphp
                
                    @foreach ($cinemaRoom->seats as $seat)
                        @php
                            $rowLetter = substr($seat->seat_name, 0, 1); // Lấy chữ cái đầu tiên của tên ghế
                            $isNewRow = ($rowLetter != $currentRow);
                        @endphp
                
                        @if ($isNewRow)
                            @if ($currentRow !== null) </tr> @endif 
                            <tr> 
                            @php $currentRow = $rowLetter; @endphp 
                        @endif
                
                        <td 
                            data-seat-id="{{ $seat->seat_id }}"
                        >
                            {{ $seat->seat_name }} 
                        </td>
                    @endforeach
                
                    @if ($currentRow !== null) </tr> @endif 
                </table>
            </div>
        @endforeach
    </div> --}}

    <!-- Modal Thêm Ghế -->
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLabel">Thêm Ghế</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="{{ route('AddSeat') }}" method="POST" id="addSeatForm">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="seat_name">Tên Ghế:</label>
                            <input type="text" class="form-control" id="seat_name" name="seat_name" required>
                        </div>
                        <div class="form-group">
                            <label for="seat_type_id">Loại Ghế:</label>
                            <select class="form-control" id="seat_type_id" name="seat_type_id">
                                @foreach ($seat_type as $type)
                                    <option value="{{ $type->seat_type_id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="cinema_room_id">Phòng Chiếu:</label>
                            <select class="form-control" id="cinema_room_id" name="cinema_room_id">
                                @foreach ($cinema_room as $room)
                                    <option value="{{ $room->cinema_room_id }}">{{ $room->cinema_room_name }}</option>
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

    <!-- Modal Chỉnh Sửa Ghế -->
    <div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Chỉnh Sửa Ghế</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <form action="" method="POST" id="updateSeatForm">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <input type="hidden" id="edit_seat_id" name="id">
                        <div class="form-group">
                            <label for="edit_seat_name">Tên Ghế:</label>
                            <input type="text" class="form-control" id="edit_seat_name" name="seat_name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit_seat_type_id">Loại Ghế:</label>
                            <select class="form-control" id="edit_seat_type_id" name="seat_type_id">
                                @foreach ($seat_type as $type)
                                    <option value="{{ $type->seat_type_id }}">{{ $type->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="edit_cinema_room_id">Phòng Chiếu:</label>
                            <select class="form-control" id="edit_cinema_room_id" name="cinema_room_id">
                                @foreach ($cinema_room as $room)
                                    <option value="{{ $room->cinema_room_id }}">{{ $room->cinema_room_name }}</option>
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
            var seatId = button.data('id');
            var seatName = button.data('name');
            var cinemaRoomId = button.data('cinema_room_id'); 
            var seatTypeId = button.data('seat_type_id'); 
            console.log(seatId, seatName, cinemaRoomId, seatTypeId);
            var modal = $(this);
            modal.find('.modal-body #edit_seat_id').val(seatId);
            modal.find('.modal-body #edit_seat_name').val(seatName);
            modal.find('.modal-body #edit_cinema_room_id').val(cinemaRoomId);
            modal.find('.modal-body #edit_seat_type_id').val(seatTypeId);
            
            modal.find('form').attr('action', '/admin/seat/' + seatId); 
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