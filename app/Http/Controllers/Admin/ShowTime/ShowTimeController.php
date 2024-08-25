<?php

namespace App\Http\Controllers\Admin\ShowTime;

use App\Http\Controllers\Controller;
use App\Models\cinema;
use App\Models\cinema_room;
use App\Models\invoice_detail;
use App\Models\movie;
use App\Models\show_time;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class ShowTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index()
    {
        $showtimes = show_time::with('movie', 'cinema_room')->get();
        // Sắp xếp và thêm thuộc tính isPast cho mỗi suất chiếu
        $showtimes = $showtimes->sortByDesc(function ($showtime) {
            return Carbon::parse($showtime->start_date . ' ' . $showtime->start_time);
        })->map(function ($showtime) {
            $showtime->isPast = Carbon::parse($showtime->start_date . ' ' . $showtime->start_time)->isPast();
            return $showtime;
        });
        $movies = movie::all();
        $cinema_rooms = cinema_room::all();
        $cinemas = cinema::all();
        return view('admin.show_time.show_time', compact('showtimes', 'movies', 'cinema_rooms', 'cinemas'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Lấy thông tin về phim
    $movie = movie::find($request->movie_id);
    $movie_time = $movie->time; // Giả sử 'duration' là số phút chiếu phim, kiểu int

    // Tính thời gian kết thúc của suất chiếu mới
    $start_time = Carbon::parse($request->start_date . ' ' . $request->start_time);
    $end_time = $start_time->copy()->addMinutes($movie_time + 15); // Thêm 15 phút dọn dẹp

    // Kiểm tra xem có suất chiếu nào khác trong cùng rạp và phòng chiếu bị trùng giờ không
    $conflicting_showtimes = show_time::where('cinema_room_id', $request->cinema_room_id)
        ->where(function ($query) use ($start_time, $end_time, $movie_time) {
            $query->where(function ($query) use ($start_time, $end_time) {
                $query->where('start_date', $start_time->toDateString())
                    ->whereTime('start_time', '<', $end_time->toTimeString())
                    ->whereTime('start_time', '>=', $start_time->toTimeString());
            })
            ->orWhere(function ($query) use ($start_time, $end_time, $movie_time) {
                $query->where('start_date', $start_time->toDateString())
                    ->whereTime('start_time', '<', $start_time->toTimeString())
                    ->whereRaw("DATE_ADD(start_time, INTERVAL ? MINUTE) > ?", [$movie_time + 15, $start_time->toTimeString()]);
            });
        })
        ->exists();

    if ($conflicting_showtimes) {
        return redirect()->back()->with('error', 'Suất chiếu này trùng giờ với suất chiếu khác!');
    }

    // Nếu không có trùng lặp, tiến hành lưu suất chiếu mới
    $show_time = new show_time();
    $show_time->movie_id = $request->movie_id;
    $show_time->cinema_room_id = $request->cinema_room_id;
    $show_time->start_date = $request->start_date;
    $show_time->start_time = $request->start_time;
    $show_time->save();

    return redirect()->back()->with('success', 'Suất chiếu đã được thêm thành công!');
        // $show_time = new show_time();
        // $show_time->movie_id = $request->movie_id;
        // $show_time->cinema_room_id = $request->cinema_room_id;

        // // $show_time->start_time = request('start_time');
        // $show_time->start_date = $request->start_date;
        // $show_time->start_time = $request->start_time;
        // $show_time->save();
        
        // return redirect()->back()->with('success', 'Suất chiếu đã được thêm thành công!');
    }

    /**
     * Display the specified resource.
     */
    public function show(show_time $show_time)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(show_time $show_time)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $show_time = show_time::find($id);
        if ($show_time) {
            $show_time->movie_id = $request->movie_id;
            $show_time->cinema_room_id = $request->cinema_room_id;
            $show_time->start_date = $request->start_date;
            $show_time->start_time = $request->start_time;
            $show_time->save();
            return redirect()->back()->with('success', 'Suất chiếu đã được cập nhật thành công!');
        } else {
            return redirect()->back()->with('error', 'Không tìm thấy suất chiếu!');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $show_time = show_time::find($id);
        $invoice_detail = invoice_detail::where('showtime_id', $id)->first();
        if($invoice_detail!=null)
        {
            return redirect()->back()->with('error', 'Suất chiếu đã tồn tại hóa đơn! (không thể xóa)');
        }
        if ($show_time) {
            $show_time->delete();
            return redirect()->back()->with('success', 'Suất chiếu đã được xóa thành công!');
        } else {
            return redirect()->back()->with('error', 'Không tìm thấy suất chiếu!');
        }
    }
    // public function getCinemaRooms($cinema_id)
    // {
    //     $cinema = Cinema::find($cinema_id);
    //     $cinema_rooms = $cinema->cinemaRooms()->pluck('cinema_room_name', 'cinema_room_id');
    //     return response()->json($cinema_rooms);
    // }
    public function getCinemaRooms($cinemaId)
    {
        $cinema_rooms = cinema_room::where('cinema_id', $cinemaId)->get();

        return response()->json($cinema_rooms);
    }
}
