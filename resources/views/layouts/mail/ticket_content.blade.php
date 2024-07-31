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
<p>Tổng tiền: {{ number_format($invoice->total, 0, ',', '.') }} VND</p>

<h2>Chi tiết vé xem phim</h2>

<table>
    <thead>
        <tr>
            <th>Phim</th>
            <th>Suất chiếu</th>
            <th>Ghế</th>
            <th>Giá</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($invoiceDetails as $detail)
            <tr>
                <td>{{ $detail->showtime->movie->movie_name }}</td>
                <td>{{ $detail->showtime->start_time }} - {{ $detail->showtime->start_date }}</td>
                <td>{{ $detail->seat_id }}</td>
                <td>{{ number_format($detail->price, 0, ',', '.') }} VND</td>
            </tr>
        @endforeach
    </tbody>
</table>

<p>Cảm ơn bạn đã mua vé!</p>
</body>
</html>