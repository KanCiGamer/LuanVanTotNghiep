@extends('layouts.home')

@section('noi-dung')
    <link rel="stylesheet" href="{{ asset('css/rspw.css') }}">
    <div class="container">
        <div>
            <p>Nhập email bạn sử dụng để tạo tài khoản</p><br>
            <form action="{{ route('SendMailForgotPassword')}}" method="POST">
                @csrf
                <input type="email" name="user_email" id="user_email"><br>
                <input type="submit" value="XÁC NHẬN">
            </form>
        </div>
    </div>
@endsection
