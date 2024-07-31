@extends('layouts.home')

@section('noi-dung')
<div class="container">
    <div class="header clearfix">
        <h3 class="text-muted">VNPAY RESPONSE</h3>
    </div>
    <div class="table-responsive">
        <div class="form-group">
            <label>Mã đơn hàng:</label>
            <label>{{ request()->get('vnp_TxnRef') }}</label>
        </div>    
        <div class="form-group">
            <label>Số tiền:</label>
            <label>{{ request()->get('vnp_Amount') }}</label>
        </div>  
        <div class="form-group">
            <label>Nội dung thanh toán:</label>
            <label>{{ request()->get('vnp_OrderInfo') }}</label>
        </div> 
        <div class="form-group">
            <label>Mã phản hồi (vnp_ResponseCode):</label>
            <label>{{ request()->get('vnp_ResponseCode') }}</label>
        </div> 
        <div class="form-group">
            <label>Mã GD Tại VNPAY:</label>
            <label>{{ request()->get('vnp_TransactionNo') }}</label>
        </div> 
        <div class="form-group">
            <label>Mã Ngân hàng:</label>
            <label>{{ request()->get('vnp_BankCode') }}</label>
        </div> 
        <div class="form-group">
            <label>Thời gian thanh toán:</label>
            <label>{{ request()->get('vnp_PayDate') }}</label>
        </div> 
        <div class="form-group">
            <label>Kết quả:</label>
            <label>
                @php
                    $inputData = request()->except('vnp_SecureHash');
                    ksort($inputData);
                    $hashData = "";
                    $i = 0;
                    foreach ($inputData as $key => $value) {
                        if ($i == 1) {
                            $hashData .= '&' . urlencode($key) . "=" . urlencode($value);
                        } else {
                            $hashData .= urlencode($key) . "=" . urlencode($value);
                            $i = 1;
                        }
                    }
                    $secureHash = hash_hmac('sha512', $hashData, config('services.vnpay.hash_secret'));
                @endphp

                @if ($secureHash == request()->get('vnp_SecureHash'))
                    @if (request()->get('vnp_ResponseCode') == '00')
                        <span style='color:blue'>GD Thanh cong</span>
                    @else
                        <span style='color:red'>GD Khong thanh cong</span>
                    @endif
                @else
                    <span style='color:red'>Chu ky khong hop le</span>
                @endif
            </label>
        </div> 
    </div>
    <p>
         
    </p>
    <footer class="footer">
        <p>© VNPAY {{ date('Y') }}</p>
    </footer>
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