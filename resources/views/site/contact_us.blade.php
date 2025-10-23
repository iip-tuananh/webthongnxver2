@extends('site.layouts.master')
@section('title')Liên hệ - {{ $config->web_title }}@endsection
@section('description'){{ strip_tags(html_entity_decode($config->introduction)) }}@endsection
@section('image'){{@$config->image->path ?? ''}}@endsection

@section('css')

@endsection

@section('content')
    <main class="wrapper" ng-controller="AboutPage">

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

                        <li class="breadcrumb-item active" aria-current="page">Liên hệ</li>
                    </ol>
                </nav>
            </div>
        </section>
        <section class="pages about">
            <div class="container">
                <nav class="tabLinks">
                    <div class="tabLinks__dropdown">Liên hệ
                    </div>

                    <ul>
                        <li class="active"><a target="_self" href="#!"
                                              title="$menu-&gt;title">Liên hệ</a></li>
                    </ul>
                </nav>
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <!-- CONTACT PAGE -->
                        <section class="contact-section">
                            <div class="container">
                                <div class="contact-grid">
                                    <!-- LEFT: Info -->
                                    <aside class="contact-card">
                                        <h2 class="card-title">Thông tin liên hệ</h2>

                                        <ul class="info-list">
                                            <li class="info-item">
            <span class="icon">
              <!-- location -->
              <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2a7 7 0 0 0-7 7c0 5.25 7 13 7 13s7-7.75 7-13a7 7 0 0 0-7-7Zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5Z"/></svg>
            </span>
                                                <div class="info-body">
                                                    <div class="label">Địa chỉ :</div>
                                                    <div class="value">{{ $config->address_company }}</div>
                                                </div>
                                            </li>

                                            <li class="info-item">
            <span class="icon">
              <!-- phone -->
              <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.62 10.79a15.05 15.05 0 0 0 6.59 6.59l2.2-2.2a1 1 0 0 1 1.01-.24c1.11.37 2.31.57 3.58.57a1 1 0 0 1 1 1V21a1 1 0 0 1-1 1C10.3 22 2 13.7 2 3a1 1 0 0 1 1-1h3.5a1 1 0 0 1 1 1c0 1.27.2 2.47.57 3.58a1 1 0 0 1-.24 1.01l-2.2 2.2Z"/></svg>
            </span>
                                                <div class="info-body">
                                                    <div class="label">Hotline :</div>
                                                    <a class="value link" href="tel:{{ $config->hotline }}">{{ $config->hotline }}</a>
                                                </div>
                                            </li>

                                            <li class="info-item">
            <span class="icon">
              <!-- mail -->
              <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M20 4H4a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2Zm0 4-8 5L4 8V6l8 5 8-5v2Z"/></svg>
            </span>
                                                <div class="info-body">
                                                    <div class="label">Mail :</div>
                                                    <a class="value link" href="mailto:{{ $config->email }}">{{ $config->email }}</a>
                                                </div>
                                            </li>
                                        </ul>

                                        <div class="social">
                                            <div class="social-label">MẠNG XÃ HỘI:</div>
                                            <div class="social-list">
                                                <a class="s-btn" aria-label="Facebook" href="{{ $config->facebook }}"><svg viewBox="0 0 24 24"><path d="M22 12a10 10 0 1 0-11.6 9.9v-7h-2.3v-2.9h2.3V9.4c0-2.3 1.4-3.6 3.5-3.6 1 0 2 .1 3 .3V8h-1.7c-1.3 0-1.7.8-1.7 1.6v1.5h3.1L16 13.9h-2.3v7A10 10 0 0 0 22 12Z"/></svg></a>
                                                <a class="s-btn" aria-label="Twitter/X" href="{{ $config->twitter }}"><svg viewBox="0 0 24 24"><path d="M3 3h4.6l4 6.5L16.5 3H21l-7.2 9.6L21 21h-4.6l-4.3-6.9L7.4 21H3l7.5-9.9L3 3Z"/></svg></a>
                                                <a class="s-btn" aria-label="Instagram" href="{{ $config->instagram }}"><svg viewBox="0 0 24 24"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5Zm5 5.5A4.5 4.5 0 1 0 16.5 12 4.5 4.5 0 0 0 12 7.5Zm6.25-1.75a1.25 1.25 0 1 0 1.25 1.25 1.25 1.25 0 0 0-1.25-1.25Zm-6.25 3A3.25 3.25 0 1 1 8.75 12 3.25 3.25 0 0 1 12 8.75Z"/></svg></a>
                                                <a class="s-btn" aria-label="YouTube" href="{{ $config->youtube }}"><svg viewBox="0 0 24 24"><path d="M23 8.2s-.2-1.7-.8-2.4c-.7-.8-1.5-.8-1.9-.9C17.6 4.6 12 4.6 12 4.6h0s-5.6 0-8.3.3c-.4 0-1.2.1-1.9.9C.2 6.5 0 8.2 0 8.2S0 10 .1 11.8c.1.8.4 1.7 1 2.3.7.8 1.6.8 2 .9 1.4.1 8.9.3 8.9.3s5.6 0 8.3-.3c.4 0 1.2-.1 1.9-.9.6-.6.9-1.5 1-2.3C24 10 24 8.2 24 8.2ZM9.6 12.8V7.6l5.3 2.6-5.3 2.6Z"/></svg></a>
                                            </div>
                                        </div>
                                    </aside>

                                    <!-- RIGHT: Form -->
                                    <div class="contact-card">
                                        <h2 class="card-title">Để lại lời nhắn</h2>
                                        <p class="card-sub">Mọi thắc mắc cần hỗ trợ, hãy để lại lời nhắn. Chúng tôi sẽ sớm liên hệ với bạn.</p>

                                        <form class="contact-form" id="form-contact" ng-cloak>
                                            <div class="f-row">
                                                <label for="fullname" class="sr-only">Họ tên *</label>
                                                <input id="fullname" name="name" type="text" placeholder="Họ tên *" required>

                                                <div class="invalid-feedback d-block" ng-if="errors['name']"><% errors['name'][0] %></div>
                                            </div>

                                            <div class="f-row">
                                                <label for="phone" class="sr-only">Số điện thoại</label>
                                                <input id="phone" name="phone" type="tel" placeholder="Số điện thoại">
                                                <div class="invalid-feedback d-block" ng-if="errors['phone']"><% errors['phone'][0] %></div>

                                            </div>

                                            <div class="f-row f-row--full">
                                                <label for="email" class="sr-only">Email</label>
                                                <input id="email" name="email" type="email" placeholder="Email" >
                                                <div class="invalid-feedback d-block" ng-if="errors['email']"><% errors['email'][0] %></div>

                                            </div>

                                            <div class="f-row f-row--full">
                                                <label for="message" class="sr-only">Lời nhắn</label>
                                                <textarea id="message" name="message" rows="8" placeholder="Lời nhắn"></textarea>
                                                <div class="invalid-feedback d-block" ng-if="errors['message']"><% errors['message'][0] %></div>
                                            </div>

                                            <button class="btn-send" type="button"  ng-click="submitContact()">
                                                Gửi
                                                <span class="arrow">›</span>
                                            </button>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </section>

                        <style>
                            :root{
                                --brand:#3e7a2e;         /* xanh lá nhạt giống ảnh */
                                --text:#222;
                                --muted:#6b7280;
                                --border:#e5e7eb;
                                --bg:#fafafa;
                            }
                            *{box-sizing:border-box}
                            .sr-only{position:absolute;width:1px;height:1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap}
                            body{color:var(--text);font:16px/1.6 system-ui,-apple-system,Segoe UI,Roboto,Helvetica,Arial,"Apple Color Emoji","Segoe UI Emoji"}
                            .container{max-width:1180px;margin:0 auto;padding:0 16px}
                            .contact-section{padding:40px 0}
                            .contact-grid{
                                display:grid;
                                grid-template-columns:1fr;
                                gap:28px;
                            }
                            @media(min-width:992px){
                                .contact-grid{grid-template-columns:1fr 1fr}
                            }

                            .contact-card{
                                background:#fff;
                                border:1px solid var(--border);
                                border-radius:10px;
                                padding:22px;
                                box-shadow:0 1px 0 #00000005;
                            }
                            .card-title{
                                font-size:20px;
                                font-weight:700;
                                margin:0 0 14px;
                                position:relative;
                            }
                            .card-title::after{
                                content:"";
                                display:block;
                                width:80px;height:3px;
                                background:var(--brand);
                                margin-top:10px;
                            }
                            .card-sub{margin:6px 0 18px;color:var(--muted);font-size:14px}

                            .info-list{list-style:none;margin:6px 0 16px;padding:0}
                            .info-item{
                                display:grid;
                                grid-template-columns:28px 1fr;
                                gap:12px;
                                padding:14px 0;
                                border-bottom:1px dashed var(--border);
                            }
                            .info-item:last-child{border-bottom:none}
                            .icon{
                                display:flex;align-items:center;justify-content:center;
                                width:28px;height:28px;border-radius:50%;
                                background:#f3f7f3; color:var(--brand); flex-shrink:0;
                            }
                            .icon svg{width:18px;height:18px;fill:var(--brand)}
                            .info-body .label{font-weight:600;color:#333;margin-bottom:2px}
                            .info-body .value{color:#111}
                            .info-body .link{color:#111;text-decoration:none}
                            .info-body .link:hover{color:var(--brand);text-decoration:underline}

                            .social{margin-top:14px}
                            .social-label{font-weight:700;margin-bottom:8px}
                            .social-list{display:flex;gap:10px;flex-wrap:wrap}
                            .s-btn{
                                width:36px;height:36px;border-radius:8px;display:inline-flex;
                                align-items:center;justify-content:center;
                                background:var(--brand); box-shadow:0 2px 0 #00000008;
                            }
                            .s-btn svg{width:18px;height:18px;fill:#fff}
                            .s-btn:hover{filter:brightness(0.95)}

                            .contact-form{display:grid;grid-template-columns:1fr 1fr;gap:14px}
                            .f-row{width:100%}
                            .f-row--full{grid-column:1/-1}
                            .contact-form input,
                            .contact-form textarea{
                                width:100%; background:#f9faf9; border:1px solid #e3e7e3;
                                border-radius:8px; padding:12px 14px; outline:none; transition:all .2s;
                                font:inherit;
                            }
                            .contact-form input::placeholder,
                            .contact-form textarea::placeholder{color:#9aa29a}
                            .contact-form input:focus,
                            .contact-form textarea:focus{
                                border-color:var(--brand); background:#fff; box-shadow:0 0 0 3px #3e7a2e22;
                            }
                            .btn-send{
                                grid-column:1/-1;
                                align-self:start;
                                border:0; background:var(--brand); color:#fff;
                                padding:12px 22px; border-radius:10px; font-weight:700;
                                display:inline-flex; align-items:center; gap:8px; cursor:pointer;
                            }
                            .btn-send .arrow{font-size:20px;line-height:0;transform:translateY(-1px)}
                            .btn-send:hover{filter:brightness(0.95)}
                            .form-note{margin-top:10px;color:var(--brand);font-weight:600}
                            @media(max-width:768px){
                                .contact-form{grid-template-columns:1fr}
                            }
                        </style>

                        <script>
                            // Demo submit – bạn giữ lại hoặc thay bằng submit thật (AJAX/Laravel)
                            document.getElementById('contactForm').addEventListener('submit', function(e){
                                e.preventDefault();
                                const form = e.currentTarget;
                                if(!form.checkValidity()){
                                    // kích hoạt UI báo lỗi mặc định
                                    [...form.querySelectorAll('input[required],textarea[required]')].forEach(el => el.reportValidity());
                                    return;
                                }
                                // TODO: gọi API của bạn tại đây
                                const note = document.getElementById('formNote');
                                note.hidden = false;
                                form.reset();
                            });
                        </script>

                    </div>

                </div>

                <div class="pageBottom">
                    <div class="row align-items-center">
                    </div>
                    <div class="col-md-6 col-sm-12">
                        <div class="content">
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </section>
    </main>

@endsection

@push('scripts')
    <script>
        app.controller('AboutPage', function ($rootScope, $scope, $sce, $interval) {
            $scope.errors = [];
            $scope.submitContact = function () {
                var url = "{{route('front.submitContact')}}";
                var data = jQuery('#form-contact').serialize();
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
                            jQuery('#form-contact')[0].reset();
                            $scope.errors = [];
                            $scope.$apply();
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
        })

    </script>
@endpush
