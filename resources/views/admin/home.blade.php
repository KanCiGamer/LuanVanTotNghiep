<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        <title>Admin Dashboard</title><style>body {
            margin: 0;
            font-family: 'Courier New', Courier, monospace;
        }

        .sidebar {
            height: 100vh;
            width: 200px;
            background-color: #f0f0f0;
            position: fixed;
            left: 0;
            top: 0;
        }

        .sidebar .profile {
            text-align: center;
            padding: 20px;
            border-bottom: 1px solid #ddd;
        }

        .sidebar .profile img {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin-bottom: 10px;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .sidebar li {
            padding: 15px;
            border-bottom: 1px solid #ddd;
        }

        .sidebar li a {
            text-decoration: none;
            color: #333;
        }

        .content {
            margin-left: 200px;
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <div class="profile">
            <i class="bi bi-person-circle"></i>
            <h3>Administrator</h3>
            <a href="#">Đăng xuất</a>
        </div>
        <ul>
            <li><a href="{{ route('AdminPage') }}">Số liệu</a></li>
            <li><a href="{{ route('ShowMovies') }}">Phim</a></li>
            <li><a href="{{ route('ShowCategories') }}">Thể loại</a></li>
            <li><a href="{{ route('ShowCinemas') }}">Rạp phim</a></li>
            <li><a href="{{ route('ShowCinemaRoom') }}">Phòng chiếu</a></li>
            <li><a href="{{ route('ShowSType') }}">Loại ghế</a></li>
            <li><a href="{{ route('ShowSeat') }}">Ghế</a></li>
            <li><a href="{{ route('ShowTime') }}">Suất chiếu</a></li>
            <li><a href="{{ route('ShowUser')}}">Người dùng</a></li>
            <li><a href="{{ route('ShowDiscount') }}">Mã giảm giá</a></li>
            <li><a href="{{ route('ShowBanners') }}">Banner</a></li>
        </ul>
    </div>

    <div class="content" id="content">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="container">
            <h2>Biểu đồ Doanh thu</h2>
            <div>
                <label for="startDate">Từ ngày:</label>
                <input type="date" id="startDate">

                <label for="endDate">Đến ngày:</label>
                <input type="date" id="endDate">
            </div>
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns"></script>

    <script>
//         document.addEventListener("DOMContentLoaded", function() {
//     const ctx = document.getElementById('revenueChart').getContext('2d');
//     const revenueData = {
//         labels: @json($revenues->pluck('date')),
//         datasets: [{
//             label: 'Doanh thu',
//             data: @json($revenues->pluck('total')),
//             borderColor: 'rgba(75, 192, 192, 1)',
//             borderWidth: 1,
//             fill: false
//         }]
//     };

//     const revenueChart = new Chart(ctx, {
//         type: 'line', // Bạn có thể thay đổi loại biểu đồ thành 'bar' nếu muốn
//         data: revenueData,
//         options: {
//             responsive: true,
//             scales: {
//                 x: {
//                     type: 'time',
//                     time: {
//                         unit: 'day',
//                         tooltipFormat: 'dd/MM/yyyy',
//                         displayFormats: {
//                             day: 'dd/MM/yyyy'
//                         }
//                     }
//                 },
//                 y: {
//                     beginAtZero: true
//                 }
//             }
//         }
//     });
// });
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('revenueChart').getContext('2d');
            const originalRevenueData = { 
                labels: @json($revenues->pluck('date')),
                datasets: [{
                    label: 'Doanh thu',
                    data: @json($revenues->pluck('total')),
                    borderColor: 'rgba(75, 192, 192, 1)',
                    borderWidth: 1,
                    fill: false
                }]
            };

            let revenueChart = new Chart(ctx, { 
                type: 'bar',
                data: {
                    ...originalRevenueData
                }, 
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            type: 'time',
                            time: {
                                unit: 'day',
                                tooltipFormat: 'dd/MM/yyyy',
                                displayFormats: {
                                    day: 'dd/MM/yyyy'
                                }
                            }
                        },
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            // Hàm cập nhật biểu đồ
            function updateChart() {
                const startDate = new Date(document.getElementById('startDate').value);
                const endDate = new Date(document.getElementById('endDate').value);

                const filteredData = {
                    labels: [],
                    datasets: [{
                        ...originalRevenueData.datasets[0], 
                        data: []
                    }]
                };

                // Lọc dữ liệu dựa trên ngày tháng
                for (let i = 0; i < originalRevenueData.labels.length; i++) {
                    const date = new Date(originalRevenueData.labels[i]);
                    if (date >= startDate && date <= endDate) {
                        filteredData.labels.push(originalRevenueData.labels[i]);
                        filteredData.datasets[0].data.push(originalRevenueData.datasets[0].data[i]);
                    }
                }

                // Cập nhật dữ liệu cho biểu đồ
                revenueChart.data = filteredData;
                revenueChart.update();
            }

            // Lắng nghe sự kiện 'change' trên các trường nhập liệu ngày tháng
            document.getElementById('startDate').addEventListener('change', updateChart);
            document.getElementById('endDate').addEventListener('change', updateChart);
        });
    </script>
</body>

</html>
