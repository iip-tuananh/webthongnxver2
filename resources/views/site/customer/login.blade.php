@extends('site.layouts.master')
@section('title')Đăng nhập - {{ $config->web_title }}@endsection
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
            display:flex; justify-content:center; gap:16px; margin-top:10px;
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

        /* ===== Login meta block ===== */
        .reg-wrap .reg-meta{
            margin-top: 14px;
            text-align: center;
            color: #475569; /* slate-600 */
            font-size: 14px;
        }

        .reg-wrap .reg-divider{
            position: relative;
            margin: 10px 0 14px;
            height: 1px;
            background: linear-gradient(90deg, transparent, #e5e7eb 30%, #e5e7eb 70%, transparent);
        }
        .reg-wrap .reg-divider span{
            position: relative;
            top: -0.7em;
            display: inline-block;
            padding: 0 10px;
            background: #fff; /* màu nền thẻ form */
            color: #94a3b8;   /* slate-400 */
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .06em;
        }

        .reg-wrap .reg-subline{
            display: inline-flex;
            align-items: center;
            gap: 8px;
            justify-content: center;
            margin: 0;
            line-height: 1.4;
            flex-wrap: wrap;
        }
        .reg-wrap .reg-subline__icon{
            width: 28px;
            height: 28px;
            border-radius: 8px;
            display: grid;
            place-items: center;
            background: #EEF2FF; /* indigo-50 */
            color: #4F46E5;      /* indigo-600 */
        }

        .reg-wrap .link-accent{
            font-weight: 700;
            color: #2563EB;             /* blue-600 */
            text-decoration: none;
            border-bottom: 1px dashed rgba(37,99,235,.35);
            transition: color .15s ease, border-color .15s ease;
        }
        .reg-wrap .link-accent:hover{
            color: #1D4ED8;             /* blue-700 */
            border-color: rgba(29,78,216,.6);
        }

        /* Dark background compatibility (nếu form có nền tối) */
        .reg-wrap.dark .reg-divider span{
            background: transparent;
        }

    </style>
    <section class="reg-wrap" aria-labelledby="regTitle" ng-controller="registerForm" ng-cloak>
        <div class="reg-card">
            <!-- Ruy-băng tiêu đề -->
            <div class="reg-ribbon">
                <h2 id="regTitle">Chào mừng bạn đến với {{ $config->short_name_company }}</h2>
            </div>

            <form class="reg-form" id="form-login">
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
                                                            <span ng-if="errorsLogin && errorsLogin['email']">
                                                                <% errorsLogin['email'][0] %>
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
                                                            <span ng-if="errorsLogin && errorsLogin['password']">
                                                                <% errorsLogin['password'][0] %>
                                                            </span>
                        </div>
                    </div>
                </div>



                <!-- Nút -->
                <div class="reg-actions">
                    <a href="javascript:history.back()" class="btn btn-ghost">QUAY LẠI</a>
                    <button class="btn btn-primary" type="button" ng-click="submitLogin()">ĐĂNG NHẬP</button>
                </div>

                <!-- Reg meta: chưa có tài khoản -->
                <div class="reg-actions">
                    <div class="reg-meta" role="note" aria-live="polite">
                        <div class="reg-divider" aria-hidden="true">
                            <span>hoặc</span>
                        </div>

                        <p class="reg-subline">
    <span class="reg-subline__icon" aria-hidden="true">
      <!-- user-plus icon -->
      <svg viewBox="0 0 24 24" width="18" height="18">
        <path fill="currentColor"
              d="M15 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4ZM2 19.5a6.5 6.5 0 0 1 11.8-3.8 8.2 8.2 0 0 0-2.8.9C8.4 17.3 7 18.6 7 20v1H3a1 1 0 0 1-1-1v-.5ZM20 11v-2h-2a1 1 0 0 1 0-2h2V5a1 1 0 0 1 2 0v2h2a1 1 0 0 1 0 2h-2v2a1 1 0 0 1-2 0Z"/>
      </svg>
    </span>
                            <span>Chưa có tài khoản?</span>
                            <a class="link-accent" href="{{ route('front.register') }}" rel="nofollow">
                                Đăng ký tại đây
                            </a>
                        </p>
                    </div>

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
