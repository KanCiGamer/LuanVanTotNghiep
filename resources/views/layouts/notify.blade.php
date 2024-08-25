@extends('layouts.home')

@section('noi-dung')
    <div style="display: flex; justify-content: center; align-items: center; margin: 40px auto;text-align:center; height: 65vh;">
        <div>
            @if ($errors->has('error'))
                <label class="text-danger" style="color: red;"><span>{{ $errors->first('error') }}</span></label><br>
            @else
            <p>Vui lòng kiểm tra email của bạn để xác minh trước khi đăng nhập!</p>
            <div style="margin-top: 35px;">
                <a href="https://mail.google.com/mail" target="_blank" style="padding: 25px;background: blanchedalmond;">XÁC MINH</a>
            </div>
            @endif
        </div>
    </div>
@endsection
