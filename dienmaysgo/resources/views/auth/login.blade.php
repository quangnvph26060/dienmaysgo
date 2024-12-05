<!DOCTYPE html>
<html>


<!-- Mirrored from id.tenten.vn/loginNavi by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 Dec 2024 01:24:10 GMT -->
<!-- Added by HTTrack -->
<meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->

<head>
    <title>Login</title>
    <!-- css -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <!-- CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/css/select2.min.css">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/6.0.0-beta1/css/tempus-dominus.min.css">

    <link rel="stylesheet" type="text/css" href="{{ asset('auth/css/style.css') }}">
    <link rel="icon" href="https://sgomedia.vn/wp-content/uploads/2023/06/cropped-favicon-sgomedia-32x32.png" type="image/x-icon">
    <!-- js -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.marquee/1.5.0/jquery.marquee.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.pause/0.2/jquery.pause.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-easing/1.4.1/jquery.easing.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.1.0-beta.1/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/6.0.0-beta1/js/tempus-dominus.min.js">
    </script>
    <script src="{{ asset('auth/js/api.js') }}" async defer></script>
</head>
<style type="text/css">
    .error_txt {
        color: red;
    }

    .active {
        display: none;
    }

    .btn {
        margin-top: 20px;
    }

    .pointer {
        cursor: pointer;
    }

    .g-recaptcha div {
        margin: auto;
    }

    .logo_login img {
        margin-bottom: 20px;
    }

    .loginButton:disabled {
        cursor: no-drop;
    }

    .disabled_button {
        background: #6d9abb !important;
        cursor: no-drop;
    }

    @media (min-width: 768px) {
        .login_page .ct_left {
            min-height: 625px;
        }

        .login_page .ct_right {
            min-height: 625px;
        }
    }

    @media (min-width: 375px) and (max-width: 550px) {
        .rc-image-tile-33 {
            width: 200%;
            height: 200%;
        }

        .rc-image-tile-44 {
            width: 300%;
            height: 300%;
        }
    }
</style>

<body class="form_page">
    <div id="qb_content_navi_2021">
        <div class="login_display_02 login_page">
            <div class="ct_left">
                <h2 class="title_login">Liên hệ với chúng tôi</h2>
                <div class="ct_left_ct">
                    <ul>
                        <li>
                            <strong class="diff_strong">Hỗ trợ kỹ thuật:</strong>
                            <span><strong class="normal_strong">(024) 62 927 089</strong>
                                <p>(24/7)</p>
                            </span>
                        </li>
                        <li>
                            <strong class="diff_strong">Hỗ trợ hoá đơn:</strong>
                            <span><strong class="normal_strong">0912 399 322</strong>
                                <p>(8h30 - 18h00)</p>
                            </span>
                        </li>
                        <li>
                            <strong class="diff_strong">Hỗ trợ gia hạn:</strong>
                            <span><strong class="normal_strong"> 0912 399 322</strong>
                                <p>(8h30 - 18h00)</p>
                            </span>
                        </li>
                        <li>
                            <strong class="diff_strong">Email:</strong>
                            <span><strong class="normal_strong">info@sgomedia.vn</strong></span>
                        </li>
                        {{-- <li>
                            <span><strong class="normal_strong">Hỗ trợ đăng ký dịch vụ:</strong>(8h30 -
                                18h00)</span>
                            <span class="half_col">Hà Nội: <strong class="normal_strong">(024) 71 089
                                    999</strong></span>
                            <span class="half_col">TP.HCM: <strong class="normal_strong">(028) 73 086
                                    086</strong></span>
                        </li> --}}
                    </ul>
                </div>
            </div>
            <div class="ct_right">
                <div class="ct_right_ct">
                    <!-- Nút chuyển ngôn ngữ -->
                    <span class="login_translate pointer" onclick="changeLanguage('vi')" id="vi-language">
                        <img src="{{ asset('auth/images/translate-tv-icon.png') }}" style="width: 25px; ">Tiếng việt
                    </span>
                    <span class="login_translate pointer" onclick="changeLanguage('en')" id="en-language">
                        <img src="{{ asset('auth/images/lg_icon_translate.png') }}" style="width: 25px;">English
                    </span>

                    <figure class="logo_login">
                        <a href="#"><img style="width: 210px !important"
                                src="https://sgomedia.vn/wp-content/uploads/2023/11/logo-sgo-media-optimized.png"
                                alt="logo-sgo-media"></a>
                    </figure>

                    <div class="login_form">
                        <form method="post" accept-charset="utf-8" id="form-login"
                            action="https://id.tenten.vn/loginNavi">
                            <div class="form_group" style="display: block;">
                                <div class="list_group">
                                    <input type="text" name="username" autocomplete="off" required=""
                                        placeholder="Username hoặc Email" id="username">
                                    <figure class="feild_icon"><img
                                            src="{{ asset('auth/images/login_user_icon.png') }}"></figure>
                                </div>
                                <div class="list_group">
                                    <input type="password" name="password" autocomplete="off" required=""
                                        placeholder="Password" id="password">
                                    <figure class="feild_icon"><img
                                            src="{{ asset('auth/images/login_padlock_icon.png') }}"></figure>
                                </div>

                                <div class="captcha-container">
                                    <div class="captcha-checkbox">
                                        <input type="checkbox" id="captcha">
                                        <label for="captcha" style="font-size: 14px" id="captcha-label">Xác minh bạn là
                                            con người</label>
                                    </div>
                                    <div class="captcha-info">
                                        <img src="https://www.cloudflare.com/img/logo-cloudflare-dark.svg"
                                            alt="Cloudflare Logo">
                                        <div style="font-size: 9px">
                                            <a href="https://www.cloudflare.com/privacypolicy/" id="privacy-link">Quyền
                                                riêng tư</a>
                                            <a href="https://www.cloudflare.com/website-terms/" id="terms-link">Điều
                                                khoản</a>
                                        </div>
                                    </div>
                                </div>

                                <div class="btn">
                                    <button type="submit" name="button"
                                        class="loginButton loginButtonGg remove-msg before-login disabled_button"
                                        id="submitBtn" disabled>Đăng nhập</button>
                                </div>
                            </div>

                        </form>
                        <div class="create_forget_acc" style="display: flex;justify-content: end; display: none">
                            <a href="#" target="_blank" class="btn_login" style="margin-bottom: 15px;"
                                id="create-account">Tạo tài khoản</a>
                            <a href="#" class="btn_login remove-msg forgot-pass" style="margin-bottom: 15px;"
                                id="forgot-password">Quên mật khẩu?</a>
                        </div>

                    </div>
                </div>
            </div>


        </div>
    </div><!-- end content -->

