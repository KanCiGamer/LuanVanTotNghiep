<?php

namespace App\Http\Controllers\User;

use App\Models\cinema;
use App\Models\cinema_room;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\discount_code;
use App\Models\invoice;
use App\Models\invoice_detail;
use App\Models\movie;
use App\Models\show_time;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class VNPayController extends Controller
{
    
    public function showPaymentPage()
    {
        $ticket = session()->get('ticket');
        $showtime = show_time::findOrFail($ticket['showtime_id']);
        $cinema_room = cinema_room::findOrFail($showtime->cinema_room_id);
        $cinema = cinema::findOrFail($cinema_room->cinema_id);
        $movie = movie::findOrFail($showtime->movie_id);
        $pricePerSeat = $movie->price;
        $totalPrice = $pricePerSeat * count($ticket['seats']);
        $data = [
            'showtime' => $showtime,
            'cinema_room' => $cinema_room,
            'cinema' => $cinema,
            'movie' => $movie,
            'totalPrice' => $totalPrice,
        ];
        return view('payments.payment_information', ['ticket' => $ticket, 'data' => $data]);
    }

    public function payment(Request $request)
    {

        $ticket = session()->get('ticket');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $discount_code = $request->input('discount_code');
        $discountValue = 0;
        if ($request->input('discount_code')) {
            $discountCode = discount_code::where('code', $discount_code)->first();
            if (!$discountCode) {
                return redirect()->back()->withErrors(['discount_code' => 'Mã giảm giá không hợp lệ!']);
            }
            $discountValue = $discountCode->discount_percentage;
        }

        // Xóa ghế đã hết hạn
        DB::table('reserved_seats')->where('expires_at', '<', now())->delete();

        // Kiểm tra trạng thái của các ghế
        $expiredSeats = DB::table('reserved_seats')
            ->where('showtime_id', $ticket['showtime_id'])
            ->whereIn('seat_id', $ticket['seats'])
            ->where('expires_at', '<', now())
            ->pluck('seat_id')
            ->toArray();

        if (!empty($expiredSeats)) {
            return redirect()->back()->withErrors(['seats' => 'Một hoặc nhiều ghế đã hết hạn. Vui lòng chọn lại.']);
        }

        $invoiceId = Str::random(10);

        $showtime = show_time::findOrFail($ticket['showtime_id']);
        $movie = movie::findOrFail($showtime->movie_id);
        $pricePerSeat = $movie->price;
        $totalPrice = $pricePerSeat * count($ticket['seats']);

        // Áp dụng giảm giá nếu có
        if ($discountValue > 0) {
            $totalPrice -= ($totalPrice * $discountValue / 100);
        }
        DB::beginTransaction();
        
        $invoiceData = [
            'invoice_id' => $invoiceId,
            'date_created' => now(),
            'email_kh' => $email,
            'phone_kh' => $phone,
            'user_id' => null,
            'discount_code_id' => $discount_code,
            'seats' => $ticket['seats'],
            'showtime_id' => $ticket['showtime_id'],
            'total' => $totalPrice,
        ];
        Cache::put('invoiceData', $invoiceData, now()->addMinutes(5));
        session()->put('invoiceData', $invoiceData);
        session()->save();
        $newExpiresAt = now()->addMinutes(5);
        DB::table('reserved_seats')
            ->where('showtime_id', $ticket['showtime_id'])
            ->whereIn('seat_id', $ticket['seats'])
            ->update([
                'reserved_at' => now(),
                'expires_at' => $newExpiresAt,
            ]);
        if (!empty($expiredSeatsAfterUpdate)) {
            return redirect()->back()->withErrors(['seats' => 'Một hoặc nhiều ghế đã hết hạn sau khi cập nhật. Vui lòng chọn lại.']);
        }
        //dd(session()->all());
        return $this->redirectToVnpay($invoiceId, $invoiceData);
    }

    public function redirectToVnpay($invoiceId, $arr)
    {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $vnp_TxnRef = $invoiceId; // mã giao dịch
        $vnp_Amount = $arr['total']; // Số tiền thanh toán
        $vnp_Locale = "vn";
        $vnp_BankCode = ""; //Mã phương thức thanh toán (để trống để tích hợp sẵn)
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR']; //IP Khách hàng thanh toán
        $vnp_TmnCode = config('services.vnpay.tmn_code'); // Client ID
        $vnp_HashSecret = config('services.vnpay.hash_secret'); //Secret key
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html"; // url thanh toán
        $vnp_Returnurl = "http://localhost:8000/payment-result"; // url trả về kết quả
        $startTime = date("YmdHis"); // lấy thời gian hiện tại
        $expire = date('YmdHis', strtotime('+5 minutes', strtotime($startTime))); // thêm 15 phút (thời gian hết hạn)
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount * 100,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => "Thanh toan GD: " . $vnp_TxnRef,
            "vnp_OrderType" => "other",
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
            "vnp_ExpireDate" => $expire
        );
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash =   hash_hmac('sha512', $hashdata, "K498EBPTORKXQUZYVW0HAQL9BUFW0BI8"); //  
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        
        return redirect($vnp_Url);
        die();
    }
    public function VNPayResult(Request $request)
    {
        //dd(session()->all());
        $inputData = $request->all();
        $vnp_HashSecret = config('services.vnpay.hash_secret');
        
        // Kiểm tra chữ ký hợp lệ
        $secureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
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

        $secureHashCheck = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        //dd($secureHashCheck, $secureHash);
        if ($secureHash == $secureHashCheck) {
            if ($inputData['vnp_ResponseCode'] == '00') {

                DB::beginTransaction();
                try {
                    //$invoiceData = Cache::get('invoiceData');
                    $invoiceData = session()->get('invoiceData');
                    //dd($invoiceData);
                    $invoice = Invoice::create([
                        'invoice_id' => $invoiceData['invoice_id'],
                        'date_created' => now(),
                        'email_kh' => $invoiceData['email_kh'],
                        'phone_kh' => $invoiceData['phone_kh'],
                        'user_id' => null,
                        'discount_code_id' => $invoiceData['discount_code_id'],
                        'price_total' => $invoiceData['total']
                    ]);

                    foreach ($invoiceData['seats'] as $seatId) {
                        $detail = invoice_detail::create([
                            'invoice_id' => $invoice->invoice_id,
                            'showtime_id' => $invoiceData['showtime_id'],
                            'seat_id' => $seatId,
                            'price' => 100000
                        ]);
                        //dd($invoiceData, $invoice->invoice_id, $detail);
                    }
                    $emailData = [
                        'invoice' => $invoice,
                        'invoiceDetails' => $detail,
                    ];
                    DB::commit();
                    Mail::to($invoice->email_kh)->send(new \App\Mail\Invoice($emailData));
                    session()->forget('ticket');
                    session()->forget('invoiceData');
                } catch (\Exception $e) {
                    DB::rollBack();
                    $errorMessage = $e->getMessage();
                    return view('payments.payment_return_infor', compact('inputData', 'errorMessage'));
                }
                
                return view('payments.payment_return_infor', compact('inputData'));
            } else if ($inputData['vnp_ResponseCode'] == '15') {
                $errorMessage = 'Hết thời gian thanh toán';
                session()->forget('ticket');
                session()->forget('invoiceData');
                DB::table('reserved_seats')->where('expires_at', '<', now())->delete();
                return view('payments.payment_return_infor', compact('inputData', 'errorMessage'));
            } else if ($inputData['vnp_ResponseCode'] == '24') {
                $errorMessage = 'Hủy thanh toán';
                $ticket = session()->get('ticket');
                DB::table('reserved_seats')
                    ->where('showtime_id', $ticket['showtime_id'])
                    ->whereIn('seat_id', $ticket['seats'])
                    ->delete();
                session()->forget('ticket');
                session()->forget('invoiceData');
                //DB::table('reserved_seats')->where('expires_at', '<', now())->delete();
                return view('payments.payment_return_infor', compact('inputData', 'errorMessage'));
            } else {
                // Thanh toán thất bại, xử lý lỗi
                $errorMessage = 'Thanh toán thất bại.';
                session()->forget('ticket');
                session()->forget('invoiceData');
                return view('payments.payment_return_infor', compact('inputData', 'errorMessage'));
            }
        } else {
            // Chữ ký không hợp lệ
            $errorMessage = 'Chữ ký không hợp lệ.';
            return view('payments.payment_return_infor', compact('inputData', 'errorMessage'));
        }
    }
}
