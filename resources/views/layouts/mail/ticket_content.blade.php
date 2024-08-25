<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>

<body>
    <h1>Thông tin hóa đơn</h1>

    <p>Mã hóa đơn: {{ $invoice->invoice_id }}</p>
    <p>Ngày tạo: {{ $invoice->date_created }}</p>
    <p>Tổng tiền: {{ number_format($invoice->price_total, 0, ',', '.') }} VND</p>
    <p>Rạp phim: {{$showtime->cinema_room->cinema->name}}</p>
    
    <h2>Chi tiết vé xem phim</h2>

    @php
        $invoiceDetails = collect($invoiceDetails)->groupBy('showtime_id');
    @endphp
    @foreach ($invoiceDetails as $showtimeId => $details)
        <h3>{{ $details[0]->showtime->movie->movie_name }}</h3>
        <p>Ngày chiếu: {{ $details[0]->showtime->start_date }}</p>
        <p>Giờ chiếu: {{ $details[0]->showtime->start_time }}</p>
        <table>
        @foreach ($details as $detail)
        <tr>

            <td>{{ $detail->seat->seat_name }}</td>
            <td>{{ number_format($detail->price, 0, ',', '.') }} VND</td>
                        
        </tr>
        @endforeach
        </table>
    @endforeach
    {{-- @foreach ($invoiceDetails->groupBy(['showtime_id']) as $showtimeId => $details) 
    <h3>{{ $details[0]->showtime->movie->movie_name }}</h3> 
    <p>Ngày chiếu: {{ $details[0]->showtime->start_date }}</p>
    <p>Giờ chiếu: {{ $details[0]->showtime->start_time }}</p>
    <p>Phòng chiếu: {{ $details[0]->showtime->cinemaRoom->room_name }}</p> 

    <table>
        <thead>
            <tr>
                <th>Ghế</th>
                <th>Giá</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($details as $detail)
                <tr>
                    <td>{{ $detail->seat_id }}</td>
                    <td>{{ number_format($detail->price, 0, ',', '.') }} VND</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endforeach --}}

    <p>Cảm ơn bạn đã mua vé!</p>
</body>

</html>
