
@extends('layouts.home')

@section('noi-dung')
<link rel="stylesheet" href="{{ asset('css/payment_info.css') }}">
    <div class="container">
        <h1 class="mt-5">Thông tin thanh toán</h1>

        <h2 class="mt-5">Chi tiết suất chiếu</h2>
        <p><strong>Ngày chiếu:</strong> {{ $data['showtime']->start_date }}</p>
        <p><strong>Giờ chiếu:</strong> {{ $data['showtime']->start_time }}</p>
        <p><strong>Rạp:</strong> {{ $data['cinema']->name }}</p>
        <p><strong>Phòng:</strong> {{ $data['cinema_room']->cinema_room_name }}</p>
        <p><strong>Địa chỉ:</strong> {{ $data['cinema']->address }}</p>
        <p><strong>Ghế đã chọn:</strong>
            @foreach ($seat as $value)
                {{ $value }}
                @if (!$loop->last)
                    ,
                @endif
            @endforeach
        </p>
        <p><strong>Tổng giá tiền:</strong>
            {{ number_format($data['totalPrice'], 0, ',', '.') }} VNĐ
        </p>

        <!-- Thêm hiển thị thời gian -->
        <div>
            <strong>Thời gian còn lại để thanh toán:</strong> 
            <span id="countdown"></span>
        </div>

        <form id="payment-form" method="POST" action="{{ route('Payment') }}">
            @csrf
            @if (Auth::guard('users')->check())
                <input type="hidden" name="user_id" value="{{ Auth::guard('users')->user()->user_id }}">
                <input type="hidden" name="email" value="{{ Auth::guard('users')->user()->user_email }}">
                <input type="hidden" name="phone" value="{{ Auth::guard('users')->user()->user_phone }}">
                <div class="form-group">
                    <label for="discount_code">Mã giảm giá (nếu có):</label>
                    <input type="text" class="form-control" id="discount_code" name="discount_code">
                    @if ($errors->any())
                        <div id="alert" style="margin-top: 10px;">
                            @foreach ($errors->all() as $error)
                                <p style="color: red;">{{ $error }}</p>
                            @endforeach
                        </div>
                    @endif
                </div>
            @else
                <div class="form-group">
                    <label for="email">Email:</label>   
                    <input type="email" class="form-control" id="email" name="email" required>
                    <label for="email">Số điện thoại:</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
            @endif
           
            <button type="submit" class="btn btn-success mt-3">Xác nhận thanh toán</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            // Thời gian hiển thị thông báo lỗi (3000ms = 3 giây)
            setTimeout(function() {
                $('#alert').fadeOut('slow');
            }, 3000);

            // Thêm đếm ngược thời gian
            function startCountdown(expireTime) {
                var countdownElement = document.getElementById('countdown');
                var expireDate = new Date(expireTime).getTime();
                
                var countdown = setInterval(function() {
                    var now = new Date().getTime();
                    var distance = expireDate - now;

                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                    countdownElement.innerHTML = minutes + " phút " + seconds + " giây";

                    if (distance < 0) {
                        clearInterval(countdown);
                        countdownElement.innerHTML = "Hết hạn";
                        alert('Thời gian đã hết hạn. Vui lòng chọn lại ghế.');
                        window.location.href = '/'; // Hoặc bất kỳ URL nào để chọn lại ghế
                    }
                }, 1000);
            }

            var expireTime = @json(session('expire_time'));
            startCountdown(expireTime);

            $('#payment-form').on('submit', function(e) {
                e.preventDefault();

                const seats = @json(session('ticket.seats'));
                const showtimeId = {{ session('ticket.showtime_id') }};

                $.ajax({
                    url: '{{ route("checkSeatsExpiration") }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        showtime_id: showtimeId,
                        seats: seats
                    },
                    success: function(response) {
                        if (response.expired) {
                            alert('Một hoặc nhiều ghế đã hết hạn. Vui lòng chọn lại.');
                            window.location.href = '/'; // Hoặc bất kỳ URL nào để chọn lại ghế
                        } else {
                            $('#payment-form')[0].submit();
                        }
                    },
                    error: function() {
                        alert('Có lỗi xảy ra. Vui lòng thử lại.');
                    }
                });
            });
        });
    </script>
@endsection
