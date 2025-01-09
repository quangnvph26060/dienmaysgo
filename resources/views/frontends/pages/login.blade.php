@extends('frontends.layouts.master')

@section('content')
    <div class="container-swap">
        <div class="container-fluid">
            <div class="form-box login">
                <form action="" method="post">
                    <h1>Đăng nhập</h1>
                    <div class="input-box">
                        <input type="text" name="email" placeholder="Họ và tên" required />
                        <i class="bx bxs-user"></i>
                    </div>
                    <div class="input-box">
                        <input name="password" type="password" placeholder="Mật khẩu" required />
                        <i class="bx bxs-lock-alt"></i>
                    </div>

                    <div class="forgot-link">
                        <a href="#">Quên mật khẩu</a>
                    </div>

                    <button type="submit" class="btn">Đăng nhập</button>

                    <p>hoặc đăng nhập với nền tảng</p>

                    <div class="social-icon">
                        <a href="{{ route('auth.google-auth') }}"><i class="bx bxl-google"></i></a>
                        <a href=""><i class="bx bxl-facebook-circle"></i></a>
                    </div>
                </form>
            </div>

            <div class="form-box register">
                <form action="" method="post">
                    <h1>Đăng ký</h1>
                    <div class="input-box">
                        <input type="text" name="name" placeholder="Họ và tên" required />
                        <i class="bx bxs-user"></i>
                    </div>
                    <div class="input-box">
                        <input type="text" name="email" placeholder="Email" required />
                        <i class="bx bxs-envelope"></i>
                    </div>
                    <div class="input-box">
                        <input type="password" name="password" placeholder="Mật khẩu" required />
                        <i class="bx bxs-lock-alt"></i>
                    </div>

                    <div class="forgot-link">
                        <a href="#">Quên mật khẩu</a>
                    </div>

                    <button type="submit" class="btn">Đăng ký</button>

                    <p>hoặc đăng nhập với nền tảng</p>

                    <div class="social-icon">
                        <a href="#"><i class="bx bxl-google"></i></a>
                        <a href=""><i class="bx bxl-facebook-circle"></i></a>
                    </div>
                </form>
            </div>

            <div class="toggle-box">
                <div class="toggle-panel toggle-left">
                    <h1>Xin chào! Chào Mừng</h1>
                    <p>Bạn chưa có tài khoản?</p>
                    <button class="btn register-btn">Đăng ký</button>
                </div>
                <div class="toggle-panel toggle-right">
                    <h1>Chào Mừng Chở Lại!</h1>
                    <p>Bạn đã có tài khoản?</p>
                    <button class="btn login-btn">Đăng nhập</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('frontends/assets/css/auth/login.css') }}">
@endpush

@push('scripts')
    <script>
        const locks = document.querySelectorAll('.bxs-lock-alt');

        locks.forEach(lock => {
            lock.addEventListener('click', () => {
                const inputBox = lock.closest('.input-box'); // Lấy cha chứa cả input và icon
                const passwordInput = inputBox.querySelector('input[type="password"], input[type="text"]');

                if (passwordInput.type === "password") {
                    // Hiển thị mật khẩu và thay icon
                    passwordInput.type = "text";
                    lock.classList.replace('bxs-lock-alt', 'bxs-lock-open-alt');
                } else {
                    // Ẩn mật khẩu và khôi phục icon
                    passwordInput.type = "password";
                    lock.classList.replace('bxs-lock-open-alt', 'bxs-lock-alt');
                }
            });
        });

        document.querySelector('.login form').addEventListener('submit', function(e) {
            e.preventDefault();

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const data = new FormData(this);
            const api = "{{ route('auth.authenticate') }}";

            fetch(api, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: data
                })
                .then(response => response.json())
                .then(response => {
                    if (response.status_code == 400) alert(response.message)

                    if (response.status_code == 422) alert(response.error)

                    if (response.status_code == 200) window.location.href = response.redirect
                })
                .catch(error => {
                    console.log(error);
                });
        });

        document.querySelector('.register form').addEventListener('submit', function(e) {
            e.preventDefault();

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const data = new FormData(this);
            const api = "{{ route('auth.register') }}";

            fetch(api, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: data
                })
                .then(response => response.json())
                .then(response => {
                    if (response.status) {
                        window.location.href = response.redirect
                    }
                    alert(response.message)
                })
                .catch(error => {
                    console.log(error);
                });
        });




        const container = document.querySelector(".container-fluid");
        const registerBtn = document.querySelector(".register-btn");
        const loginBtn = document.querySelector(".login-btn");

        registerBtn.addEventListener("click", () => {
            container.classList.add("active");
        });

        loginBtn.addEventListener("click", () => {
            container.classList.remove("active");
        });
    </script>
@endpush
