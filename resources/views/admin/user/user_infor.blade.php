<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            margin: 0;
            font-family: sans-serif;
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

        .past-showtime {
            background-color: #5f5f5f;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">Thông tin người dùng</h4>
                    </div>
                    <div class="card-body">
                        <p><strong>ID:</strong> {{ $user->user_id }}</p>
                        <p><strong>Tên người dùng:</strong> {{ $user->user_name }}</p>
                        <p><strong>Email:</strong> {{ $user->user_email }}</p>
                        <p><strong>Số điện thoại:</strong> {{ $user->user_phone }}</p>
                        <p><strong>Giới tính:</strong> {{ $user->user_gender == 1 ? 'Nam' : 'Nữ'}}</p>
                        <p><strong>Ngày sinh:</strong> {{ $user->user_date_of_birth }}</p>
                        <p><strong>Trạng thái:</strong> 
                            @if ($user->block == 1)
                                Bị khóa
                            @elseif ($user->block == 0)
                                Hoạt động
                            @endif
                        </p>
                        <a href="{{ route('ShowUser') }}" class="btn btn-secondary">Quay lại</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
