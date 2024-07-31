@extends('layouts.home')

@section('noi-dung')
    <link rel="stylesheet" href="{{ asset('css/loginpage.css') }}">
    <div class="container">
        <div class="form-box">
            <div class="button-box">
                <button type="button" class="toggle-btn" onclick="login()">ĐĂNG NHẬP</button>
                <button type="button" class="toggle-btn" onclick="register()">ĐĂNG KÝ</button>
            </div>
            <form action="{{ route('UserLogin') }}" method="POST" id="login" class="input-group">
                @csrf
                <div class="container-form">
                    <div class="error-container">
                        @if ($errors->has('error'))
                            <label class="text-danger"><span>{{ $errors->first('error') }}</span></label><br>
                        @endif
                    </div>
                    <label for="uname">Email / Số điện thoại<span>*</span></label>
                    <input type="text" id="account" name="account" required
                        title="Email hoặc số điện thoại đã đăng ký">

                    <label for="psw">Mật khẩu <span>*</span></label>
                    <input type="password" id="login_user_password" name="user_password" required
                        title="Mật khẩu tài khoản">
                    <label>
                        <a href="" style="font-size: 15px;">Quên mật khẩu?</a>
                    </label>
                    <button type="submit">ĐĂNG NHẬP</button>
                </div>
            </form>
            <form action="{{ route('UserRegister') }}" method="POST" id="register" class="input-group"
                style="display:none;">
                @csrf
                <div class="container-form">
                    <label for="user_name">Họ và tên <span>*</span></label><br>
                    <input type="text" id="user_name" name="user_name" required><br>
                    <div class="error-container">
                        @if ($errors->has('error_phone'))
                            <label class="text-danger"><span>{{ $errors->first('error_phone') }}</span></label><br>
                        @endif
                    </div>
                    <label for="user_phone">Số điện thoại <span>*</span></label><br>
                    <input type="text" id="user_phone" name="user_phone" required maxlength="10"><br>
                    <div class="error-container">
                        @if ($errors->has('error_email'))
                            <label class="text-danger"><span>{{ $errors->first('error_email') }}</span></label><br>
                        @endif
                    </div>
                    <label for="user_email">Email <span>*</span></label><br>
                    <input type="email" id="user_email" name="user_email" required><br>
                    <div style="display: flex;">
                        <div style="width:100%;">
                            <label for="user_gender">Giới tính <span>*</span></label>
                            <div style="display:flex; justify-content: space-evenly; margin-top: 20px;">
                                <input type="radio" id="male" name="user_gender" value="1" required>
                                <label for="male">Nam</label>
                                <input type="radio" id="female" name="user_gender" value="0" required>
                                <label for="female">Nữ</label>
                            </div>
                        </div>
                        <div>
                            <label for="user_date_of_birth">Ngày sinh <span>*</span></label>
                            <input type="date" id="user_date_of_birth" name="user_date_of_birth" required>
                        </div>
                    </div>
                    <label for="user_password">Mật khẩu <span>*</span></label><br>
                    <input type="password" id="register_user_password" name="user_password" required
                        pattern="^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$" title="Mật khẩu phải từ 8 ký tự, chữ hoa, thường, số và ký tự đặc biệt"> 
                    <div id="valid-password-error" class="error" style="display:none; color:red;">Mật khẩu phải từ 8 ký tự, chữ hoa, thường, số và ký tự đặc biệt</div>
                    <label for="user_password">Xác nhận mật khẩu <span>*</span></label><br>
                    <input type="password" id="re_user_password" name="re_user_password" required>
                    <div id="confirm-password-error" class="error" style="display:none; color:red;">Mật khẩu không trùng
                        khớp.</div>
                    <button type="submit" class="submit-btn">ĐĂNG KÝ</button>
                </div>
            </form>
        </div>
    </div>
    <script>
        function register() {
            document.getElementById("login").style.display = "none";
            document.getElementById("register").style.display = "block";
        }

        function login() {
            document.getElementById("login").style.display = "block";
            document.getElementById("register").style.display = "none";
        }
        $(document).ready(function() {
            setTimeout(function() {
                $('.error-container').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 2000);
        });
        document.addEventListener("DOMContentLoaded", function() {
            // lấy tài khoản người dùng khi đăng nhập
            const accountInput = document.getElementById('account');
            // lấy số điện thoại người dùng nhập
            const user_phone = document.getElementById('user_phone');
            // gọi hàm xác định thời gian
            maxDate();

            const passwordInput = document.getElementById('register_user_password');
            const confirmPasswordInput = document.getElementById('re_user_password');
            const confirmPasswordError = document.getElementById('confirm-password-error');
            const validPasswordError = document.getElementById('valid-password-error');
            
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

            document.getElementById("login").addEventListener('submit', function(event) {
                let isValid = true;
                let account = accountInput.value.trim();
                if (validateNumber(account)) {
                    if (!validatePhoneNumber(account)) {
                        accountInput.setCustomValidity("Số điện thoại không hợp lệ");
                        isValid = false;
                    }

                } else if (!validateEmail(account)) {
                    accountInput.setCustomValidity("Email sai cú pháp");
                    isValid = false;
                } else {
                    accountInput.setCustomValidity('');
                }

                if (!isValid) {
                    event.preventDefault();
                    accountInput.reportValidity();
                }
            });
            document.getElementById("register").addEventListener('submit', function(event) {
                let isValid = true;
                let phone = user_phone.value.trim();
                if (!validatePhoneNumber(phone)) {
                    user_phone.setCustomValidity("Số điện thoại không hợp lệ");
                    isValid = false;
                }
                if (!isValid) {
                    event.preventDefault();
                    user_phone.reportValidity();
                }
            });
            document.querySelectorAll("input[required]").forEach(function(input) {
                input.addEventListener("invalid", function() {
                    if (this.value === "") {
                        this.setCustomValidity("Vui lòng điền vào trường này");
                    }
                });

                input.addEventListener("input", function() {
                    this.setCustomValidity("");
                });
            });

            function validateEmail(email) {
                const re =
                    /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(String(email).toLowerCase());
            }

            function validatePhoneNumber(phone) {
                const re = /^[0-9]{10}$/;
                return re.test(phone);
            }

            function validateNumber(phone) {
                const re = /^\d+$/;
                return re.test(phone);
            }

            function maxDate() {
                const today = new Date();
                const minDate = new Date();
                minDate.setFullYear(today.getFullYear() - 16);
                const minDateString = minDate.toISOString().split('T')[0];
                //const todayString = today.toISOString().split('T')[0];
                const dobInput = document.getElementById('user_date_of_birth');
                dobInput.setAttribute('max', minDateString);
            }

        });
    </script>
@endsection
