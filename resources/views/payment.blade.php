@extends('layouts.home')

@section('noi-dung')
    <div class="container">
        <h1 class="mt-5">Thông tin thanh toán</h1>

        <h2 class="mt-5">Chi tiết suất chiếu</h2>
        <p><strong>Suất chiếu ID:</strong> {{ session('ticket.showtime_id') }}</p>
        <p><strong>Ghế đã chọn:</strong>
            @foreach (session('ticket.seats') as $seat)
                {{ $seat }}@if (!$loop->last)
                    ,
                @endif
            @endforeach
        </p>
        <form id="payment-form" method="POST">
            @csrf
            @if (Auth::guard('users')->check())
            <input type="hidden" name="email" value="{{ Auth::guard('users')->user()->user_email }}">
            @else
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            @endif
            <div class="form-group">
                <span id="error-message" class="text-danger"></span>
                <label for="discount_code">Mã giảm giá (nếu có):</label>
                <input type="text" class="form-control" id="discount_code" name="discount_code">
            </div>
            <button type="submit" class="btn btn-success mt-3">Xác nhận thanh toán</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    {{-- <script>
        let errorMessage = document.querySelector('#error-message');
        document.querySelector('#payment-form').addEventListener('submit', function(e) {
            e.preventDefault();
    
            let formData = new FormData(this);
    
            fetch('/payment', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            }).then(response => {
                console.log('Raw response:', response);
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            }).then(data => {
                if (data.success) {
                    alert('Thanh toán thành công! Mã hóa đơn: ' + data.invoice_id);
                } else {
                    errorMessage.textContent = data.message;
                    alert('Thanh toán thất bại: ' + data.message);
                }
            }).catch(error => {
                console.error('Error:', error);
                alert('Đã có lỗi xảy ra. Vui lòng thử lại sau.');
            });        
        });
    </script> --}}
    <script>
        let errorMessage = document.querySelector('#error-message');
        document.querySelector('#payment-form').addEventListener('submit', function(e) {
            e.preventDefault();
    
            let formData = new FormData(this);
    
            fetch('/payment', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: formData
            }).then(response => {
                const contentType = response.headers.get('content-type');
                console.log('Content-Type:', contentType);
                if (!contentType || !contentType.includes('application/json')) {
                    return response.text().then(text => {
                        console.log('HTML Response:', text);
                        throw new Error('Expected JSON response');
                    });
                }
                return response.json();
            }).then(data => {
                console.log('Response data:', data);
                if (data.success) {
                    alert('Thanh toán thành công! Mã hóa đơn: ' + data.invoice_id);
                } else {
                    errorMessage.textContent = data.message;
                    alert('Thanh toán thất bại: ' + data.message);
                }
            }).catch(error => {
                console.error('Error:', error);
                alert('Đã có lỗi xảy ra. Vui lòng thử lại sau.');
            });
        });
    </script>
    
@endsection
