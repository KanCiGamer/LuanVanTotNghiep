@extends('layouts.home')

@section('noi-dung')
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <div class="user-profile" style="margin-top: 40px; margin-left:20px;margin-right:20px;">
        <div class="sidebar">
            <button class="sidebar-button active" data-target="user-info">Thông tin cá nhân</button>
            <button class="sidebar-button" data-target="user-tickets">Danh sách vé đã mua</button>
        </div>
        <div class="content">
            <div class="content-section active" id="user-info">
                <div>
                    <h2>THÔNG TIN CÁ NHÂN</h2>
                    <div class="error-container">
                        @if (session('success'))
                            <label class="text-success"><span>{{ session('success') }}</span></label><br>
                        @endif
                    </div>
                    <form action="{{ route('UserUpdateInfor', $user->user_id) }}" method="POST" id="update-infor">
                        @csrf
                        @method('PUT')
                        <div class="form-row">
                            <div class="form-group">
                                <label for="user_name">Tên:</label>
                                <input type="text" name="user_name" id="user_name" value="{{ $user->user_name }}"
                                    required>
                            </div>
                            <div class="form-group">
                                <div class="error-container">
                                    @if ($errors->has('error_email'))
                                        <label
                                            class="text-danger"><span>{{ $errors->first('error_email') }}</span></label><br>
                                    @endif
                                </div>
                                <label for="user_email">Email:</label>
                                <input type="email" name="user_email" id="user_email" value="{{ $user->user_email }}"
                                    required>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group">
                                <div class="error-container">
                                    @if ($errors->has('error_phone'))
                                        <label
                                            class="text-danger"><span>{{ $errors->first('error_phone') }}</span></label><br>
                                    @endif
                                </div>
                                <label for="user_phone">Số điện thoại:</label>
                                <input type="tel" name="user_phone" id="user_phone" value="{{ $user->user_phone }}"
                                    maxlength="10" required>
                            </div>
                            <div class="form-group" style="display: flex; justify-content:space-around; gap:25px;">
                                <div>
                                    <label for="user_gender">Giới tính:</label>
                                    <div class="gender-options"
                                        style="display:flex; justify-content: space-evenly; margin-top: 20px;">
                                        @if ($user->user_gender == 1)
                                            <input type="radio" id="male" name="user_gender" value="1" required
                                                checked>
                                            <label for="male">Nam</label>
                                            <input type="radio" id="female" name="user_gender" value="0" required>
                                            <label for="female">Nữ</label>
                                        @else
                                            <input type="radio" id="male" name="user_gender" value="1" required>
                                            <label for="male">Nam</label>
                                            <input type="radio" id="female" name="user_gender" value="0" required
                                                checked>
                                            <label for="female">Nữ</label>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <label for="user_gender">Ngày sinh:</label>
                                    <input type="date" name="date_of_birth" value="{{ $user->user_date_of_birth }}"
                                        disabled id="">
                                </div>
                            </div>

                        </div>
                        <button type="submit">Lưu thông tin</button>
                    </form>
                </div>
                <div style="margin-top: 50px;">
                    <h2>ĐỔI MẬT KHẨU</h2>
                    <div class="error-container">
                        @if (session('successp'))
                            <label class="text-success"><span>{{ session('successp') }}</span></label><br>
                        @endif
                    </div>
                    <form action="{{ route('UserUpdatePass', $user->user_id) }}" method="POST" id="update-pass">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <div class="error-container">
                                @if ($errors->has('error_password'))
                                    <label
                                        class="text-danger"><span>{{ $errors->first('error_password') }}</span></label><br>
                                @endif
                            </div>
                            <label for="user_name">Mật khẩu cũ:</label>
                            <input type="password" name="user_password" id="user_password" required>
                        </div>
                        <div class="form-group">
                            <label for="user_email">Mật khẩu mới:</label>
                            <input type="password" name="new_user_password" id="new_user_password" required>
                            <div id="valid-password-error" class="error" style="display:none; color:red;">Mật khẩu phải từ
                                8 ký tự, chữ hoa, thường, số và ký tự đặc biệt</div>
                        </div>
                        <div class="form-group">
                            <label for="user_phone">Xác nhận mật khẩu:</label>
                            <input type="password" name="re_new_user_password" id="re_new_user_password" required>
                            <div id="confirm-password-error" class="error" style="display:none; color:red;">Mật khẩu
                                không
                                trùng
                                khớp.</div>
                        </div>
                </div>
                <button type="submit">Cập nhật</button>
                </form>
            </div>
            <div class="content-section" id="user-tickets">
                <h2>DANH SÁCH VÉ ĐÃ MUA</h2>
                @if ($invoice == null)
                    <p>Không có vé nào được tìm thấy.</p>
                @else
                    <ul class="cinema-list"
                        style="list-style-type: none;display:flex;flex-direction:column;gap:10px;text-align:center; width:80%;">
                        @foreach ($invoice as $value)
                            <li>
                                <div class="invoice-item"
                                    style="display: flex; justify-content:space-between;align-items: center;
                                    cursor: pointer;
                                    padding: 24px;
                                    border: 1px black solid;
                                    margin-top: 20px;
                                    text-align:left;"
                                    onclick="toggleDetails(this)">
                                    <div>
                                        <span  style="color: #FF5F00;">{{ $value->invoice_detail[0]->showtime->movie->movie_name }} </span><br>
                                        {{ $value->invoice_detail[0]->showtime->start_date }}
                                    </div>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                        fill="currentColor" class="bi bi-caret-left-fill" viewBox="0 0 16 16">
                                        <path
                                            d="m3.86 8.753 5.482 4.796c.646.566 1.658.106 1.658-.753V3.204a1 1 0 0 0-1.659-.753l-5.48 4.796a1 1 0 0 0 0 1.506z" />
                                    </svg>
                                </div>
                                <div class="invoice-details"
                                    style="display: none; padding: 24px; border: 1px solid black; border-top:none; text-align:left; ">
                                    <ul>
                                        <p>Giờ chiếu: {{ $value->invoice_detail[0]->showtime->start_time }}</p>
                                        <p>
                                            Ghế:

                                            @foreach ($value->invoice_detail as $detail)
                                                {{ $detail->seat->seat_name }}
                                            @endforeach
                                        </p>
                                        <p>Giá tiền: {{ number_format($value->price_total, 0, ',', '.') }} 
                                            @if($value->discountCode)
                                            VND (giảm: {{  $value->discountCode->discount_percentage}}%)
                                            @else
                                            VND
                                            @endif
                                        </p>
                                        
                                        {{-- <p>Mã giảm giá: {{ $value->discountCode->code ?? "không sử dụng"}}</p> --}}
                                    </ul>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>


    </div>
    </div>

    <script>
        const sidebarButtons = document.querySelectorAll('.sidebar-button');
        const contentSections = document.querySelectorAll('.content-section');

        sidebarButtons.forEach(button => {
            button.addEventListener('click', () => {
                const targetId = button.dataset.target;
                const targetSection = document.getElementById(targetId);

                sidebarButtons.forEach(btn => btn.classList.remove('active'));
                contentSections.forEach(section => section.classList.remove('active'));

                button.classList.add('active');
                targetSection.classList.add('active');
            });
        });

        function toggleDetails(element) {
            const details = element.nextElementSibling;
            if (details.style.display === "none" || details.style.display === "") {
                details.style.display = "block";
            } else {
                details.style.display = "none";
            }
        }

        $(document).ready(function() {
            setTimeout(function() {
                $('.error-container').fadeOut('slow', function() {
                    $(this).remove();
                });
            }, 2000);
        });
        document.addEventListener("DOMContentLoaded", function() {
            // lấy số điện thoại người dùng nhập
            const user_phone = document.getElementById('user_phone');

            const passwordInput = document.getElementById('new_user_password');
            const confirmPasswordInput = document.getElementById('re_new_user_password');
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

            document.getElementById("update-infor").addEventListener('submit', function(event) {
                let isValid = true;
                let account = user_phone.value.trim();
                if (!validatePhoneNumber(account)) {
                    user_phone.setCustomValidity("Số điện thoại không hợp lệ");
                    isValid = false;
                }
                if (!isValid) {
                    event.preventDefault();
                    accountInput.reportValidity();
                }
            });
            document.getElementById("update-pass").addEventListener('submit', function(event) {
                if (confirmPasswordInput.value != passwordInput.value) {
                    confirmPasswordError.style.display = 'block';
                    event.preventDefault();
                } else {
                    confirmPasswordError.style.display = 'none';
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

            function validatePhoneNumber(phone) {
                const re = /^[0-9]{10}$/;
                return re.test(phone);
            }
        });
    </script>
@endsection
