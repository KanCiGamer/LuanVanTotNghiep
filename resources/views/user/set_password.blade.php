@extends('layouts.home')

@section('noi-dung')
    <link rel="stylesheet" href="{{ asset('css/rspage.css') }}">
    <div class="container">
        <div class="form-box">
            <div class="button-box">
                <p class="toggle-btn">ĐỔI MẬT KHẨU</p>
            </div>
            <form action="{{ route('UserRePass') }}" method="POST" id="register" class="input-group" style="display:block;">
                @csrf
                <div class="container-form">
                    <input type="hidden" name="user_id" value="{{ $user->user_id }}">
                    <label for="user_password">Mật khẩu <span>*</span></label><br>
                    <input type="password" id="register_user_password" name="user_password" required
                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$"
                        title="Mật khẩu phải từ 8 ký tự, chữ hoa, thường, số và ký tự đặc biệt">
                    <div id="valid-password-error" class="error" style="display:none; color:red;">
                        Mật khẩu phải từ 8 ký tự, chữ hoa, thường, số và ký tự đặc biệt
                    </div>

                    <label for="user_password">Xác nhận mật khẩu <span>*</span></label><br>
                    <input type="password" id="re_user_password" name="re_user_password" required>
                    <div id="confirm-password-error" class="error" style="display:none; color:red;">
                        Mật khẩu không trùng khớp.
                    </div>
                    <button type="submit" class="submit-btn">XÁC NHẬN</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('register_user_password');
            const confirmPasswordInput = document.getElementById('re_user_password');
            const confirmPasswordError = document.getElementById('confirm-password-error');
            const validPasswordError = document.getElementById('valid-password-error');
            const form = document.getElementById('register');

            passwordInput.addEventListener('input', function() {
                const password = passwordInput.value;
                const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;

                if (!regex.test(password)) {
                    validPasswordError.style.display = 'block';
                } else {
                    validPasswordError.style.display = 'none';
                }
            });

            confirmPasswordInput.addEventListener('input', function() {
                if (passwordInput.value !== confirmPasswordInput.value) {
                    confirmPasswordError.style.display = 'block';
                } else {
                    confirmPasswordError.style.display = 'none';
                }
            });

            form.addEventListener('submit', function(event) {
                if (passwordInput.value !== confirmPasswordInput.value) {
                    confirmPasswordError.style.display = 'block';
                    event.preventDefault(); // Ngăn submit form nếu mật khẩu không khớp
                }
            });
        });

    </script>
@endsection