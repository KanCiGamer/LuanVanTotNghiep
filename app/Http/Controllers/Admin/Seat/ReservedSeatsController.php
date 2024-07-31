<?php

namespace App\Http\Controllers\Admin\Seat;

use App\Models\reserved_seats;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReservedSeatsController extends Controller
{
    public function reserveSeat(Request $request)
    {
        $validated = $request->validate([
            'showtime_id' => 'required|exists:show_times,showtime_id',
            'seat_id' => 'required|exists:seats,seat_id',
        ]);

        try {
            DB::beginTransaction();

            // Kiểm tra xem ghế đã được bán hay chưa
            $isSeatSold = DB::table('invoice_details')
                ->where('showtime_id', $validated['showtime_id'])
                ->where('seat_id', $validated['seat_id'])
                ->exists();

            if ($isSeatSold) {
                return response()->json(['error' => 'Ghế đã được bán!'], 409);
            }

            // Kiểm tra xem ghế đã được giữ bởi người khác chưa
            $isSeatReserved = DB::table('reserved_seats')
                ->where('showtime_id', $validated['showtime_id'])
                ->where('seat_id', $validated['seat_id'])
                ->where('expires_at', '>', now())
                ->exists();

            if ($isSeatReserved) {
                return response()->json(['error' => 'Ghế đang được giữ!'], 409);
            }

            // Lưu thông tin giữ chỗ vào database
            reserved_seats::create([
                'showtime_id' => $validated['showtime_id'],
                'seat_id' => $validated['seat_id'],
                'expires_at' => now()->addMinutes(5), // Hết hạn sau 5 phút
            ]);

            DB::commit();

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Đã xảy ra lỗi!'], 500);
        }
    }
    public function checkSeatsExpiration(Request $request)
    {
        $showtimeId = $request->input('showtime_id');
        $seats = $request->input('seats');

        $expiredSeats = reserved_seats::whereIn('seat_id', $seats)
            ->where('showtime_id', $showtimeId)
            ->where('expires_at', '<', now())
            ->exists();

        return response()->json(['expired' => $expiredSeats]);
    }
}
