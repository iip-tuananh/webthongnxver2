<header class="navbar" ng-controller="headerPartial">
    <div class="container">
        <a class="navbar-toggle" href="#">
            <span></span>
            <span></span>
            <span></span>
            <span></span>
        </a>
        <h1>
            <a class="navbar-brand" href="{{ route('front.home-page') }}"> <img src="{{ $config->image->path ?? '' }}"></a>
            <span class="sr-only">{{ $config->web_title }}</span>
        </h1>
    </div>

    <style>
        /* Thẻ user info trên cùng dropdown */
        .user-card{ display:flex; align-items:center; gap:10px; padding:8px; border-radius:10px;}
        .avatar{ border-radius:50%; object-fit:cover; }
        .avatar--large{ width:44px; height:44px; }
        .avatar--initials{
            display:inline-grid; place-items:center; color:#fff; font-weight:700;
            background:linear-gradient(180deg, var(--brand-orange), #ff6a2f);
        }
        .user-card .hello{ font-weight:700; color:var(--ink-700); line-height:1.3; }
        .user-card .email{ font-size:12px; opacity:.7; }
    </style>
    <div class="navbar__top">
        <div class="container">

            <div class="navbar__top__inner">

                <ul class="navbar-nav justify-content-end" id="navbar-1065">
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ route('front.home-page') }}" title="">
                            <span>Trang chủ</span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ route('front.abouts') }}" title="">
                            <span>Giới thiệu</span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ route('front.services') }}" title="">
                            <span>Dịch vụ</span>
                        </a>
                    </li>
                    <li class="nav-item ">
                        <a class="nav-link" href="{{ route('front.contact') }}" title="">
                            <span>Liên hệ</span>
                        </a>
                    </li>




                    @if($customer)
                        @php
                            $full = trim($customer->fullname ?? '');
                            $parts = preg_split('/\s+/', $full, -1, PREG_SPLIT_NO_EMPTY);
                            $initials = count($parts) >= 2
                                ? mb_substr($parts[0],0,1).mb_substr($parts[count($parts)-1],0,1)
                                : (count($parts) === 1 ? mb_substr($parts[0],0,1) : 'U');
                            $displayName = \Illuminate\Support\Str::limit($customer->fullname, 24);
                        @endphp

                        <li class="nav-item sticky-menu">
                            <div class="user-card">
                                <a class="nav-link" target="_blank"
                                   href="{{ route('front.getProfile') }}#info" title="Hi {{ $displayName }}">
                                    @if(!empty($customer->avatar->path))
                                        <img class="avatar avatar--large" src="{{ $customer->avatar->path }}" alt="{{ $customer->fullname }}">
                                    @else
                                        <img class="avatar avatar--large" src="/site/img/user.png" alt="{{ $customer->fullname }}">
                                    @endif
                                    <span>
                                   Hi {{ $displayName }}
                                </span>
                                </a>
                            </div>

                        </li>
                    @else
                        <li class="nav-item sticky-menu"><a class="nav-link" target="_blank"
                                                            href="{{ route('front.login') }}" title="Đăng nhập"><i><img
                                        src="data:image/svg+xml;utf8,<svg%20xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg'%20viewBox%3D'0%200%20153.37%20166'><defs><style>.cls-1%7Bfill%3A%23fff%3Bstroke%3A%23fff%3Bstroke-miterlimit%3A10%3Bstroke-width%3A3px%7D<%2Fstyle><%2Fdefs><title>ic-dang-nhap<%2Ftitle><g%20id%3D'Layer_2'%20data-name%3D'Layer%202'><g%20id%3D'Layer_1-2'%20data-name%3D'Layer%201'><path%20class%3D'cls-1'%20d%3D'M111.63%2082.16a3.9%203.9%200%200%200-1.19-2.8l-.07-.08-27.59-27.59a3.91%203.91%200%200%200-5.53%200%203.48%203.48%200%200%200%200%205.15l21%2020.66H5.41a4%204%200%200%200%200%208h92.65l-20.81%2021.09a4.08%204.08%200%200%200%200%205.66%204%204%200%200%200%202.75%201.22%203.86%203.86%200%200%200%202.76-1.11l26.8-26.78a3.88%203.88%200%200%200%202.07-3.42z'%2F><path%20class%3D'cls-1'%20d%3D'M43.87%20102a4%204%200%200%201%204%203.9v50.6h96V9.5h-96v48.1a4%204%200%200%201-8%200V6.26c0-2.16.78-4.76%202.93-4.76h104.88c2.16%200%204.19%202.6%204.19%204.76V160c0%202.16-2%204.49-4.19%204.49H42.8c-2.15%200-2.93-2.33-2.93-4.49v-54.06a4%204%200%200%201%204-3.94z'%2F><%2Fg><%2Fg><%2Fsvg>"
                                        alt="Đăng nhập"></i><span>Đăng nhập</span></a>
                        </li>

                        <li class="nav-item sticky-menu"><a class="nav-link"
                                                            href="{{ route('front.register') }}"
                                                            title="Mở tài khoản"><i><img
                                        src="data:image/svg+xml;utf8,<svg%20xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg'%20viewBox%3D'0%200%20115%20115'><defs><style>.cls-1%7Bfill%3A%23fff%7D<%2Fstyle><%2Fdefs><title>ic-dang-ky<%2Ftitle><g%20id%3D'Layer_2'%20data-name%3D'Layer%202'><path%20class%3D'cls-1'%20d%3D'M108.81%206.19A21.11%2021.11%200%200%200%2079%206.18L15.43%2069.33a3.59%203.59%200%200%200-.84%201.32L.22%20110.18A3.59%203.59%200%200%200%203.6%20115a3.48%203.48%200%200%200%201.05-.16l35.75-11a3.35%203.35%200%200%200%201.49-.89l66.92-66.92a21.11%2021.11%200%200%200%200-29.87zM36.27%2097.63l-13.38%204.11a15.48%2015.48%200%200%200-3.65-6%2019.65%2019.65%200%200%200-4.88-3.45l6.13-16.84h8.26v7.19a3.6%203.6%200%200%200%203.6%203.59h6.34zm52.9-52.09L45.39%2089.32l1.25-5.92a3.6%203.6%200%200%200-3.51-4.34h-7.19v-7.18a3.6%203.6%200%200%200-3.59-3.6h-5.67l42.74-42.49a13.94%2013.94%200%201%201%2019.75%2019.75zM103.73%2031l-3.35%203.36a21%2021%200%200%200-19.73-19.74L84%2011.28A13.93%2013.93%200%201%201%20103.73%2031zm-23.61-1.2L44.18%2065.74a3.59%203.59%200%201%200%205.08%205.08L85.2%2034.88a3.59%203.59%200%200%200-5.08-5.08z'%20id%3D'Layer_1-2'%20data-name%3D'Layer%201'%2F><%2Fg><%2Fsvg>"
                                        alt="Mở tài khoản"></i><span>Mở tài khoản</span></a>
                        </li>

                    @endif

                </ul>

            </div>

            <style>
                /* ===== Cart icon + badge ===== */
                .navbar__cart{ position:relative; }
                .cart-toggle{
                    position:relative; display:inline-flex; align-items:center; justify-content:center;
                    width:42px; height:42px; border:0; background:#f5f6f8; border-radius:8px; cursor:pointer;
                }
                .cart-toggle .fa-cart-shopping{ font-size:18px; color:#111; }
                .cart-badge{
                    position:absolute; top:-6px; right:-6px; min-width:20px; height:20px; padding:0 6px;
                    border-radius:999px; background:#e30613; color:#fff; font-size:12px; font-weight:800;
                    display:inline-flex; align-items:center; justify-content:center; line-height:1;
                }

                /* ===== Dropdown ===== */
                .cart-dropdown{
                    position:absolute; right:0; top:calc(100% + 2px);
                    width:min(360px, 92vw); background:#fff; border:1px solid #eee; border-radius:10px;
                    box-shadow:0 18px 40px rgba(0,0,0,.12);
                    opacity:0; visibility:hidden; transform:translateY(8px); transition:.18s ease;
                    overflow:hidden; z-index:1000;
                }
                .navbar__cart:hover .cart-dropdown{ opacity:1; visibility:visible; transform:none; }

                /* Header */
                .cart-head{
                    display:flex; justify-content:space-between; align-items:center;
                    padding:14px 16px; font-weight:700;
                }
                .cart-qty{ color:#6b7280; font-weight:600; }

                /* List */
                .cart-list{ max-height:280px; overflow:auto; margin:0; padding:0 16px; list-style:none; }
                .cart-item{
                    display:grid; grid-template-columns:64px 1fr auto; gap:12px; align-items:center;
                    padding:12px 0; border-bottom:1px solid #f1f1f1;
                }
                .cart-item:last-child{ border-bottom:0; }
                .cart-item .thumb{ display:block; width:64px; height:64px; border-radius:6px; overflow:hidden; }
                .cart-item .thumb img{ width:100%; height:100%; object-fit:cover; display:block; }
                .cart-item .info{ min-width:0; }
                .cart-item .title{
                    display:block; font-weight:700; color:#111; text-decoration:none;
                    white-space:nowrap; overflow:hidden; text-overflow:ellipsis; margin-bottom:4px;
                }
                .cart-item .title:hover{ text-decoration:underline; }
                .cart-item .meta{ color:#6b7280; font-size:13px; font-weight:600; }
                .cart-item .meta .dot{ margin:0 6px; }
                .cart-item .rm{
                    border:0; background:#f3f4f6; color:#111; width:28px; height:28px; border-radius:6px; cursor:pointer;
                }
                .cart-item .rm:hover{ background:#e5e7eb; }

                /* Footer */
                .cart-foot{ padding:12px 16px 16px; background:linear-gradient(180deg,#fff,#fafafa); border-top:1px solid #f1f1f1; }
                .cart-total{ display:flex; justify-content:space-between; align-items:center; margin-bottom:12px; }
                .cart-total span{ color:#6b7280; font-weight:600; }
                .cart-total strong{ font-size:16px; }
                .cart-actions{ display:flex; align-items:center; gap:12px; }
                .cart-actions .btn{
                    display:inline-flex; align-items:center; justify-content:center; padding:10px 16px; border-radius:8px;
                    font-weight:800; text-decoration:none; border:1px solid transparent;
                }
                .btn-ghost{ background:#111; color:#fff; }
                .btn-ghost:hover{ filter:brightness(1.05); }
                .btn-primary{ background:#e30613; color:#fff; }
                .btn-primary:hover{ filter:brightness(1.05); }
                .cart-actions .divider{ width:1px; height:20px; background:#e5e7eb; display:inline-block; }

                /* Ẩn dropdown trên mobile cho tới khi click (JS sẽ thêm .is-open) */
                @media (hover:none){
                    .navbar__cart:hover .cart-dropdown{ opacity:0; visibility:hidden; transform:translateY(8px); }
                    .navbar__cart.is-open .cart-dropdown{ opacity:1; visibility:visible; transform:none; }
                }

                /* Tinh chỉnh nhỏ */
                @media (max-width:480px){
                    .cart-item{ grid-template-columns:56px 1fr auto; gap:10px; }
                    .cart-item .thumb{ width:56px; height:56px; }
                }

            </style>

            <div class="navbar__language">
                <div class="navbar__cart">
                    <button class="cart-toggle" aria-haspopup="true" aria-expanded="false">
                        <i class="fa-solid fa-cart-shopping" aria-hidden="true"></i>
                        <span class="cart-badge" id="cartCount" ng-cloak><% cart.count %></span> <!-- đổi số theo dữ liệu -->
                    </button>

                    <div class="cart-dropdown" role="menu" ng-cloak>
                        <div class="cart-head">
                            <strong>Giỏ hàng</strong>
                            <span class="cart-qty"><span id="cartQty"><% cart.count %></span> sản phẩm</span>
                        </div>

                        <ul class="cart-list">
                            <!-- DEMO items — thay bằng loop của bạn -->
                            <li class="cart-item" ng-repeat="item in cart.items" ng-cloak>
                                <a class="thumb" href="#"><img src="<% item.attributes.image %>" alt=""></a>
                                <div class="info">
                                    <a class="title" href="#"><% item.name %></a>
                                    <div class="meta"><span class="qty">x1</span> <span class="dot">•</span> <span class="price"><% (item.price) | number %>₫</span></div>
                                </div>
                                <button class="rm" aria-label="Xóa" ng-click="removeItem(item.id)">×</button>
                            </li>

                        </ul>

                        <div class="cart-foot">
                            <div class="cart-total"><span>Tổng:</span><strong id="cartTotal"><% cart.total | number%>₫</strong></div>
                            <div class="cart-actions">
                                <a class="btn btn-ghost" href="{{ route('cart.index') }}">XEM GIỎ HÀNG</a>
                                <span class="divider" aria-hidden="true"></span>
                                <a class="btn btn-primary" href="{{ route('cart.checkout') }}">THANH TOÁN</a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <style>
        /* --- Cơ bản --- */
        .site-nav {
            position: relative;
        }

        .navbar-nav {
            display: flex;
            gap: 24px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-item {
            position: relative;
        }

        .nav-link, .sub-link {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 12px 14px;
            text-decoration: none;
        }

        .nav-link {
            font-weight: 600;
        }

        .caret {
            display: inline-block;
            width: 0;
            height: 0;
            margin-left: 6px;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 6px solid currentColor;
        }

        .caret-right {
            border-top: none;
            border-left: 6px solid currentColor;
            border-right: none;
            border-bottom: 6px solid transparent;
        }

        /* --- Dropdown cấp 2/3 --- */
        .subnav {
            position: absolute;
            left: 0;
            top: 100%;
            min-width: 240px;
            list-style: none;
            margin: 0;
            padding: 8px 0;
            background: #fff;
            border: 1px solid rgba(0, 0, 0, .08);
            border-radius: 8px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .12);
            opacity: 0;
            visibility: hidden;
            transform: translateY(8px);
            transition: .2s ease;
            z-index: 1000;
        }

        .subnav .sub-item {
            position: relative;
        }

        .subnav .sub-link {
            padding: 10px 14px;
            /*white-space: nowrap;*/
        }

        .subnav .sub-link:hover {
            background: #f5f7fb;
        }

        /* Hiện cấp 2 khi hover mục gốc (desktop) */
        .nav-item:hover > .level-2 {
            opacity: 1;
            visibility: visible;
            transform: none;
        }

        /* Cấp 3: mặc định bay ngang sang phải */
        .level-3 {
            top: 0;
            left: 100%;
            margin-left: 8px;
        }

        .sub-item:hover > .level-3 {
            opacity: 1;
            visibility: visible;
            transform: none;
        }

        /* Chống bị che: đảm bảo lớp cha cho phép tràn */
        .site-nav, .nav-item, .sub-item {
            overflow: visible;
        }

        /* Tùy chọn: nếu menu sát mép phải, thêm class .open-left cho cấp 3 để mở sang trái */
        .level-3.open-left {
            left: auto;
            right: 100%;
            margin-left: 0;
            margin-right: 8px;
        }

        /* --- Mobile/Tablet --- */
        @media (max-width: 991.98px) {
            .navbar-nav {
                display: block;
            }

            .nav-item {
                border-bottom: 1px solid rgba(0, 0, 0, .06);
            }

            /* Biến dropdown thành accordion: đặt static + ẩn theo max-height */
            .subnav {
                position: static;
                border: none;
                box-shadow: none;
                border-radius: 0;
                padding: 0;
                opacity: 1;
                visibility: visible;
                transform: none;
                max-height: 0;
                overflow: hidden;
                transition: max-height .25s ease;
            }

            .nav-item.is-open > .level-2 {
                max-height: 1000px;
            }

            /* mở cấp 2 */
            .sub-item.is-open > .level-3 {
                max-height: 800px;
            }

            /* mở cấp 3 */
            /* Hiện mũi tên xuống/phải dễ bấm */
            .nav-link, .sub-link {
                justify-content: space-between;
            }
        }

    </style>


    <div class="navbar__bottom">
        <div class="container">

            <div class="navbar__bottom__inner">
                <a class="navbar-brand-mobile" href="index.html">
                    <img src="{{ $config->image->path ?? '' }}">
                </a>

                <ul class="navbar-nav justify-content-end" id="navbar-379">


                    <li class="nav-item sticky-menu">
                        <a class="nav-link" href="{{ route('front.home-page') }}" title="">
                            <span>Trang chủ</span>
                        </a>
                    </li>
                    <li class="nav-item sticky-menu">
                        <a class="nav-link" href="{{ route('front.abouts') }}" title="">
                            <span>Giới thiệu</span>
                        </a>
                    </li>
                    <li class="nav-item sticky-menu">
                        <a class="nav-link" href="{{ route('front.services') }}" title="">
                            <span>Dịch vụ</span>
                        </a>
                    </li>
                    <li class="nav-item sticky-menu">
                        <a class="nav-link" href="{{ route('front.contact') }}" title="">
                            <span>Liên hệ</span>
                        </a>
                    </li>


                    @foreach($postsCategory as $postCategory)
                        <li class="nav-item has-sub unsticky-menu" role="none">
                            <a class="nav-link" href="{{ route('front.blogs', $postCategory->slug) }}" title="{{ $postCategory->name }}" role="menuitem"
                               aria-haspopup="true" aria-expanded="false">
                                <span>{{ $postCategory->name }}</span>
                                <b class="caret"></b>
                            </a>

                            <!-- CẤP 2 -->
                            @if($postCategory->childs->count())
                                <ul class="subnav level-2" role="menu" aria-label="Cấp 2 – Đào tạo">
                                    @foreach($postCategory->childs as $child)
                                        @if($child->childs->count())
                                            <li class="sub-item has-sub" role="none">
                                                <a class="sub-link" href="{{ route('front.blogs', $child->slug) }}"
                                                   title="{{ $child->name }}" role="menuitem"
                                                   aria-haspopup="true" aria-expanded="false">
                                                    {{ $child->name }}
                                                    <b class="caret caret-right"></b>
                                                </a>

                                                <!-- CẤP 3 -->
                                                <ul class="subnav level-3" role="menu" aria-label="">
                                                    @foreach($child->childs as $sub)
                                                        <li role="none"><a role="menuitem" class="sub-link" href="{{ route('front.blogs', $sub->slug) }}">{{ $sub->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                        @else
                                            <li class="sub-item" role="none">
                                                <a class="sub-link" href="{{ route('front.blogs', $child->slug) }}"
                                                   title="{{ $child->name }}" role="menuitem">{{ $child->name }}</a>
                                            </li>

                                        @endif
                                    @endforeach



                                </ul>

                            @endif
                        </li>

                    @endforeach

{{--                    <li class="nav-item unsticky-menu"><a class="nav-link" title="Tin tức"><i><img--}}
{{--                                    src="data:image/svg+xml;utf8,<svg%20xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg'%20viewBox%3D'0%200%20132.53%20162'><defs><style>.cls-1%7Bfill%3A%23fff%7D<%2Fstyle><%2Fdefs><title>ic-tin-tuc<%2Ftitle><g%20id%3D'Layer_2'%20data-name%3D'Layer%202'><g%20id%3D'Layer_1-2'%20data-name%3D'Layer%201'><path%20class%3D'cls-1'%20d%3D'M132.51%2035.91a3.72%203.72%200%200%200-.86-3l-31.53-31.7h.06c-.12-.12-.22-.23-.35-.34s0-.05-.08-.07a3.87%203.87%200%200%200-.43-.27%203.43%203.43%200%200%200-.44-.19h-.09l-.5-.14a3.55%203.55%200%200%200-.47-.06H5C2.82%200%200%201.82%200%204v154.1c0%202.15%202.82%203.9%205%203.9h124.15c2.16%200%202.85-1.75%202.85-3.9V36.22c0-.1.52-.22.51-.31zM101%2013.41L119.72%2032H101zM9%20153V8h84v27.63c0%202.16%202.33%203.37%204.49%203.37H124v114z'%2F><path%20class%3D'cls-1'%20d%3D'M31%2046h28.51c2.16%200%203.91-1.34%203.91-3.5S61.67%2039%2059.51%2039H31c-2.16%200-3.91%201.34-3.91%203.5S28.83%2046%2031%2046zm72.66%2018H31a4%204%200%200%200%200%208h72.67a4%204%200%200%200%200-8zm0%2025H31c-2.16%200-3.91%202.34-3.91%204.5S28.83%2098%2031%2098h72.67c2.16%200%203.9-2.34%203.9-4.5s-1.75-4.5-3.91-4.5zm0%2025H31a4%204%200%200%200-3.91%204c0%202.16%201.75%204%203.91%205h72.67c2.16-1%203.9-2.84%203.9-5a4%204%200%200%200-3.91-4z'%2F><%2Fg><%2Fg><%2Fsvg>"--}}
{{--                                    alt="Tin tức"></i><span>Đào tạo</span></a>--}}
{{--                        <ul id="navbar-175">--}}


{{--                            <li><a href="tin-tuc/tin-tuc-su-kien-ssi.html" title="Tin tức - Sự kiện SSI"--}}
{{--                                   item="nav-link">Tin tức - Sự kiện SSI</a></li>--}}


{{--                            <li><a href="quan-he-nha-dau-tu/cong-bo-thong-tin.html" title="Công Bố Thông Tin"--}}
{{--                                   item="nav-link">Công Bố Thông Tin</a></li>--}}

{{--                        </ul>--}}
{{--                    </li>--}}
{{--                    <li class="nav-item unsticky-menu"><a class="nav-link" title="Tin tức"><i><img--}}
{{--                                    src="data:image/svg+xml;utf8,<svg%20xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg'%20viewBox%3D'0%200%20132.53%20162'><defs><style>.cls-1%7Bfill%3A%23fff%7D<%2Fstyle><%2Fdefs><title>ic-tin-tuc<%2Ftitle><g%20id%3D'Layer_2'%20data-name%3D'Layer%202'><g%20id%3D'Layer_1-2'%20data-name%3D'Layer%201'><path%20class%3D'cls-1'%20d%3D'M132.51%2035.91a3.72%203.72%200%200%200-.86-3l-31.53-31.7h.06c-.12-.12-.22-.23-.35-.34s0-.05-.08-.07a3.87%203.87%200%200%200-.43-.27%203.43%203.43%200%200%200-.44-.19h-.09l-.5-.14a3.55%203.55%200%200%200-.47-.06H5C2.82%200%200%201.82%200%204v154.1c0%202.15%202.82%203.9%205%203.9h124.15c2.16%200%202.85-1.75%202.85-3.9V36.22c0-.1.52-.22.51-.31zM101%2013.41L119.72%2032H101zM9%20153V8h84v27.63c0%202.16%202.33%203.37%204.49%203.37H124v114z'%2F><path%20class%3D'cls-1'%20d%3D'M31%2046h28.51c2.16%200%203.91-1.34%203.91-3.5S61.67%2039%2059.51%2039H31c-2.16%200-3.91%201.34-3.91%203.5S28.83%2046%2031%2046zm72.66%2018H31a4%204%200%200%200%200%208h72.67a4%204%200%200%200%200-8zm0%2025H31c-2.16%200-3.91%202.34-3.91%204.5S28.83%2098%2031%2098h72.67c2.16%200%203.9-2.34%203.9-4.5s-1.75-4.5-3.91-4.5zm0%2025H31a4%204%200%200%200-3.91%204c0%202.16%201.75%204%203.91%205h72.67c2.16-1%203.9-2.84%203.9-5a4%204%200%200%200-3.91-4z'%2F><%2Fg><%2Fg><%2Fsvg>"--}}
{{--                                    alt="Tin tức"></i><span>Đào tạo</span></a>--}}
{{--                        <ul id="navbar-175">--}}


{{--                            <li><a href="tin-tuc/tin-tuc-su-kien-ssi.html" title="Tin tức - Sự kiện SSI"--}}
{{--                                   item="nav-link">Tin tức - Sự kiện SSI</a></li>--}}


{{--                            <li><a href="quan-he-nha-dau-tu/cong-bo-thong-tin.html" title="Công Bố Thông Tin"--}}
{{--                                   item="nav-link">Công Bố Thông Tin</a></li>--}}

{{--                        </ul>--}}
{{--                    </li>--}}

                    @if($customer)
                        @php
                            $full = trim($customer->fullname ?? '');
                            $parts = preg_split('/\s+/', $full, -1, PREG_SPLIT_NO_EMPTY);
                            $initials = count($parts) >= 2
                                ? mb_substr($parts[0],0,1).mb_substr($parts[count($parts)-1],0,1)
                                : (count($parts) === 1 ? mb_substr($parts[0],0,1) : 'U');
                            $displayName = \Illuminate\Support\Str::limit($customer->fullname, 24);
                        @endphp

                        <li class="nav-item sticky-menu">
                            <div class="user-card">
                                <a class="nav-link" target="_blank"
                                   href="{{ route('front.getProfile') }}#info" title="Hi, {{ $displayName }}">
                                    @if(!empty($customer->avatar->path))
                                        <img class="avatar avatar--large" src="{{ $customer->avatar->path }}" alt="{{ $customer->fullname }}">
                                    @else
                                        <img class="avatar avatar--large" src="/site/img/user.png" alt="{{ $customer->fullname }}">
                                    @endif
                                    <span>
                                   Hi, {{ $displayName }}
                                </span>
                                </a>
                            </div>

                        </li>
                    @else
                        <li class="nav-item sticky-menu"><a class="nav-link" target="_blank"
                                                            href="{{ route('front.login') }}" title="Đăng nhập"><i><img
                                        src="data:image/svg+xml;utf8,<svg%20xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg'%20viewBox%3D'0%200%20153.37%20166'><defs><style>.cls-1%7Bfill%3A%23fff%3Bstroke%3A%23fff%3Bstroke-miterlimit%3A10%3Bstroke-width%3A3px%7D<%2Fstyle><%2Fdefs><title>ic-dang-nhap<%2Ftitle><g%20id%3D'Layer_2'%20data-name%3D'Layer%202'><g%20id%3D'Layer_1-2'%20data-name%3D'Layer%201'><path%20class%3D'cls-1'%20d%3D'M111.63%2082.16a3.9%203.9%200%200%200-1.19-2.8l-.07-.08-27.59-27.59a3.91%203.91%200%200%200-5.53%200%203.48%203.48%200%200%200%200%205.15l21%2020.66H5.41a4%204%200%200%200%200%208h92.65l-20.81%2021.09a4.08%204.08%200%200%200%200%205.66%204%204%200%200%200%202.75%201.22%203.86%203.86%200%200%200%202.76-1.11l26.8-26.78a3.88%203.88%200%200%200%202.07-3.42z'%2F><path%20class%3D'cls-1'%20d%3D'M43.87%20102a4%204%200%200%201%204%203.9v50.6h96V9.5h-96v48.1a4%204%200%200%201-8%200V6.26c0-2.16.78-4.76%202.93-4.76h104.88c2.16%200%204.19%202.6%204.19%204.76V160c0%202.16-2%204.49-4.19%204.49H42.8c-2.15%200-2.93-2.33-2.93-4.49v-54.06a4%204%200%200%201%204-3.94z'%2F><%2Fg><%2Fg><%2Fsvg>"
                                        alt="Đăng nhập"></i><span>Đăng nhập</span></a>
                        </li>

                        <li class="nav-item sticky-menu"><a class="nav-link"
                                                            href="{{ route('front.register') }}"
                                                            title="Mở tài khoản"><i><img
                                        src="data:image/svg+xml;utf8,<svg%20xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg'%20viewBox%3D'0%200%20115%20115'><defs><style>.cls-1%7Bfill%3A%23fff%7D<%2Fstyle><%2Fdefs><title>ic-dang-ky<%2Ftitle><g%20id%3D'Layer_2'%20data-name%3D'Layer%202'><path%20class%3D'cls-1'%20d%3D'M108.81%206.19A21.11%2021.11%200%200%200%2079%206.18L15.43%2069.33a3.59%203.59%200%200%200-.84%201.32L.22%20110.18A3.59%203.59%200%200%200%203.6%20115a3.48%203.48%200%200%200%201.05-.16l35.75-11a3.35%203.35%200%200%200%201.49-.89l66.92-66.92a21.11%2021.11%200%200%200%200-29.87zM36.27%2097.63l-13.38%204.11a15.48%2015.48%200%200%200-3.65-6%2019.65%2019.65%200%200%200-4.88-3.45l6.13-16.84h8.26v7.19a3.6%203.6%200%200%200%203.6%203.59h6.34zm52.9-52.09L45.39%2089.32l1.25-5.92a3.6%203.6%200%200%200-3.51-4.34h-7.19v-7.18a3.6%203.6%200%200%200-3.59-3.6h-5.67l42.74-42.49a13.94%2013.94%200%201%201%2019.75%2019.75zM103.73%2031l-3.35%203.36a21%2021%200%200%200-19.73-19.74L84%2011.28A13.93%2013.93%200%201%201%20103.73%2031zm-23.61-1.2L44.18%2065.74a3.59%203.59%200%201%200%205.08%205.08L85.2%2034.88a3.59%203.59%200%200%200-5.08-5.08z'%20id%3D'Layer_1-2'%20data-name%3D'Layer%201'%2F><%2Fg><%2Fsvg>"
                                        alt="Mở tài khoản"></i><span>Mở tài khoản</span></a>
                        </li>

                    @endif


                </ul>


                <form class="navbar__search">
                    <div class="form-group">
                        <button class="btn btn__close" type="reset"><i class="icon_close_alt2"></i></button>
                        <input class="form-control" type="search" name="keyword"  ng-model="keywords"
                               placeholder="Nhập từ khóa cần tìm kiếm..." aria-label="Search">
                        <button class="btm btn__search" type="button" ng-click="search()"><i class="icon_search"></i></button>
                    </div>
                    <button class="btn btn__open" type="reset"><i class="icon_search"></i></button>
                </form>

            </div>


            <a class="navbar__hotline" href="tel:{{ $config->hotline }}">
                <i>
                    <img
                        src="data:image/svg+xml;utf8,<svg%20xmlns%3D'http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg'%20viewBox%3D'0%200%20482.6%20482.6'><path%20fill%3D'%23fff'%20d%3D'M98.339%20320.8c47.6%2056.9%20104.9%20101.7%20170.3%20133.4%2024.9%2011.8%2058.2%2025.8%2095.3%2028.2%202.3.1%204.5.2%206.8.2%2024.9%200%2044.9-8.6%2061.2-26.3.1-.1.3-.3.4-.5%205.8-7%2012.4-13.3%2019.3-20%204.7-4.5%209.5-9.2%2014.1-14%2021.3-22.2%2021.3-50.4-.2-71.9l-60.1-60.1c-10.2-10.6-22.4-16.2-35.2-16.2-12.8%200-25.1%205.6-35.6%2016.1l-35.8%2035.8c-3.3-1.9-6.7-3.6-9.9-5.2-4-2-7.7-3.9-11-6-32.6-20.7-62.2-47.7-90.5-82.4-14.3-18.1-23.9-33.3-30.6-48.8%209.4-8.5%2018.2-17.4%2026.7-26.1%203-3.1%206.1-6.2%209.2-9.3%2010.8-10.8%2016.6-23.3%2016.6-36s-5.7-25.2-16.6-36l-29.8-29.8c-3.5-3.5-6.8-6.9-10.2-10.4-6.6-6.8-13.5-13.8-20.3-20.1-10.3-10.1-22.4-15.4-35.2-15.4-12.7%200-24.9%205.3-35.6%2015.5l-37.4%2037.4c-13.6%2013.6-21.3%2030.1-22.9%2049.2-1.9%2023.9%202.5%2049.3%2013.9%2080%2017.5%2047.5%2043.9%2091.6%2083.1%20138.7zm-72.6-216.6c1.2-13.3%206.3-24.4%2015.9-34l37.2-37.2c5.8-5.6%2012.2-8.5%2018.4-8.5%206.1%200%2012.3%202.9%2018%208.7%206.7%206.2%2013%2012.7%2019.8%2019.6%203.4%203.5%206.9%207%2010.4%2010.6l29.8%2029.8c6.2%206.2%209.4%2012.5%209.4%2018.7s-3.2%2012.5-9.4%2018.7c-3.1%203.1-6.2%206.3-9.3%209.4-9.3%209.4-18%2018.3-27.6%2026.8l-.5.5c-8.3%208.3-7%2016.2-5%2022.2.1.3.2.5.3.8%207.7%2018.5%2018.4%2036.1%2035.1%2057.1%2030%2037%2061.6%2065.7%2096.4%2087.8%204.3%202.8%208.9%205%2013.2%207.2%204%202%207.7%203.9%2011%206%20.4.2.7.4%201.1.6%203.3%201.7%206.5%202.5%209.7%202.5%208%200%2013.2-5.1%2014.9-6.8l37.4-37.4c5.8-5.8%2012.1-8.9%2018.3-8.9%207.6%200%2013.8%204.7%2017.7%208.9l60.3%2060.2c12%2012%2011.9%2025-.3%2037.7-4.2%204.5-8.6%208.8-13.3%2013.3-7%206.8-14.3%2013.8-20.9%2021.7-11.5%2012.4-25.2%2018.2-42.9%2018.2-1.7%200-3.5-.1-5.2-.2-32.8-2.1-63.3-14.9-86.2-25.8-62.2-30.1-116.8-72.8-162.1-127-37.3-44.9-62.4-86.7-79-131.5-10.3-27.5-14.2-49.6-12.6-69.7z'%2F><%2Fsvg>"
                        alt="">
                </i>
                <span>{{ $config->hotline }}</span>
            </a>
            @if($customer)
                <a class="navbar__openAccount"
                   href="{{ route('front.getProfile') }}#info"
                   target="_blank"><span>Hi, {{ $displayName }}</span></a>
            @else
                <a class="navbar__openAccount"
                   href="{{ route('front.register') }}"
                   target="_blank"><i><img class="svg" src="/site/frontend/images/icons/ic-dang-ky-red.svg"
                                           alt="Mở tài khoản"></i><span>Mở tài khoản</span></a>
            @endif


        </div>
    </div>

</header>



