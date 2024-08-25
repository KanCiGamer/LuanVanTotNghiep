@extends('layouts.admin_home')

@section('content')
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
    </script>
    
@endsection
