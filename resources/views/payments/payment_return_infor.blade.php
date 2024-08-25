@extends('layouts.home')

@section('noi-dung')
    <div class="container">
            @php
                $inputData = request()->except('vnp_SecureHash');
                ksort($inputData);
                $hashData = '';
                $i = 0;
                foreach ($inputData as $key => $value) {
                    if ($i == 1) {
                        $hashData .= '&' . urlencode($key) . '=' . urlencode($value);
                    } else {
                        $hashData .= urlencode($key) . '=' . urlencode($value);
                        $i = 1;
                    }
                }
                $secureHash = hash_hmac('sha512', $hashData, config('services.vnpay.hash_secret'));
            @endphp
            <div
                style="display: flex; justify-content: center; align-items: center; margin: 40px auto;text-align:center; height: 65vh;">
                <div>
                    @if ($secureHash == request()->get('vnp_SecureHash'))
                        @if (request()->get('vnp_ResponseCode') == '00')
                        <h2 style="margin-bottom:20px;">THANH TOÁN THÀNH CÔNG</h2>
                            <p>Vui lòng kiểm tra email của bạn để xem thông tin vé phim đã mua!</p>
                            <div style="margin-top: 35px;">
                                <a href="https://mail.google.com/mail" target="_blank"
                                    style="padding: 25px;background: blanchedalmond;">MỞ EMAIL</a>
                            </div>
                        @else
                        <h2 style="margin-bottom:20px;color:red;">THANH TOÁN KHÔNG THÀNH CÔNG</h2>
                        @endif
                    @else
                    <h2 style="margin-bottom:20px;color:red;">LỖI THANH TOÁN VUI LÒNG LIÊN HỆ QUẢN TRỊ VIÊN</h2>
                    @endif

                </div>
            </div>
    @endsection

    {{-- @extends('layouts.home')

@section('noi-dung')
    <div class="container">
        <h1>Thông tin thanh toán</h1>

        @if (isset($errorMessage))
            <div class="alert alert-danger">
                {{ $errorMessage }}
            </div>
        @endif

        <p><strong>Số tiền:</strong> {{ $inputData['vnp_Amount'] }}</p>
        <p><strong>Ngân hàng:</strong> {{ $inputData['vnp_BankCode'] }}</p>
        <p><strong>Loại thẻ:</strong> {{ $inputData['vnp_CardType'] }}</p>
        <p><strong>Mã giao dịch:</strong> {{ $inputData['vnp_TransactionNo'] }}</p>
        <p><strong>Thời gian thanh toán:</strong> {{ $inputData['vnp_PayDate'] }}</p>
    </div>
@endsection --}}
