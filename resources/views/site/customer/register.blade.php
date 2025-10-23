@extends('site.layouts.master')
@section('title'){{ $config->web_title }}@endsection
@section('description'){{ strip_tags(html_entity_decode($config->introduction)) }}@endsection
@section('image'){{@$config->image->path ?? ''}}@endsection

@section('css')

@endsection

@section('content')
    <style>
        /* ====== Layout tổng ====== */
        :root{
            --red:#e30613;
            --text:#111;
            --muted:#6b7280;
            --bd:#e5e7eb;
            --bg:#fff;
        }

        *{box-sizing:border-box}
        body{margin:0;font-family:system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,sans-serif;color:var(--text)}

        .reg-wrap{
            min-height:100vh;           /* căn giữa theo chiều dọc */
            display:flex; align-items:flex-start; justify-content:center;
            background:#fafafa;
            padding:134px 16px;
        }
        .reg-card{
            width:min(980px, 100%);
            background:var(--bg);
            border:1px solid #efefef;
            border-radius:8px;
            padding:24px 24px 16px;
            box-shadow:0 10px 40px rgba(0,0,0,.06);
            position:relative;
        }

        /* Ruy-băng tiêu đề */
        .reg-ribbon{ position:relative; margin:-36px auto 18px; width:100%; }
        .reg-ribbon h2{
            display:inline-block; color:#fff; background:var(--red);
            padding:12px 28px; font-size:18px; letter-spacing:.3px; border-radius:0 0 0 0;
            position:relative; left:50%; transform:translateX(-50%);
        }


        .reg-intro{ margin:12px 0 18px; color:#333; text-align:center }

        /* ====== Form grid ====== */
        .reg-form{ display:grid; grid-template-columns: 300px 1fr; column-gap:24px; row-gap:16px; }
        .reg-row{ display:contents; } /* để label và field nằm cùng hàng trong grid */

        .reg-label{
            display:flex; align-items:center; gap:10px;
            font-weight:600; color:#333;
        }
        .reg-label .req{ color:var(--red); font-weight:700 }
        .ico{ width:20px; height:20px; color:var(--red); display:inline-flex; }
        .ico svg{ width:20px; height:20px; fill:currentColor }

        .reg-field input{
            width:100%; height:44px; border:1px solid var(--bd); border-radius:4px;
            padding:0 12px; font-size:15px; outline:none; background:#fff;
        }
        .reg-field input:focus{ border-color:#cbd5e1; box-shadow:0 0 0 3px rgba(227,6,19,.12); }

        /* Toggle password */
        .has-toggle{ position:relative }
        .pw-toggle{
            position:absolute; right:8px; top:50%; transform:translateY(-50%);
            border:0; background:transparent; cursor:pointer; font-size:16px; opacity:.6;
        }
        .pw-toggle:hover{ opacity:1 }

        /* Consent */
        .reg-consent{
            grid-column:1 / -1;
            margin-top:10px; padding:16px; background:linear-gradient(180deg,#fff, #fafafa);
            border-radius:8px; border:1px solid #f1f1f1;
            color:#333; font-size:14px;
        }
        .chk{ display:flex; align-items:flex-start; gap:10px; line-height:1.5 }
        .chk input{ display:none }
        .chkbox{
            width:18px; height:18px; border:1px solid #d1d5db; border-radius:3px; margin-top:2px; position:relative; background:#fff;
        }
        .chk input:checked + .chkbox{ background:var(--red); border-color:var(--red) }
        .chk input:checked + .chkbox::after{
            content:""; position:absolute; left:4px; top:1px; width:6px; height:10px; border:2px solid #fff; border-top:0; border-left:0; transform:rotate(45deg);
        }
        .reg-consent a{ color:#0d6efd; text-decoration:none }
        .reg-consent a:hover{ text-decoration:underline }

        /* Actions */
        .reg-actions{
            grid-column:1 / -1;
            display:flex; justify-content:space-between; gap:16px; margin-top:10px;
        }
        .btn{
            display:inline-flex; align-items:center; justify-content:center;
            border-radius:4px; padding:12px 22px; font-weight:700; text-decoration:none; border:1px solid transparent;
        }
        .btn-ghost{ background:#111; color:#fff }
        .btn-ghost:hover{ filter:brightness(1.05) }
        .btn-primary{ background:var(--red); color:#fff }
        .btn-primary:hover{ filter:brightness(1.05) }

        /* ====== Responsive ====== */
        @media (max-width: 992px){
            .reg-form{ grid-template-columns: 1fr; }
            .reg-label{ padding-top:6px }
        }
        @media (max-width: 576px){
            .reg-card{ padding:20px 16px 12px }
            .reg-ribbon{ margin:-28px auto 12px }
            .reg-ribbon h2{ font-size:16px; padding:10px 22px }
        }

    </style>
    <section class="reg-wrap" aria-labelledby="regTitle" ng-controller="registerForm" ng-cloak>
        <div class="reg-card">
            <!-- Ruy-băng tiêu đề -->
            <div class="reg-ribbon">
                <h2 id="regTitle">THÔNG TIN TÀI KHOẢN</h2>
            </div>

            <p class="reg-intro">
                Vui lòng cung cấp các thông tin sau để được hỗ trợ tốt nhất
            </p>

            <form class="reg-form" id="form-register">
                <!-- Họ tên -->
                <div class="reg-row">
                    <label for="fullname" class="reg-label">
          <span class="ico">
            <!-- user icon -->
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.42 0-8 2.13-8 4.75V21h16v-2.25C20 16.13 16.42 14 12 14Z"/></svg>
          </span>
                        Họ và tên <b class="req">*</b>
                    </label>
                    <div class="reg-field">
                        <input id="fullname" name="fullname" type="text" required placeholder="Nhập họ và tên">
                        <div class="invalid-feedback d-block error" role="alert">
                                                            <span ng-if="errors && errors['fullname']">
                                                                <% errors['fullname'][0] %>
                                                            </span>
                        </div>
                    </div>

                </div>


                <!-- Email -->
                <div class="reg-row">
                    <label for="email" class="reg-label">
          <span class="ico">
            <!-- mail icon -->
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 4H4a2 2 0 0 0-2 2v1l10 6 10-6V6a2 2 0 0 0-2-2Zm0 6.5-8 4.8-8-4.8V18a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2Z"/></svg>
          </span>
                        Email <b class="req">*</b>
                    </label>
                    <div class="reg-field">
                        <input id="email" name="email" type="email" required>
                        <div class="invalid-feedback d-block error" role="alert">
                                                            <span ng-if="errors && errors['email']">
                                                                <% errors['email'][0] %>
                                                            </span>
                        </div>
                    </div>

                </div>

                <!-- Người giới thiệu (optional) -->
                <div class="reg-row">
                    <label for="ref" class="reg-label">
          <span class="ico">
            <!-- referral icon -->
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm7 8h-2a5 5 0 0 0-10 0H5a7 7 0 0 1 14 0Z"/></svg>
          </span>
                        Người giới thiệu
                    </label>
                    <div class="reg-field">
                        <input id="ref" name="referred_code" type="text" placeholder="Nhập mã giới thiệu (nếu có)">
                        <div class="invalid-feedback d-block error" role="alert">
                                                            <span ng-if="errors && errors['referred_code']">
                                                                <% errors['referred_code'][0] %>
                                                            </span>
                        </div>
                    </div>
                </div>

                <!-- Mật khẩu -->
                <div class="reg-row">
                    <label for="password" class="reg-label">
          <span class="ico">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M17 8h-1V6a4 4 0 0 0-8 0v2H7a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2Zm-7-2a2 2 0 0 1 4 0v2h-4Zm2 11a2 2 0 1 1 2-2 2 2 0 0 1-2 2Z"/></svg>
          </span>
                        Mật khẩu <b class="req">*</b>
                    </label>
                    <div class="reg-field has-toggle">
                        <input id="password" name="password" type="password" minlength="6" required placeholder="Tối thiểu 6 ký tự">
                        <button type="button" class="pw-toggle" aria-label="Hiện/ẩn mật khẩu">👁</button>

                        <div class="invalid-feedback d-block error" role="alert">
                                                            <span ng-if="errors && errors['password']">
                                                                <% errors['password'][0] %>
                                                            </span>
                        </div>
                    </div>
                </div>

                <!-- Nhập lại mật khẩu -->
                <div class="reg-row">
                    <label for="password2" class="reg-label">
          <span class="ico">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M17 8h-1V6a4 4 0 0 0-8 0v2H7a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2v-8a2 2 0 0 0-2-2Zm-7-2a2 2 0 0 1 4 0v2h-4Z"/></svg>
          </span>
                        Nhập lại mật khẩu <b class="req">*</b>
                    </label>
                    <div class="reg-field has-toggle">
                        <input id="password2" name="password-rep" type="password" minlength="6" required placeholder="Nhập lại mật khẩu">
                        <button type="button" class="pw-toggle" aria-label="Hiện/ẩn mật khẩu">👁</button>

                        <div class="invalid-feedback d-block error" role="alert">
                                                            <span ng-if="errors && errors['password-rep']">
                                                                <% errors['password-rep'][0] %>
                                                            </span>
                        </div>
                    </div>
                </div>



                <!-- Nút -->
                <div class="reg-actions">
                    <a href="javascript:history.back()" class="btn btn-ghost">QUAY LẠI</a>
                    <button class="btn btn-primary" type="button" ng-click="registerSubmit()">ĐĂNG KÝ</button>
                </div>
            </form>
        </div>
    </section>


@endsection

@push('scripts')

    <script>
        // Nút hiện/ẩn mật khẩu (áp cho cả 2 ô)
        document.querySelectorAll('.pw-toggle').forEach(btn=>{
            btn.addEventListener('click', ()=>{
                const input = btn.previousElementSibling;
                const type = input.getAttribute('type') === 'password' ? 'text' : 'password';
                input.setAttribute('type', type);
                btn.textContent = type === 'password' ? '👁' : '🙈';
            });
        });
    </script>
    <script>
        app.controller('registerForm', function ($rootScope, $scope, $interval) {
            $scope.errors = [];
            $scope.errorsLogin = [];
            $scope.registerSubmit = function () {
                var url = "{{route('front.submitRegister')}}";
                var data = jQuery('#form-register').serialize();
                $scope.loading = true;
                jQuery.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: data,
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                            jQuery('#form-register')[0].reset();
                            window.location.href = response.redirect_url;
                            $scope.errors = [];
                        } else {
                            $scope.errors = response.errors;
                            toastr.error(response.message);
                        }
                    },
                    error: function () {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        $scope.loading = false;
                        $scope.$apply();
                    }
                });
            }

            $scope.submitLogin = function () {
                var url = "{{route('front.submitLogin')}}";
                var data = jQuery('#form-login').serialize();
                $scope.loading = true;
                jQuery.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: data,
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                            window.location.href = response.redirect_url;
                            $scope.errorsLogin = [];
                        } else {
                            $scope.errorsLogin = response.errors;
                            toastr.warning(response.message);
                        }
                    },
                    error: function () {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        $scope.loading = false;
                        $scope.$apply();
                    }
                });
            }

        })
    </script>
@endpush