</body>


<!-- Mirrored from id.tenten.vn/loginNavi by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 04 Dec 2024 01:24:11 GMT -->

</html>

<script type="text/javascript">
    $(document).ready(function() {
            $(document).on('click', '.remove-msg', function(e) {
                $('.message').text('');
            });
            $(document).on('click', '.forgot-pass', function(e) {
                $('#form-forgot-pass').find('.form_group').removeAttr('style');
                if ($('#form-forgot-pass').find('.form_group').hasClass('active')) {
                    $('#form-forgot-pass').find('.form_group').removeClass('active');
                }
                $('#form-login').addClass('hidden');
                $('.create_forget_acc').addClass('hidden');
                $('.other_login').addClass('hidden');
            });
            $(document).on('click', '.btn-back-login', function(e) {
                $('#form-forgot-pass').find('.form_group').addClass('active');
                $('#form-login').removeClass('hidden');
                $('.create_forget_acc').removeClass('hidden');
                $('.other_login').removeClass('hidden');
            });
            if (window.location.pathname == "/forgot-password-navi") {
                $(document).on('click', '.btn-back-login', function(e) {
                    $('#form-login').find('.form_group').removeAttr('style');
                    $('#form-forgot-pass').find('.form_group').removeAttr('style');
                    $('#form-forgot-pass').find('.form_group').addClass('active');
                    $('#form-login').removeClass('hidden');
                    $('.create_forget_acc').removeAttr('style');
                    $('.other_login').removeAttr('style');
                });
            }

            $(document).on('click', '.loginButtonGg', function(e) {
                e.preventDefault();
                jQuery(this).attr('disabled',true);
                jQuery(this).addClass('disabled_button');
                var form = document.getElementById('form-login');
                form.submit();
            });

            $(document).on('click', '.forgotPasswordButton', function(e) {
                e.preventDefault();
                jQuery('.loginButton').attr('disabled',true);
                jQuery('.loginButton').addClass('disabled_button');
                var form = document.getElementById('form-forgot-pass');
                form.submit();
            });
        });

        function onTurnstileLoad(){
            jQuery('.loginButton').removeClass('disabled_button');
            jQuery('.loginButton').attr('disabled',false);
        }
</script>

<script>
    // Lắng nghe sự kiện thay đổi của checkbox
document.getElementById("captcha").addEventListener("change", function() {
    var submitBtn = document.getElementById("submitBtn");

    // Kiểm tra xem checkbox đã được chọn chưa
    if (this.checked) {
        // Nếu đã chọn, xóa class disabled_button và kích hoạt nút
        submitBtn.classList.remove("disabled_button");
        submitBtn.disabled = false;  // Kích hoạt nút
    } else {
        // Nếu không chọn, thêm lại class disabled_button và vô hiệu hóa nút
        submitBtn.classList.add("disabled_button");
        submitBtn.disabled = true;  // Vô hiệu hóa nút
    }
});

</script>
<script>
    function changeLanguage(language) {
        if (language === 'vi') {
            // Tiếng Việt
            document.getElementById('username').setAttribute('placeholder', 'Username hoặc Email');
            document.getElementById('password').setAttribute('placeholder', 'Password');
            document.getElementById('captcha-label').innerText = 'Xác minh bạn là con người';
            document.getElementById('privacy-link').innerText = 'Quyền riêng tư';
            document.getElementById('terms-link').innerText = 'Điều khoản';
            document.getElementById('create-account').innerText = 'Tạo tài khoản';
            document.getElementById('forgot-password').innerText = 'Quên mật khẩu?';
            document.getElementById('submitBtn').innerText = 'Đăng nhập';

            // Ẩn nút Tiếng Việt và hiển thị nút English
            document.getElementById('vi-language').style.display = 'none';
            document.getElementById('en-language').style.display = 'inline-block';
        } else if (language === 'en') {
            // Tiếng Anh
            document.getElementById('username').setAttribute('placeholder', 'Username or Email');
            document.getElementById('password').setAttribute('placeholder', 'Password');
            document.getElementById('captcha-label').innerText = 'Verify you are human';
            document.getElementById('privacy-link').innerText = 'Privacy Policy';
            document.getElementById('terms-link').innerText = 'Terms of Service';
            document.getElementById('create-account').innerText = 'Create an Account';
            document.getElementById('forgot-password').innerText = 'Forgot Password?';
            document.getElementById('submitBtn').innerText = 'Login';

            // Ẩn nút English và hiển thị nút Tiếng Việt
            document.getElementById('vi-language').style.display = 'inline-block';
            document.getElementById('en-language').style.display = 'none';
        }
    }

    window.onload = function() {
        changeLanguage('vi');
    };

</script>
