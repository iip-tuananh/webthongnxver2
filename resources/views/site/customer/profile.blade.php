@extends('site.layouts.master')
@section('title')
    {{ $config->web_title }}
@endsection
@section('description')
    {{ strip_tags(html_entity_decode($config->introduction)) }}
@endsection
@section('image')
    {{@$config->image->path ?? ''}}
@endsection

@section('css')
<style>
    /* Tinh chỉnh nhỏ cho block ngân hàng */
    .bank-card .card-header {
        padding-left: 10px;
        background: #f8f9fa;
        border-bottom: 1px solid #eef0f2;
    }

    .bank-card .form-floating > label {
        opacity: .85;
    }

    .bank-card .form-text {
        color: #6c757d;
    }

    /* Giữ label * không bị đẩy lệch trong form-floating */
    .bank-card .form-floating label .req {
        color: #dc3545;
        margin-left: .125rem;
    }


    .refcode-wrap {
        display: inline-flex;
        align-items: center;
        gap: .5rem;
        padding: .375rem .5rem;

        background: #fff;
    }

    .refcode-wrap .email {
        font-weight: 600;
        user-select: all;
        white-space: nowrap;
    }

    .copy-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #dee2e6;
        background: #f8f9fa;
        padding: .25rem;
        border-radius: .375rem;
        cursor: pointer;
        transition: background .15s, border-color .15s, transform .05s;
    }
    .copy-btn:hover { background: #eef1f4; }
    .copy-btn:active { transform: scale(.98); }
    .copy-btn:disabled { opacity:.5; cursor:not-allowed; }

    .copy-hint {
        margin-left: .25rem;
        font-size: .875rem;
        color: #28a745;
        opacity: 0;
        transition: opacity .2s;
    }
    .copy-hint.show { opacity: 1; }

</style>

    <style>
        /* ========== ACCOUNT SIDEBAR STATS ========== */
        .account-aside .account-stats{
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 10px; /* chặt chẽ trong sidebar */
            margin: 12px 0 8px;
        }

        .account-aside .account-stats .stat-item{
            display: grid;
            grid-template-columns: auto 1fr;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border-radius: 12px;
            background: var(--stat-bg, #F6F7FB);
            color: var(--stat-fg, #1C2331);
            border: 1px solid rgba(0,0,0,0.06);
        }

        .account-aside .account-stats .stat-icon{
            width: 36px; height: 36px;
            border-radius: 10px;
            display: grid; place-items: center;
            background: #ECF5FF;               /* nền icon 1 */
            color: #2D7EF7;                     /* màu icon 1 */
        }
        .account-aside .account-stats .stat-item:nth-child(2) .stat-icon{
            background: #EAFBF3;                /* nền icon 2 */
            color: #14B87A;                     /* màu icon 2 */
        }

        .account-aside .account-stats .stat-content{
            min-width: 0;
        }
        .account-aside .account-stats .stat-label{
            font-size: 12px;
            line-height: 1.2;
            color: #6B7280;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .account-aside .account-stats .stat-value{
            font-weight: 800;
            font-size: 16px;
            line-height: 1.25;
            color: #0F172A;
            margin-top: 2px;
        }

        /* Responsive: màn nhỏ xếp 1 cột cho dễ đọc */
        @media (max-width: 575.98px){
            .account-aside .account-stats{
                grid-template-columns: 1fr;
            }
        }


        /* hàng giá trị: cho phép co giãn nhưng không vỡ layout */
        .stat-value{
            display:flex;
            align-items:baseline;
            gap:4px;
            max-width: 100%;
            font-weight:800;
            font-size: clamp(14px, 2.6vw, 16px);
            line-height:1.25;
        }

        /* chỉ cắt phần SỐ nếu dài quá, vẫn giữ được ký hiệu ₫ */
        .stat-value .stat-num{
            min-width: 0;            /* quan trọng để ellipsis hoạt động trong flex */
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            display:block;
        }

        /* ₫ luôn hiển thị */
        .stat-value .stat-currency{
            flex: 0 0 auto;
            white-space: nowrap;
            opacity:.9;
        }

        /* số đẹp hơn khi canh lưới */
        .stat-value .stat-num,
        .stat-value .stat-currency{
            font-variant-numeric: tabular-nums;
        }

    </style>


    <style>
        /* ========== Referral / Invite field ========== */
        .invite-field { --c-border:#e6e8ec; --c-border-strong:#c8ccd3; --c-text:#111827; --c-muted:#6b7280; --c-bg:#fff;
            --c-primary:#1463ff; --c-primary-weak:#e7efff; --radius:12px; --gap:10px; }

        .invite-label { display:flex; align-items:center; gap:8px; margin-bottom:6px; }
        .invite-title { font-weight:600; color:var(--c-text); }

        .invite-help { color:var(--c-muted); font-size:12px; margin-bottom:8px; }

        .invite-input-wrap { position:relative; display:flex; align-items:center; border:1px solid var(--c-border);
            border-radius:var(--radius); padding:10px 10px; background:var(--c-bg); transition:.2s border-color, .2s box-shadow; }

        .invite-input-wrap:focus-within { border-color:var(--c-primary); box-shadow:0 0 0 4px var(--c-primary-weak); }

        .invite-input-wrap.is-disabled { opacity:.75; background:#fafafa; }

        .invite-icon { display:inline-flex; align-items:center; justify-content:center; margin-right:8px; color:#334155; opacity:.9; }
        .invite-icon svg { fill: currentColor; }

        .invite-input { appearance:none; border:0; outline:0; flex:1 1 auto; font-size:14px; color:var(--c-text); background:transparent; min-width:0; }
        .invite-input::placeholder { color:#9aa0a6; }

        .invite-actions { display:flex; gap:6px; margin-left:8px; }

        .btn-ghost, .btn-primary {
            border:1px solid transparent; background:transparent; color:#1f2937; padding:6px 10px; border-radius:10px; font-size:12px; line-height:1; cursor:pointer;
        }
        .btn-ghost:hover { background:#f3f4f6; }
        .btn-primary { background:var(--c-primary); color:#fff; }
        .btn-primary:hover { filter:brightness(0.95); }
        .sm { padding:6px 10px; }

        .is-invalid { }
        .is-valid { }

        .has-error .invite-input-wrap { border-color:#ef4444; box-shadow:0 0 0 4px rgba(239,68,68,.08); }
        .has-success .invite-input-wrap { border-color:#16a34a; }

        .invalid-feedback, .valid-feedback { font-size:12px; margin-top:6px; }
        .valid-feedback { color:#16a34a; }

        .invite-tip { display:flex; align-items:center; gap:6px; color:var(--c-muted); font-size:12px; margin-top:6px; }
        .invite-tip .dot { width:6px; height:6px; border-radius:50%; background:#cbd5e1; display:inline-block; }

        /* Responsive niceties */
        @media (max-width: 480px) {
            .invite-actions { gap:4px; }
            .btn-ghost.sm, .btn-primary.sm { padding:6px 8px; }
        }
    </style>
@endsection

@section('content')
    <main class="wrapper" ng-controller="profilePage">

        <section class="sBanner sBanner--sub">
            <div class="sBanner__inner">
                <div class="sBanner__item">
                    <a href="#" class="sBanner__item__bg "
                       style="background-image: url({{ $banner->image->path ?? '' }})"> </a>
                    <div class="container">
                        <a href="#" class="sBanner__item__inner ">
                        </a>
                    </div>
                </div>
            </div>
            <div class="container">
                <div class="sBanner__dots"></div>
                <div class="sBanner__arrows">
                    <div class="arrow arrow--prev"><i class="arrow_left"></i></div>
                    <div class="arrow arrow--next"><i class="arrow_right"></i></div>
                </div>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ route('front.home-page') }}" title="Trang chủ">Trang chủ</a>
                        </li>

                        <li class="breadcrumb-item active" aria-current="page">Quản lý tài khoản</li>
                    </ol>
                </nav>
            </div>
        </section>

        <div class="content" >

            <section class="pages">
                <section class="account-page">
                    <div class="container">
                        <div class="account-grid">
                            <!-- SIDEBAR -->
                            <aside class="account-aside">
                                <div class="user-card-info">
                                    <div class="avatar-user">
                                        <img
                                            ng-src="<% avatarPreviewUrl %>"
                                            alt="Avatar">
                                        <input id="avatar-input" type="file" accept="image/*" file-model="form.avatar" style="display:none">

                                        <button class="avatar-edit" type="button" title="Đổi ảnh đại diện" ng-click="pickAvatar()">
                                            <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true">
                                                <path d="M12 8a4 4 0 100 8 4 4 0 000-8zm7-3h-2.2l-.7-1.4A2 2 0 0014.3 2H9.7a2 2 0 00-1.8 1.1L7.2 5H5a2 2 0 00-2 2v10a3 3 0 003 3h12a3 3 0 003-3V7a2 2 0 00-2-2z" fill="currentColor"/>
                                            </svg>
                                        </button>
                                    </div>
                                    <div class="user-info">
                                        <strong class="name">{{ $customer->fullname }}</strong>
                                        <span class="email">{{ $customer->email }}</span>
                                        <div class="refcode-wrap">
  <span class="email" id="refCode" title="Mã giới thiệu của bạn" style="margin-bottom: 0 !important;">
    {{ $customer->code }}
  </span>

                                            <button
                                                type="button"
                                                class="copy-btn"
                                                id="copyRefBtn"
                                                aria-label="Sao chép mã giới thiệu"
                                                data-code="{{ $customer->code }}"
                                                @if(empty($customer->code)) disabled @endif
                                            >
                                                <!-- Icon copy (SVG) -->
                                                <svg width="18" height="18" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path d="M16 1H4a2 2 0 0 0-2 2v12h2V3h12V1zm3 4H8a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h11a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2zm0 16H8V7h11v14z"/>
                                                </svg>
                                            </button>

                                            <span class="copy-hint" id="copyHint" role="status" aria-live="polite"></span>
                                        </div>


                                        <!-- STATS: Referral + Commission -->
                                        <div class="account-stats" role="group" aria-label="Thống kê giới thiệu">
                                            <!-- Stat: Số người đã nhập mã -->
                                            <div class="stat-item" title="Số người đã nhập mã giới thiệu của bạn">
                                                <div class="stat-icon" aria-hidden="true">
                                                    <!-- Users/Group icon -->
                                                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none">
                                                        <path d="M16 11a3 3 0 10-2.999-3A3 3 0 0016 11zm-8 0a3 3 0 10-3-3 3 3 0 003 3zm0 2c-3.314 0-6 1.791-6 4v1a1 1 0 001 1h10a1 1 0 001-1v-1c0-2.209-2.686-4-6-4zm8 0c-.734 0-1.431.099-2.072.278a5.694 5.694 0 012.072 3.722V18a1 1 0 001 1h5a1 1 0 001-1v-.999C23 14.79 20.314 13 17 13z" fill="currentColor"/>
                                                    </svg>
                                                </div>
                                                <div class="stat-content">
                                                    <div class="stat-label">Người đã nhập mã</div>
                                                    <div class="stat-value">
                                                        {{ number_format($customer->userCommissions ?? 0) }}
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Stat: Tổng hoa hồng -->
                                            <div class="stat-item" title="Tổng tiền hoa hồng đã nhận">
                                                <div class="stat-icon" aria-hidden="true">
                                                    <!-- Coin stack icon -->
                                                    <svg viewBox="0 0 24 24" width="22" height="22" fill="none">
                                                        <path d="M12 3C7.582 3 4 4.79 4 7s3.582 4 8 4 8-1.79 8-4-3.582-4-8-4zm8 7.09V12c0 2.21-3.582 4-8 4s-8-1.79-8-4V10.1C5.57 11.29 8.57 12 12 12s6.43-.71 8-1.91zM20 15v2c0 2.21-3.582 4-8 4s-8-1.79-8-4v-2c1.57 1.19 4.57 1.9 8 1.9s6.43-.71 8-1.9z" fill="currentColor"/>
                                                    </svg>
                                                </div>
                                                <div class="stat-content">
                                                    <div class="stat-label">Hoa hồng đã nhận</div>
                                                    <div class="stat-value" title="{{ number_format($customer->totalCommission ?? 0, 0, ',', '.') }}₫">
                                                        <span class="stat-num">{{ number_format($customer->totalCommission ?? 0, 0, ',', '.') }}</span>
                                                        <span class="stat-currency">₫</span>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>



                                        <a class="btn btn-ghost btn-logout">Đăng xuất</a>
                                    </div>
                                </div>

                                <nav class="account-menu" aria-label="Menu tài khoản">
                                    <a class="menu-item  is-active" href="#orders" data-tab="orders">
                                        <span class="mi-icon">🧾</span> Bài viết đã mua
                                    </a>
                                    <a class="menu-item" href="#commissions" data-tab="commissions">
                                        <span class="mi-icon">💰</span> Hoa hồng nhận được
                                    </a>
                                    <a class="menu-item" href="#info" data-tab="info">
                                        <span class="mi-icon">✎</span> Thay đổi thông tin tài khoản
                                    </a>
                                    <a class="menu-item btn-logout" href="#">
                                        <span class="mi-icon">↩</span> Đăng xuất
                                    </a>
                                </nav>
                            </aside>

                            <!-- MAIN -->
                            <main class="account-main">
                                <!-- Tab: Thông tin -->
                                <div class="panel" id="info" role="tabpanel">
                                    <h5 class="panel-title">Thông tin tài khoản</h5>

                                    <form class="form-styled">
                                        <div class="form-grid">
                                            <div class="form-group">
                                                <label for="display_name">Họ tên <span class="req">*</span></label>
                                                <input id="display_name" name="display_name" type="text"
                                                       ng-model="form.fullname">
                                                <small class="hint"></small>
                                                <div class="invalid-feedback d-block" ng-if="errors['fullname']"><% errors['fullname'][0] %></div>
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Địa chỉ email <span class="req">*</span></label>
                                                <input id="email" name="email" type="email"
                                                       ng-model="form.email" disabled>
                                            </div>
{{--                                            <div class="form-group">--}}
{{--                                                <label for="referred_code">Nhập mã người giới thiệu <span class="req"></span></label>--}}
{{--                                                <input id="referred_code" name="referred_code" type="text"--}}
{{--                                                       ng-model="form.referred_code" >--}}
{{--                                                <div class="invalid-feedback d-block" ng-if="errors['referred_code']"><% errors['referred_code'][0] %></div>--}}
{{--                                            </div>--}}





                                        </div>

                                        <div class="form">
                                            <div class="card bank-card" style="margin-bottom: 20px">
                                                <div class="card-header py-2">
                                                    <strong>Thông tin ngân hàng của bạn</strong>
                                                </div>

                                                <div class="card-body">
                                                    <div class="row g-3">
                                                        <!-- Tên ngân hàng -->
                                                        <div class="col-12 col-md-4">
                                                            <div class="form-floating">
                                                                <input
                                                                    id="bank_name"
                                                                    name="bank_name"
                                                                    type="text"
                                                                    placeholder="Tên ngân hàng"
                                                                    class="form-control"
                                                                    ng-model="form.bank_name"
                                                                    ng-class="{'is-invalid': errors['bank_name']}"
                                                                />
                                                                <label for="bank_name">Tên ngân hàng</label>
                                                                <div class="invalid-feedback" ng-if="errors['bank_name']">
                                                                    <% errors['bank_name'][0] %>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Số tài khoản -->
                                                        <div class="col-12 col-md-4">
                                                            <div class="form-floating">
                                                                <input
                                                                    id="bank_number"
                                                                    name="bank_number"
                                                                    type="text"
                                                                    placeholder="Số tài khoản"
                                                                    class="form-control"
                                                                    ng-model="form.bank_number"
                                                                    ng-class="{'is-invalid': errors['bank_number']}"
                                                                    inputmode="numeric"
                                                                    autocomplete="off"
                                                                />
                                                                <label for="bank_number">Số tài khoản </label>
                                                                <div class="invalid-feedback" ng-if="errors['bank_number']">
                                                                    <% errors['bank_number'][0] %>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- Chủ tài khoản -->
                                                        <div class="col-12 col-md-4">
                                                            <div class="form-floating">
                                                                <input
                                                                    id="user_bank_name"
                                                                    name="user_bank_name"
                                                                    type="text"
                                                                    placeholder="Chủ tài khoản"
                                                                    class="form-control"
                                                                    ng-model="form.user_bank_name"
                                                                    ng-class="{'is-invalid': errors['user_bank_name']}"
                                                                    style="text-transform: uppercase"
                                                                />
                                                                <label for="user_bank_name">Chủ tài khoản </label>
                                                                <div class="invalid-feedback" ng-if="errors['user_bank_name']">
                                                                    <% errors['user_bank_name'][0] %>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="form-text mt-2">
                                                        Ví dụ: <em>Vietcombank · 0123456789 · NGUYEN VAN A</em>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Invite / Referral Code -->
                                        <div class="form-group invite-field" ng-class="{'has-error': errors['referred_code'], 'has-success': invite.state==='valid'}">
                                            <label for="referred_code" class="invite-label">
                                                <span class="invite-title">Nhập mã người giới thiệu</span>
                                                <span class="req" aria-hidden="true"></span>
                                            </label>

                                            <!-- helper line -->
                                            <div class="invite-help" id="referred_code_help">
                                                Ví dụ: KH000001. Mã không phân biệt hoa/thường, không có khoảng trắng.
                                            </div>

                                            <div class="invite-input-wrap" ng-class="{'is-disabled': invite.locked}">
                                                <!-- leading icon -->
                                                <span class="invite-icon" aria-hidden="true">
      <!-- user-badge icon (inline SVG để không phụ thuộc thư viện) -->
      <svg viewBox="0 0 24 24" width="20" height="20" focusable="false" aria-hidden="true">
        <path d="M12 12a5 5 0 1 0-5-5 5 5 0 0 0 5 5Zm0 2c-4.42 0-8 2.24-8 5v1a1 1 0 0 0 1 1h14a1 1 0 0 0 1-1v-1c0-2.76-3.58-5-8-5Z"/>
        <circle cx="18.5" cy="6.5" r="3.25"></circle>
      </svg>
    </span>

                                                <!-- input -->
                                                <input
                                                    id="referred_code"
                                                    name="referred_code"
                                                    type="text"
                                                    class="invite-input"
                                                    ng-model="form.referred_code"
                                                    ng-model-options="{ debounce: 250 }"
                                                    ng-disabled="invite.locked"
                                                    aria-describedby="referred_code_help"
                                                    placeholder="Nhập mã (ví dụ: KH000001)"
                                                    ng-trim="true"
                                                    ng-class="{'is-invalid': errors['referred_code'], 'is-valid': invite.state==='valid'}"
                                                />

                                                <!-- trailing actions -->
                                                <div class="invite-actions">
                                                    <button type="button" class="btn-ghost sm" title="Dán" ng-click="invite.paste()" ng-disabled="invite.locked">Dán</button>
                                                    <button type="button" class="btn-ghost sm" title="Xóa" ng-click="invite.clear()" ng-disabled="invite.locked || !form.referred_code">Xóa</button>
                                                </div>
                                            </div>

                                            <!-- inline feedback -->
                                            <div class="invalid-feedback d-block" ng-if="errors['referred_code']"><% errors['referred_code'][0] %></div>
                                            <div class="valid-feedback d-block" ng-if="invite.state==='valid' && !errors['referred_code']">
                                                ✅ Mã hợp lệ. Người giới thiệu: <strong><% invite.referrer_name %></strong>
                                            </div>

                                            <!-- subtle tips -->
                                            <div class="invite-tip">
                                                <span class="dot"></span> Bạn có thể bỏ qua nếu không có mã.
                                            </div>
                                        </div>

                                        <h4 class="panel-subtitle">Thay đổi mật khẩu</h4>
                                        <div class="form-grid">
                                            <div class="form-group col-span-2">
                                                <label for="current_password">Mật khẩu hiện tại (bỏ trống nếu không
                                                    đổi)</label>
                                                <input id="current_password" name="current_password" type="password" ng-model="form.current_password"
                                                       autocomplete="current-password">
                                                <div class="invalid-feedback d-block" ng-if="errors['current_password']">
                                                    <% errors['current_password'][0] %>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="new_password">Mật khẩu mới (bỏ trống nếu không đổi)</label>
                                                <input id="new_password" name="new_password" type="password" ng-model="form.new_password"
                                                       autocomplete="new-password">
                                                <div class="invalid-feedback d-block" ng-if="errors['new_password']">
                                                    <% errors['new_password'][0] %>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="confirm_password">Xác nhận mật khẩu mới</label>
                                                <input id="confirm_password" name="confirm_password" type="password" ng-model="form.new_password_confirmation"
                                                       autocomplete="new-password">
                                                <div class="invalid-feedback d-block" ng-if="errors['new_password_confirmation']">
                                                    <% errors['new_password_confirmation'][0] %>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-actions">
                                            <button class="btn btn-primary"
                                                    type="button"
                                                    ng-click="submitInfo()"
                                                    ng-disabled="loading"
                                                    aria-busy="<% loading %>">
                                                <span ng-if="!loading"><i class="fas fa-save me-1"></i> Lưu thay đổi</span>
                                                <span ng-if="loading"><i class="fas fa-spinner fa-spin me-1"></i> Đang lưu…</span>
                                            </button>

                                        </div>
                                    </form>
                                </div>

                                <!-- Tab: Đơn hàng -->
                                <div class="panel  is-active" id="orders" role="tabpanel" aria-hidden="true">
                                    <h5 class="panel-title">Quản lý bài viết</h5>
                                    <!-- Demo table; thay bằng loop đơn hàng của bạn -->
                                    <div class="table-wrap">
                                        <table class="table-orders">
                                            <thead>
                                            <tr>
                                                <th>Mã đơn hàng</th>
                                                <th>Bài viết</th>
                                                <th>Ngày mua</th>
                                                <th>Trạng thái</th>
                                                <th></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($orderDetails ?? [] as $item)
                                                <tr>
                                                    <td>{{ $item->order->code ?? ''}}</td>
                                                    <td>
                                                        <a href="{{ route('front.blogDetail', $item->post->slug ?? '') }}">{{ $item->post->name ?? ''}}</a><br>
                                                        <span> {{ formatCurrency($item->price) }}đ</span>
                                                    </td>
                                                    <td>{{ $item->created_at->format('d/m/Y H:i') }}</td>
                                                    <td>{{ $item->status == 1 ? 'Chờ duyệt' : 'Đã kích hoạt' }}</td>
                                                </tr>
                                            @endforeach
                                            @if(empty($orderDetails) || count($orderDetails)===0)
                                                <tr>
                                                    <td colspan="5">Chưa có bài viết nào.</td>
                                                </tr>
                                            @endif
                                            </tbody>
                                        </table>
                                    </div>

                                    <style>
                                        #orders .orders-pager{
                                            display:flex;
                                            justify-content:center;
                                            margin:16px 0 4px;
                                        }
                                    </style>

                                    @if(!empty($orderDetails) && method_exists($orderDetails, 'links'))
                                        <div class="orders-pager">
                                            {{ $orderDetails->fragment('orders')->links('site.pagination.paginate2') }}
                                        </div>
                                    @endif
                                </div>

                                <div class="panel" id="commissions" role="tabpanel" aria-hidden="true">
                                    <h5 class="panel-title">Quản lý hoa hồng</h5>
                                    <form method="GET" action="{{ request()->url() }}#commissions" class="commission-search">
                                        <div class="row g-2 align-items-end">
                                            <div class="col-12 col-md-4">
                                                <label class="form-label mb-1">Mã đối soát</label>
                                                <input type="text" name="code" class="form-control"
                                                       placeholder="Ví dụ: COM-202510-0123"
                                                       value="{{ request('code') }}">
                                            </div>

                                            <div class="col-12 col-md-4">
                                                <label class="form-label mb-1">Mã hoặc tên KH phát sinh hoa hồng</label>
                                                <input type="text" name="customer_code" class="form-control"
                                                       placeholder="Ví dụ: KH000123"
                                                       value="{{ request('customer_code') }}">
                                            </div>

                                            <div class="col-12 col-md-4 d-flex gap-2">
                                                <button type="submit" class="btn btn-primary flex-grow-1">Tìm kiếm</button>
                                                <a href="{{ url()->current() }}#commissions" class="btn btn-outline-secondary" data-no-ajax="true">Clear</a>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="table-wrap">
                                        <table class="table-orders">
                                            <thead>
                                            <tr>
                                                <th>Mã đối soát</th>
                                                <th>Khách hàng phát sinh hoa hồng</th>
                                                <th>Hoa hồng được nhận</th>
                                                <th>Ngày tạo</th>
                                                <th>Trạng thái</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($commissions ?? [] as $commission)
                                                <tr>
                                                    <td>{{ $commission->code ?? ''}}</td>
                                                    <td>{{ $commission->nguoigioithieu->fullname ?? ''}} - {{ $commission->nguoigioithieu->code }}</td>
                                                    <td>{{ formatCurrency($commission->amount_commissions) }}đ </td>
                                                    <td>{{ $commission->created_at->format('d/m/Y H:i') }}</td>
                                                    <td>{{ \App\Model\Admin\Commission::STATUSES_WITHKEY[$commission->status]['name'] }}</td>

                                                </tr>
                                            @endforeach


                                            @if(empty($commissions) || count($commissions)===0)
                                                <tr>
                                                    <td colspan="5">Chưa có dữ liệu.</td>
                                                </tr>
                                            @endif


                                            </tbody>
                                        </table>
                                    </div>

                                    <style>
                                        #commissions .orders-pager{
                                            display:flex;
                                            justify-content:center;
                                            margin:16px 0 4px;
                                        }
                                    </style>
                                    <style>
                                        .commission-search{margin:10px 0 14px;padding:10px;border:1px solid #eee;border-radius:8px;background:#fafafa}
                                        .commission-search .form-control{height:38px}
                                        #commissions .orders-pager{display:flex;justify-content:center;margin:16px 0 4px}
                                        .table-orders{width:100%}
                                        .table-orders th,.table-orders td{padding:10px 12px;border-bottom:1px solid #f1f1f1}
                                        .table-orders thead th{background:#f8f9fa;font-weight:700}
                                    </style>


                                    @if(!empty($commissions) && method_exists($commissions, 'links'))
                                        <div class="orders-pager">
                                            {{-- giữ lại tham số tìm kiếm khi phân trang --}}
                                            {{ $commissions->appends(request()->only(['code','customer_code']))
                                                           ->fragment('commissions')
                                                           ->links('site.pagination.paginate2') }}
                                        </div>
                                    @endif
                                </div>
                            </main>
                        </div>
                    </div>
                </section>

                <style>
                    :root {
                        --acc-bg: #fff;
                        --acc-border: #e8edf2;
                        --acc-muted: #6b7280;
                        --acc-primary: #ff6a00; /* bạn đổi theo brand */
                        --acc-ring: rgba(255, 106, 0, .15);
                        --radius: 14px;
                        --shadow: 0 6px 20px rgba(0, 0, 0, .06);
                        --gap: 22px;
                    }

                    .account-grid {
                        display: grid;
                        grid-template-columns:280px 1fr;
                        gap: var(--gap);
                    }

                    .account-aside {
                        position: sticky;
                        top: 24px;
                        height: max-content
                    }

                    .user-card-info {
                        background: var(--acc-bg);
                        border: 1px solid var(--acc-border);
                        border-radius: var(--radius);
                        padding: 18px;
                        box-shadow: var(--shadow);
                        text-align: center
                    }

                    .avatar-user {
                        position: relative;
                        width: 104px;
                        height: 104px;
                        margin: 8px auto 12px
                    }

                    .avatar-user img {
                        width: 100%;
                        height: 100%;
                        object-fit: cover;
                        border-radius: 50%;
                        border: 4px solid #f3f6f9
                    }

                    .avatar-edit {
                        position: absolute;
                        right: -4px;
                        bottom: -4px;
                        border: 0;
                        background: #fff;
                        border-radius: 999px;
                        padding: 8px;
                        box-shadow: var(--shadow);
                        cursor: pointer
                    }

                    .user-info .name {
                        display: block;
                        margin-bottom: 2px
                    }

                    .user-info .email {
                        display: block;
                        color: var(--acc-muted);
                        font-size: .92rem;
                        margin-bottom: 10px
                    }

                    .btn {
                        display: inline-flex;
                        align-items: center;
                        justify-content: center;
                        gap: 8px;
                        border-radius: 12px;
                        padding: 10px 14px;
                        border: 1px solid transparent;
                        cursor: pointer;
                        transition: .2s
                    }

                    .btn-ghost {
                        background: #fff;
                        border-color: var(--acc-border);
                        color: #111
                    }

                    .btn-ghost:hover {
                        border-color: #cfd7df
                    }

                    .btn-primary {
                        background: var(--acc-primary);
                        color: #fff
                    }

                    .btn-primary:hover {
                        filter: brightness(.95)
                    }

                    .account-menu {
                        margin-top: 14px;
                        background: var(--acc-bg);
                        border: 1px solid var(--acc-border);
                        border-radius: var(--radius);
                        box-shadow: var(--shadow);
                        overflow: hidden
                    }

                    .account-menu .menu-item {
                        display: flex;
                        gap: 10px;
                        align-items: center;
                        padding: 12px 16px;
                        color: #111;
                        border-left: 3px solid transparent
                    }

                    .account-menu .menu-item + .menu-item {
                        border-top: 1px dashed var(--acc-border)
                    }

                    .account-menu .menu-item:hover {
                        background: #fafbfc
                    }

                    .account-menu .menu-item.is-active {
                        background: linear-gradient(0deg, rgba(255, 106, 0, .06), rgba(255, 106, 0, .06));
                        border-left-color: var(--acc-primary)
                    }

                    .mi-icon {
                        width: 20px;
                        display: inline-block;
                        text-align: center;
                        opacity: .8
                    }

                    .account-main .panel {
                        display: none;
                        background: var(--acc-bg);
                        border: 1px solid var(--acc-border);
                        border-radius: var(--radius);
                        box-shadow: var(--shadow);
                        padding: 18px
                    }

                    .account-main .panel.is-active {
                        display: block
                    }

                    .panel-title {
                        margin: 4px 0 14px
                    }

                    .panel-subtitle {
                        margin: 10px 0 10px;
                        color: #111
                    }

                    .form-styled input {
                        width: 100%;
                        padding: 10px 12px;
                        border: 1px solid var(--acc-border);
                        border-radius: 12px;
                        outline: none
                    }

                    .form-styled input:focus {
                        border-color: var(--acc-primary);
                        box-shadow: 0 0 0 4px var(--acc-ring)
                    }

                    .form-styled label {
                        display: block;
                        margin: 0 0 6px;
                        font-weight: 600
                    }

                    .form-styled .hint {
                        display: block;
                        margin-top: 6px;
                        color: var(--acc-muted);
                        font-size: .9rem
                    }

                    .form-styled .req {
                        color: #ef4444
                    }

                    .form-grid {
                        display: grid;
                        grid-template-columns:1fr 1fr;
                        gap: 14px
                    }

                    .form-group.col-span-2 {
                        grid-column: 1/-1
                    }

                    .form-actions {
                        margin-top: 6px
                    }

                    .table-wrap {
                        overflow: auto
                    }

                    .table-orders {
                        width: 100%;
                        border-collapse: separate;
                        border-spacing: 0
                    }

                    .table-orders th, .table-orders td {
                        padding: 12px 10px;
                        border-bottom: 1px solid var(--acc-border);
                        text-align: left
                    }

                    .table-orders thead th {
                        background: #fafbfc;
                        font-weight: 700
                    }

                    /* Responsive */
                    @media (max-width: 992px) {
                        .account-grid {
                            grid-template-columns:1fr
                        }

                        .account-aside {
                            position: static
                        }
                    }

                    @media (max-width: 640px) {
                        .form-grid {
                            grid-template-columns:1fr
                        }

                        .account-menu .menu-item {
                            padding: 12px
                        }
                    }
                </style>


                <div class="sec-dec"></div>
            </section>
            <!--about end   -->
        </div>

    </main>
@endsection

@push('scripts')
    <script>
        // Tabs: click menu to show panel
        document.addEventListener('click', function (e) {
            const link = e.target.closest('.account-menu .menu-item[data-tab]');
            if (!link) return;
            e.preventDefault();
            const tab = link.dataset.tab;

            // active menu
            document.querySelectorAll('.account-menu .menu-item').forEach(a => a.classList.toggle('is-active', a === link));
            // active panel
            document.querySelectorAll('.account-main .panel').forEach(p => p.classList.toggle('is-active', p.id === tab));
        });

        // support open by hash
        window.addEventListener('load', () => {
            const hash = location.hash.replace('#', '');
            if (!hash) return;
            const link = document.querySelector(`.account-menu .menu-item[data-tab="${hash}"]`);
            if (link) {
                link.click();
            }
        });
    </script>
    <script>
        app.controller('profilePage', function ($rootScope, $scope, $interval) {
            $scope.form = @json($customer);

            $scope.avatarPreviewUrl = window.USER_AVATAR_URL;
            $scope.form.avatar = null;
            $scope.pickAvatar = function () {
                document.getElementById('avatar-input').click();
            };

            $scope.$watch('form.avatar', function (newFile) {
                if (!newFile) return;

                const isImage = newFile.type ? newFile.type.startsWith('image/') : /\.(png|jpe?g|gif|webp|bmp|svg)$/i.test(newFile.name || '');
                if (!isImage) {
                    alert('Vui lòng chọn tệp hình ảnh');
                    $scope.form.avatar = null;
                    return;
                }
                const MAX = 5 * 1024 * 1024; // 5MB
                if (newFile.size > MAX) {
                    alert('Ảnh vượt quá 5MB, vui lòng chọn ảnh nhỏ hơn.');
                    $scope.form.avatar = null;
                    return;
                }

                const reader = new FileReader();
                reader.onload = function (e) {
                    $scope.$apply(() => {
                        $scope.avatarPreviewUrl = e.target.result; // hiển thị xem trước
                    });
                };
                reader.readAsDataURL(newFile);
            });



            $scope.submitInfo = function () {
                if ($scope.loading) return;

                $scope.loading = true;
                var fd = new FormData();
                fd.append('fullname', $scope.form.fullname);
                fd.append('email',    $scope.form.email);
                fd.append('referred_code',    $scope.form.referred_code ?? '');
                fd.append('user_bank_name',    $scope.form.user_bank_name ?? '');
                fd.append('bank_name',    $scope.form.bank_name ?? '');
                fd.append('bank_number',    $scope.form.bank_number ?? '');
                fd.append('current_password',    $scope.form.current_password ?? '');
                fd.append('new_password',    $scope.form.new_password ?? '' );
                fd.append('new_password_confirmation',    $scope.form.new_password_confirmation ?? '');

                if ($scope.form.avatar) {
                    fd.append('avatar', $scope.form.avatar);
                }

                $.ajax({
                    type: 'POST',
                    url:  "{{ route('front.updateProfile') }}",
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        if (response.success) {
                            $scope.errors = [];
                            toastr.success(response.message);
                            // setTimeout(function() {
                            //     window.location.reload();
                            // }, 1000);
                        } else {
                            $scope.errors = response.errors;
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

            $('.btn-logout').on('click', function(e){
                e.preventDefault();

                $.ajax({
                    url: '{{ route("front.logout") }}',
                    type: 'POST',
                    data: {
                        _token: CSRF_TOKEN
                    },
                    success: function() {
                        window.location.href = '{{ route("front.home-page") }}';
                    },
                    error: function() {
                        window.location.href = '{{ route("front.home-page") }}';
                    }
                });
            });



            $scope.invite = {
                paste: async function () {
                    try {
                        if (navigator.clipboard) {
                            const text = await navigator.clipboard.readText();
                            $scope.$applyAsync(()=> { $scope.form.referred_code = (text || '').trim().toUpperCase(); $scope.invite.onChange($scope.form.referred_code); });
                        }
                    } catch(e){ /* no-op */ }
                },

                clear: function () {
                    $scope.form.referred_code = '';
                    $scope.invite.state = null;
                    $scope.errors && delete $scope.errors['referred_code'];
                },
            };





        })
    </script>
    <script>
        (function() {
            const btn = document.getElementById('copyRefBtn');
            const hint = document.getElementById('copyHint');

            if (!btn) return;

            let hideTimer = null;

            async function copyText(text) {
                if (!text) return false;
                try {
                    if (navigator.clipboard && window.isSecureContext) {
                        await navigator.clipboard.writeText(text);
                    } else {
                        // Fallback cho trình duyệt cũ / không https
                        const ta = document.createElement('textarea');
                        ta.value = text;
                        ta.style.position = 'fixed';
                        ta.style.left = '-9999px';
                        document.body.appendChild(ta);
                        ta.focus();
                        ta.select();
                        document.execCommand('copy');
                        document.body.removeChild(ta);
                    }
                    return true;
                } catch (e) {
                    return false;
                }
            }

            btn.addEventListener('click', async function () {
                const code = this.dataset.code || '';
                const ok = await copyText(code);
                clearTimeout(hideTimer);

                if (ok) {
                    hint.textContent = 'Đã sao chép!';
                    hint.classList.add('show');
                    this.classList.add('copied');
                    hideTimer = setTimeout(() => {
                        hint.classList.remove('show');
                        this.classList.remove('copied');
                    }, 1500);
                } else {
                    hint.textContent = 'Không thể sao chép, hãy bôi đen và Ctrl+C.';
                    hint.classList.add('show');
                    hideTimer = setTimeout(() => hint.classList.remove('show'), 2500);
                }
            });
        })();
    </script>

@endpush
