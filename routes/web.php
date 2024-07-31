<?php

use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\Banner\BannersController;
use App\Http\Controllers\Admin\Movie\CategoriesController;
use App\Http\Controllers\Admin\Movie\MovieController;

use App\Http\Controllers\Admin\Cinema\CinemaController;
use App\Http\Controllers\Admin\Cinema\CinemaRoomController;
use App\Http\Controllers\Admin\Invoice\DiscountCodeController;
use App\Http\Controllers\Admin\Seat\SeatController;
use App\Http\Controllers\Admin\Seat\SeatTypeController;
use App\Http\Controllers\Admin\Seat\ReservedSeatsController;

use App\Http\Controllers\Admin\User\UserController;
use App\Http\Controllers\HomeController;


use App\Http\Controllers\Admin\ShowTime\ShowTimeController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UsersController;
use App\Http\Controllers\User\VNPayController;
use App\Models\Users;

Route::get('/', [HomeController::class, 'index'])->name('home');

//search
Route::get('/movies/search', [HomeController::class, 'search'])->name('Search');

//filter
Route::get('/filter', [HomeController::class, 'filter'])->name('Filter');

Route::get('/movie/{id}', [HomeController::class,'MovieDetail'])->name('MovieDetail');
Route::get('/showtimes/{movieId}/{date}', [HomeController::class, 'getCinemaShowtimesByDate']);
Route::get('/showtimedetail/{id}', [HomeController::class,'ShowTimeDetail'])->name('ShowTimeSeat');
Route::post('/reserve-seat', [ReservedSeatsController::class, 'reserveSeat']);
Route::post('/check-seats-expiration', [ReservedSeatsController::class, 'checkSeatsExpiration'])->name('checkSeatsExpiration');

Route::post('/book-ticket',[HomeController::class, 'book_ticket'])->name('BookTicket');
    
// thanh toán
Route::get('/payment-information', [VNPayController::class, 'showPaymentPage'])->name('PaymentInformation');
Route::post('/payment',[VNPayController::class, 'payment'])->name('Payment');
Route::get('/payment-result', [VNPayController::class, 'VNPayResult'])->name('PaymentResult');

// trang đăng nhập/ đăng ký
Route::get('/login', function(){return view('./user/login');})->name('LoginPage');
// trang thông báo yêu cầu xác minh tài khoản
Route::get('/notify', function () {return view('./layouts/notify');})->name('VerifyNotify');

Route::get('/users/{id}', [UsersController::class, 'show'])->name('UserPage');
Route::put('/users/{id}', [UsersController::class, 'updateInfor'])->name('UserUpdateInfor');
Route::put('/users/{id}/update', [UsersController::class, 'updatePassword'])->name('UserUpdatePass');
// chức năng đăng ký, đăng nhập và đăng xuất
Route::post('/register', [UsersController::class, 'register'])->name('UserRegister');
Route::post('/login', [UsersController::class, 'login'])->name('UserLogin');
Route::post('/logout', [UsersController::class, 'logout'])->name('UserLogout');



Route::get('/verify/{token}', function ($token) {
    $user = Users::where('verification_token', $token)->first();

    if ($user) {
        $user->verification = true;
        $user->save();

        return redirect()->route('UserLogin')->with('success', 'Xác minh tài khoản thành công!');
    } else {
        return redirect()->route('VerifyNotify')->with('error', 'Xác minh thất bại!');
    }
})->name('VerifyUser');


Route::middleware('CheckUserRole')->prefix('admin')->group(function(){
    Route::get('/', [AdminHomeController::class, 'index'])->name('AdminPage');


    // categories
   Route::get('/categories',[CategoriesController::class, 'index'])->name('ShowCategories');
   Route::post('/categories', [CategoriesController::class, 'store'])->name('AddCategory');
   Route::delete('/categories/{id}', [CategoriesController::class, 'destroy'])->name('DeleteCategory');
   Route::put('/categories/{id}', [CategoriesController::class, 'update'])->name('UpdateCategory');
   
   //cinema
   Route::get('/cinema',[CinemaController::class, 'index'])->name('ShowCinemas');
   Route::post('/cinema', [CinemaController::class, 'store'])->name('AddCinema');
   Route::delete('/cinema/{id}', [CinemaController::class, 'destroy'])->name('DeleteCinema');
   Route::put('/cinema/{id}', [CinemaController::class, 'update'])->name('UpdateCinema');
   
   //cinema_room
   Route::get('/room',[CinemaRoomController::class, 'index'])->name('ShowCinemaRoom');
   Route::post('/room', [CinemaRoomController::class, 'store'])->name('AddCinemaRoom');
   Route::delete('/room/{id}', [CinemaRoomController::class, 'destroy'])->name('DeleteCinemaRoom');
   Route::put('/room/{id}', [CinemaRoomController::class, 'update'])->name('UpdateCinemaRoom');
   
   //seat_type
   Route::get('/stype',[SeatTypeController::class, 'index'])->name('ShowSType');
   Route::post('/stype', [SeatTypeController::class, 'store'])->name('AddSType');
   Route::delete('/stype/{id}', [SeatTypeController::class, 'destroy'])->name('DeleteSType');
   Route::put('/stype/{id}', [SeatTypeController::class, 'update'])->name('UpdateSType');
   
   //seat
   Route::get('/seat',[SeatController::class, 'index'])->name('ShowSeat');
   Route::post('/seat', [SeatController::class, 'store'])->name('AddSeat');
   Route::delete('/seat/{id}', [SeatController::class, 'destroy'])->name('DeleteSeat');
   Route::put('/seat/{id}', [SeatController::class, 'update'])->name('UpdateSeat');
   
   //movie
   Route::get('/movies', [MovieController::class, 'index'])->name('ShowMovies');
   Route::post('/movies', [MovieController::class, 'store'])->name('AddMovie');
   Route::get('/movies/{id}', [MovieController::class, 'show'])->name('ShowMovie');
   Route::put('/movies/{id}', [MovieController::class, 'update'])->name('UpdateMovie');
   Route::delete('/movies/{id}', [MovieController::class, 'destroy'])->name('DeleteMovie');
   
   //show_time
   Route::get('/stime',[ShowTimeController::class, 'index'])->name('ShowTime');
   Route::post('/stime', [ShowTimeController::class, 'store'])->name('AddSTime');
   Route::delete('/stime/{id}', [ShowTimeController::class, 'destroy'])->name('DeleteSTime');
   Route::put('/stime/{id}', [ShowTimeController::class, 'update'])->name('UpdateSTime');
   Route::get('/get-cinema-rooms/{cinema_id}', [ShowtimeController::class, 'getCinemaRooms']);
   
   //banner
   Route::get('/banner', [BannersController::class, 'index'])->name('ShowBanners');
   Route::post('/banner', [BannersController::class, 'store'])->name('AddBanners');
   Route::put('/banner/{id}', [BannersController::class, 'update'])->name('UpdateBanners');
   Route::delete('/banner/{id}', [BannersController::class, 'destroy'])->name('DeleteBanners');
   
   //user
   Route::get('/user', [UserController::class, 'index'])->name('ShowUser');
   Route::put('/user/{id}/updateStatus', [UserController::class, 'updateStatus'])->name('UpdateStatus');
   Route::get('/user/{id}', [UserController::class, 'UserInfor'])->name('ShowUserInfor');
   
   //discount
   Route::get('/discount', [DiscountCodeController::class, 'index'])->name('ShowDiscount');
   Route::post('/discount', [DiscountCodeController::class, 'store'])->name('AddDiscount');
});

