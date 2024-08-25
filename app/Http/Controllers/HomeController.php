<?php

namespace App\Http\Controllers;

use App\Models\banners;
use App\Models\cinema;
use App\Models\discount_code;
use App\Models\invoice;
use App\Models\invoice_detail;
use App\Models\movie;
use App\Models\reserved_seats;
use App\Models\show_time;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    public function index()
    {
        $movies = movie::all();
        $dangchieu = movie::where('status', 1)->get();
        $sapchieu = movie::where('status', 0)->get();
        // $dangchieu = movie::where('status',1)->paginate(4);
        // $sapchieu = movie::where('status',0)->paginate(4);
        $banner = banners::all();
        return view('welcome', compact('dangchieu', 'sapchieu', 'banner'));
    }
    public function MovieDetail($id)
    {
        $movie = movie::with(['age_rating', 'categories', 'show_time.cinema_room.cinema'])->find($id);

        if (!$movie) {
            return redirect()->back()->with('error', 'Phim không tồn tại!');
        }

        $currentDate = Carbon::now();
        $futureShowTimes = $movie->show_time->where('start_date', '>=', $currentDate->toDateString());
        $showTimesGroupedByDate = $futureShowTimes->groupBy(function ($date) {
            $parsedDate = Carbon::parse($date->start_date);
            return $parsedDate->format('d-m'); //l
        })->toArray();

        uksort($showTimesGroupedByDate, function ($a, $b) {
            $dateA = Carbon::createFromFormat('d-m', $a); //l
            $dateB = Carbon::createFromFormat('d-m', $b); //l

            return $dateA->greaterThan($dateB) ? 1 : -1;
        });

        return view('movie.movie_detail', compact('movie', 'showTimesGroupedByDate'));
    }
    public function ShowTimeDetail($id)
    {

        DB::table('reserved_seats')->where('expires_at', '<', now())->delete();

        $showtime = show_time::with('cinema_room.seat.seat_type', 'movie')->find($id);

        if (!$showtime) {
            return response()->json(['error' => 'Suất chiếu không tồn tại!'], 404);
        }

        $showtime->cinema_room->seat = $showtime->cinema_room->seat->sortBy('seat_name');

        $soldSeats = invoice_detail::where('showtime_id', $id)->pluck('seat_id')->toArray();
        $reservedSeats = DB::table('reserved_seats')
            ->where('showtime_id', $id)
            ->where('expires_at', '>', now())
            ->pluck('seat_id')
            ->toArray();

        return response()->json([
            'showtime' => $showtime,
            'soldSeats' => $soldSeats,
            'reservedSeats' => $reservedSeats,
        ]);
    }

    public function book_ticket(Request $request)
    {


        $validated = $request->validate([
            'showtime_id' => 'required|exists:show_times,showtime_id',
            'seats' => 'required|array',
            'seats.*' => 'exists:seats,seat_id'
        ]);

        // Xóa ghế đã hết hạn
        DB::table('reserved_seats')->where('expires_at', '<', now())->delete();

        $reservedSeats = session()->get('reserved_seats', []);
        $expiresAt = now()->addMinutes(5); // Thời gian hết hạn 5 phút

        foreach ($validated['seats'] as $seatId) {
            $reservedSeats[$seatId] = [
                'seat_id' => $seatId,
                'reserved_at' => time(),
            ];

            // Lưu vào cơ sở dữ liệu
            DB::table('reserved_seats')->insert([
                'showtime_id' => $validated['showtime_id'],
                'seat_id' => $seatId,
                'reserved_at' => now(),
                'expires_at' => $expiresAt,
            ]);
        }

        session()->put('reserved_seats', $reservedSeats);
        session()->put('ticket', $validated);
        session()->put('expire_time', $expiresAt); // Lưu thời gian hết hạn vào session

        return response()->json(['success' => true]);
    }


    private function getVietnameseDayOfWeek($dayOfWeek)
    {
        $days = [
            'Monday' => 'Thứ Hai',
            'Tuesday' => 'Thứ Ba',
            'Wednesday' => 'Thứ Tư',
            'Thursday' => 'Thứ Năm',
            'Friday' => 'Thứ Sáu',
            'Saturday' => 'Thứ Bảy',
            'Sunday' => 'Chủ Nhật',
        ];

        return $days[$dayOfWeek] ?? $dayOfWeek;
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        // Validate the search query
        $request->validate([
            'query' => 'required|string|min:1|max:255',
        ]);

        // Perform the search
        $movies = Movie::where('movie_name', 'like', '%' . $query . '%')->get();
        if(sizeof($movies)==0)
        {
            $movies=null;
        }
        return view('movie.movie_search', compact('movies'));
    }
    public function filter(Request $request)
    {
        $startTime = $request->input('start_time');

        // Chuyển đổi giá trị thành thời gian cụ thể
        $timeMapping = [
            'morning' => ['06:00:00', '11:59:59'],
            'afternoon' => ['12:00:00', '17:59:59'],
            'evening' => ['18:00:00', '21:59:59'],
            'night' => ['22:00:00', '23:59:59']
        ];

        $query = show_time::query();
        //dd($query);
        $currentDate = Carbon::now();
        $futureShowTimes = show_time::where('start_date', '>=', $currentDate->toDateString());
       // dd($futureShowTimes);
        if ($startTime != 'all') {
            if (isset($timeMapping[$startTime])) {
                $start = $timeMapping[$startTime][0];
                $end = $timeMapping[$startTime][1];
                //dd($start);
                $futureShowTimes->whereBetween('start_time', [$start, $end]);
                //dd($futureShowTimes);
                
                //dd($query);
            }
        }
        //dd(is_array($futureShowTimes->get()));
        //dd($startTime);
        $showtimes = $futureShowTimes->get();
        
        //dd(is_object($showtimes));
        //dd($showtimes);
        $movie_id = [];
        for($test = 0; $test<sizeof($showtimes);$test++)
        {
            $movie_id[$showtimes[$test]['movie_id']]= "test";
            //dd($movie_id[0]);,'movie_id'
        }
        if(sizeof($showtimes)==0)
        {
            $showtimes = null;
        }
        // if(!is_array($futureShowTimes))
        // {
        //     $showtimes = null;
        // }
        //dd($movie_id);
        return view('movie.movie_filter', compact('showtimes', 'movie_id'));
    }
    public function getCinemasByDate($movieId, $date)
    {
        $formattedDate = Carbon::createFromFormat('d-m', $date)->format('Y-m-d');
        $cinemas = cinema::whereHas('cinema_rooms.show_times', function ($query) use ($movieId, $formattedDate) {
            $query->where('movie_id', $movieId)->whereDate('start_date', $formattedDate);
        })->get();
        return response()->json($cinemas);
    }
    public function getShowtimesByCinemaAndDate($movieId, $cinemaId, $date)
    {
        $formattedDate = Carbon::createFromFormat('d-m', $date)->format('Y-m-d'); // Định dạng lại ngày tháng

        $showtimes = show_time::where('movie_id', $movieId)
            ->whereHas('cinema_room', function ($query) use ($cinemaId) {
                $query->where('cinema_id', $cinemaId);
            })
            ->whereDate('start_date', $formattedDate)
            ->get();

        return response()->json($showtimes);
    }
    public function getCinemaShowtimesByDate($movieId, $date)
    {
        $formattedDate = Carbon::createFromFormat('d-m', $date)->format('Y-m-d');

        $cinemas = Cinema::with(['cinema_rooms' => function ($query) use ($movieId, $formattedDate) {
            $query->whereHas('show_times', function ($subQuery) use ($movieId, $formattedDate) {
                $subQuery->where('movie_id', $movieId)
                    ->whereDate('start_date', $formattedDate);
            })->with(['show_times' => function ($showtimeQuery) use ($formattedDate) {
                $showtimeQuery->whereDate('start_date', $formattedDate);
            }]);
        }])
            ->whereHas('cinema_rooms.show_times', function ($query) use ($movieId, $formattedDate) {
                $query->where('movie_id', $movieId)
                    ->whereDate('start_date', $formattedDate);
            })
            ->get();

        return response()->json($cinemas);
    }
    public function showing()
    {

        $movies = movie::all();
        $dangchieu = movie::where('status', 1)->get();
        //$sapchieu = movie::where('status', 0)->get();
        // $dangchieu = movie::where('status',1)->paginate(4);
        // $sapchieu = movie::where('status',0)->paginate(4);
       // $banner = banners::all();
        return view('movie.showing', compact('dangchieu'));
    }
    public function upcoming()
    {
        $movies = movie::all();
        //$dangchieu = movie::where('status', 1)->get();
        $sapchieu = movie::where('status', 0)->get();
        // $dangchieu = movie::where('status',1)->paginate(4);
        // $sapchieu = movie::where('status',0)->paginate(4);
        //$banner = banners::all();
        return view('movie.upcoming', compact( 'sapchieu'));
    }
}
