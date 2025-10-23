@extends('site.layouts.master')
@section('title'){{ $blog->name }} - {{ $config->web_title }}@endsection
@section('description'){{ strip_tags(html_entity_decode($config->introduction)) }}@endsection
@section('image'){{@$config->image->path ?? ''}}@endsection

@section('css')
    <link type="text/css" rel="stylesheet" href="/site/custom/editor-content.css">


    <style>
        /* Paywall styles */
        .single-post-content_text.is-locked{position:relative}
        .paywall-excerpt{
            max-height: clamp(220px, 40vh, 420px);
            overflow: hidden;
            /* tạo fade cuối đoạn preview */
            -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 70%, rgba(0,0,0,0));
            mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 70%, rgba(0,0,0,0));
        }
        .paywall-overlay{
            position:absolute; inset:auto 0 0 0; /* nằm dưới cùng */
            display:flex; justify-content:center;
            background: linear-gradient(to bottom, rgba(255,255,255,0), rgba(255,255,255,.96) 30%, rgba(255,255,255,1));
            padding: 26px 12px 14px;
        }
        .paywall-card{
            width: min(380px, 100%);
            border:1px solid #e8edf2; border-radius:12px; background:#fff;
            padding:14px; text-align:center; box-shadow:0 8px 24px rgba(0,0,0,.06);
        }
        .paywall-badge{
            display:inline-block; padding:5px 10px; border-radius:999px; font-size:.85rem;
            border:1px solid #e8edf2; margin-bottom:6px
        }
        .paywall-badge.is-paid{background:#fff5f0; color:#b23c17; border-color:#ffd9c9}
        .paywall-badge.is-free{background:#f1f8f5; color:#0b7a3b; border-color:#d5efe3}
        .paywall-price{margin:4px 0 8px; font-size:1.15rem}
        .paywall-price .old{margin-left:8px; color:#9aa3ae; text-decoration:line-through}
        .paywall-actions{display:flex; flex-wrap:wrap; gap:10px; justify-content:center; margin-top:8px}
        .pw-btn{display:inline-flex; align-items:center; justify-content:center; padding:10px 14px; border-radius:10px; border:1px solid transparent; text-decoration:none; cursor:pointer}
        .pw-btn-primary{background:#ff6a00; color:#fff !important;}
        .pw-btn-ghost{background:#fff; color:#111; border-color:#e8edf2}
        @media (max-width: 600px){
            .paywall-card{padding:12px}
        }



        /* đặt chiều cao vùng overlay (có thể chỉnh) */
        .single-post-content_text.is-locked{ position:relative; --pw-h:120px; }

        /* phần preview: chừa chỗ bằng padding-bottom = chiều cao overlay */
        .paywall-excerpt{
            max-height: clamp(220px, 40vh, 420px);
            overflow:hidden;
            -webkit-mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 70%, rgba(0,0,0,0));
            mask-image: linear-gradient(to bottom, rgba(0,0,0,1) 70%, rgba(0,0,0,0));
            padding-bottom: var(--pw-h);          /* <<< quan trọng */
        }

        /* overlay chỉ chiếm đúng phần đã chừa ở đáy */
        .paywall-overlay{
            position:absolute; left:0; right:0; bottom:0;
            height: var(--pw-h);                  /* <<< khớp với padding-bottom */
            display:flex; align-items:center; justify-content:center;
            background: linear-gradient(to bottom,
            rgba(255,255,255,0),
            rgba(255,255,255,.96) 45%, #fff 90%);
            padding: 10px 12px;
        }

        /* để click được nút bên trong nhưng không chặn phần preview phía trên */
        .paywall-overlay{ pointer-events:none; }
        .paywall-card{ pointer-events:auto; }

        @media (max-width:600px){
            .single-post-content_text.is-locked{ --pw-h:140px; }  /* nếu mobile cần cao hơn */
        }


    </style>

    <style>
        /* ===== Single post header (scoped) ===== */
        .single-post-header h1{
            display:flex;                 /* đặt title và badge cùng hàng */
            align-items:center;
            gap:10px;
            flex-wrap:wrap;               /* nếu tiêu đề dài sẽ tự xuống dòng đẹp */
            margin:10px 0 12px;
            line-height:1.25;
        }

        /* Pill Tin hot */
        .single-post-header .hot-badge{
            display:inline-flex;
            align-items:center;
            gap:6px;
            padding:6px 12px;
            border-radius:999px;
            background:linear-gradient(135deg,#ff7a59 0%,#ff3d3d 100%);
            color:#fff;
            font-weight:700;
            font-size:14px;               /* lớn hơn list để cân xứng H1 */
            line-height:1;
            box-shadow:
                0 6px 18px rgba(255,61,61,.28),
                inset 0 0 0 1px rgba(255,255,255,.26);
            white-space:nowrap;           /* luôn gọn như một “pill” */
            transform:translateY(0);
            transition:transform .18s ease, box-shadow .18s ease, filter .18s ease;
        }
        .single-post-header .hot-badge:hover{
            transform:translateY(-1px);
            box-shadow:
                0 10px 24px rgba(255,61,61,.34),
                inset 0 0 0 1px rgba(255,255,255,.3);
            filter:saturate(1.02);
        }
        .single-post-header .hot-badge__icon{ font-size:16px; line-height:1; }

        /* Nhảy lửa rất nhẹ; tôn trọng reduced motion */
        @keyframes flame-pop{0%,100%{transform:translateY(0)}50%{transform:translateY(-1px)}}
        @media (prefers-reduced-motion:no-preference){
            .single-post-header .hot-badge__icon{ animation:flame-pop 1.6s ease-in-out infinite; }
        }

        /* Giữ category marker gọn gàng phía trên */
        .single-post-header .post-category-marker{
            display:inline-block;
            margin-bottom:6px;
        }

        /* Mobile tinh chỉnh khoảng cách */
        @media (max-width:576px){
            .single-post-header h1{ gap:8px; }
            .single-post-header .hot-badge{ font-size:13px; padding:5px 10px; }
        }

    </style>

    <style>
        /* ====== TAG CLOUD (Sidebar) ====== */
        .tagCloud{
            --accent: #920d10;         /* màu gạch chân tiêu đề */
            --chip-bg: #111;           /* nền chip */
            --chip-bg-hover: #1a1a1a;  /* hover chip */
            --chip-border: #2a2a2a;    /* viền chip */
            --chip-text: #fff;         /* chữ chip */
            margin-top: 24px;
        }

        .tagCloud__title{
            font-size: 1.125rem;      /* 18px */
            font-weight: 700;
            margin: 0 0 14px;
            padding-top: 2px;
            position: relative;
            line-height: 1.2;
        }
        .tagCloud__title:after{
            content: "";
            display: block;
            width: 64px;
            height: 2px;
            background: var(--accent);
            margin-top: 10px;
        }

        /* danh sách tag linh hoạt, tự xuống dòng */
        .tagCloud__list{
            display: flex;
            flex-wrap: wrap;
            gap: 10px 12px;      /* hàng x cột */
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* chip tag */
        .tagCloud__list a{
            display: inline-flex;
            align-items: center;
            padding: 10px 14px;
            border-radius: 6px;
            background: var(--chip-bg);
            border: 1px solid var(--chip-border);
            color: var(--chip-text);
            text-decoration: none;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .2px;
            text-transform: uppercase;         /* giống mockup */
            line-height: 1;
            transition: transform .15s ease, background-color .15s ease, box-shadow .15s ease, border-color .15s ease;
            white-space: nowrap;               /* giữ dạng “chip” */
        }
        .tagCloud__list a:hover{
            background: var(--chip-bg-hover);
            border-color: #3a3a3a;
            transform: translateY(-1px);
            box-shadow: 0 2px 10px rgba(0,0,0,.12);
        }
        .tagCloud__list a:focus-visible{
            outline: 2px solid var(--accent);
            outline-offset: 2px;
        }

        /* khoảng cách trong sidebar nhỏ hơn ở mobile */
        @media (max-width: 575.98px){
            .tagCloud{ margin-top: 20px; }
            .tagCloud__list{ gap: 8px 10px; }
            .tagCloud__list a{ padding: 9px 12px; font-size: 11.5px; }
        }

        /* Nếu sidebar ở nền sáng, có thể dùng biến sau cho phù hợp: */
        /*
        .sidebar .tagCloud{
          --chip-bg: #202020;
          --chip-bg-hover: #262626;
          --chip-border: #2e2e2e;
          --chip-text: #fff;
          --accent: #6bc048;
        }
        */
    </style>
@endsection

@section('content')

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
                    <li class="breadcrumb-item">
                        <a href="{{ route('front.blogs', $blog->category->slug ?? '') }}" title="{{ $blog->category->name ?? '' }}">{{ $blog->category->name ?? '' }}</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $blog->name }}
                    </li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="pages" ng-controller="blogPage">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3 sidebar">

                    <div class="box-widget-content">
                        @include('site.partials.post-paycard', ['blog' => $blog])
                    </div>

                    <nav class="navSidebar">
                        <ul>
                            @foreach($categories as $cate)
                                <li><a href="{{ route('front.blogs', $cate->slug) }}">{{ $cate->name }}</a><span></span></li>
                            @endforeach
                        </ul>
                    </nav>

                    <section class="tagCloud" aria-labelledby="tagCloudTitle">
                        <h3 id="tagCloudTitle" class="tagCloud__title">Tags</h3>


                        <ul class="tagCloud__list">
                            @foreach($blog->tags as $tag)
                                <li><a href="{{ route('front.getPostByTag', $tag->slug) }}">{{ $tag->name }}</a></li>
                            @endforeach
                        </ul>

                    </section>

                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <div class="contentPost">
                        <div class="contentPost__title">
                            <a class="btnBack" href="javascript:history.back()">
                                <i class="ico-back"></i>
                                <span>Trở lại</span>
                            </a>
                            <div class="clone-h3">{{ $blog->name }}”
                            </div>
                        </div>
                        <div class="contentPost__time">
                            <p>
                                <i class="icon_table"> </i>
                                <span>{{ \Carbon\Carbon::parse($blog->created_at)->format('d/m/Y') }}</span>
                            </p>
                        </div>
                        <div class="contentPost__text">
                            <div style="margin-bottom: 10px"><img alt="" src="{{ $blog->image->path ?? '' }}"/></div>
                            @php
                                $canRead = (bool)($blog->canAccess ?? false);

                                // Preview an toàn khi khóa (chỉ text)
                                use Illuminate\Support\Str;
                                // 1) Lấy plain text
                                $raw = strip_tags($blog->body ?? '');

                                // 2) Decode entities nhiều lượt (xử lý case &amp;ecirc; -> &ecirc; -> ê)
                                $prev = null; $i = 0;
                                while ($raw !== $prev && $i < 3) {
                                    $prev = $raw;
                                    $raw  = html_entity_decode($raw, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                    $i++;
                                }

                                // 3) Chuẩn hoá khoảng trắng, thay NBSP
                                $raw = preg_replace('/\x{00A0}/u', ' ', $raw); // NBSP -> space
                                $raw = preg_replace('/\s+/u', ' ', $raw);

                                // 4) Cắt preview
                                $previewText = Str::words($raw, 120, '…');

                                // (tuỳ chọn) giá/label
                                $basePrice  = (int)($blog->price ?? 0);
                                $isPaid     = $blog->type == 1 ? false : true ;
                            @endphp
                            <div class="single-post-content">
                                <div class="single-post-content_text {{ $canRead ? '' : 'is-locked' }} editor-content" id="font_chage">
                                    @if($canRead)
                                        {!! $blog->body !!}
                                    @else
                                        {{-- Preview rút gọn --}}
                                        <div class="paywall-excerpt">
                                            <p>{!! nl2br(($previewText)) !!}</p>
                                        </div>

                                        {{-- Lớp mờ + thông điệp + CTA --}}
                                        <div class="paywall-overlay" style="top: 50px">
                                            <div class="paywall-card">
                                                <span class="paywall-badge is-paid">
                                                   Bài viết trả phí
                                                </span>

                                                <div class="paywall-price">
                                                    <strong>{{ number_format($basePrice) }}₫</strong>
                                                </div>
                                                <p>Vui lòng mua để đọc toàn bộ nội dung.</p>

                                                <div class="paywall-actions">
                                                    @if(! auth('customer')->check())
                                                        <a class="pw-btn pw-btn-primary"
                                                           href="{{ route('front.home-page') }}#login">
                                                            Đăng nhập
                                                        </a>
                                                    @else
                                                        @if($isPaid)
                                                            <form method="post" action="" class="d-inline">
                                                                @csrf
                                                                <input type="hidden" name="type" value="post">
                                                                <input type="hidden" name="post_id" value="{{ $blog->id }}">
                                                                <button type="button" class="pw-btn pw-btn-primary" ng-click="addToCart({{ $blog->id }})">Thêm vào giỏ</button>
                                                            </form>
                                                        @else
                                                            <a class="pw-btn pw-btn-primary" href="">
                                                                Đọc ngay
                                                            </a>
                                                        @endif
                                                    @endguest
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>

                        <div class="handle">
                            <div class="handle__item"><a class="share" href="#"><i></i><span>Chia sẻ</span></a>
                                <div class="handle__social">
                                    <ul>

                                        <li><a href="#" class="share-fb"
                                               data-link="ssi-khang-dinh-vi-the-tien-phong-cong-nghe-voi-giai-thuong-cong-nghe-xuat-sac-viet-nam-2025.html"><i
                                                    class="social_facebook_circle"></i></a></li>
                                        <li><a href="#" class="share-tw"
                                               data-title="SSI: KHẲNG ĐỊNH VỊ THẾ TIÊN PHONG CÔNG NGHỆ VỚI GIẢI THƯỞNG “CÔNG NGHỆ XUẤT SẮC VIỆT NAM 2025”"
                                               data-link="ssi-khang-dinh-vi-the-tien-phong-cong-nghe-voi-giai-thuong-cong-nghe-xuat-sac-viet-nam-2025.html"><i
                                                    class="social_twitter_circle"></i></a></li>
                                        <li><a href="#" class="share-linkedin"
                                               data-title="SSI: KHẲNG ĐỊNH VỊ THẾ TIÊN PHONG CÔNG NGHỆ VỚI GIẢI THƯỞNG “CÔNG NGHỆ XUẤT SẮC VIỆT NAM 2025”"
                                               data-link="ssi-khang-dinh-vi-the-tien-phong-cong-nghe-voi-giai-thuong-cong-nghe-xuat-sac-viet-nam-2025.html"><i
                                                    class="social_linkedin_circle"></i></a></li>
                                        <li><a href="#" class="share-gg"
                                               data-link="ssi-khang-dinh-vi-the-tien-phong-cong-nghe-voi-giai-thuong-cong-nghe-xuat-sac-viet-nam-2025.html"><i
                                                    class="social_googleplus_circle"></i></a></li>
                                        <li><a href="#" class="share-mail"
                                               data-title="SSI: KHẲNG ĐỊNH VỊ THẾ TIÊN PHONG CÔNG NGHỆ VỚI GIẢI THƯỞNG “CÔNG NGHỆ XUẤT SẮC VIỆT NAM 2025”"
                                               data-link="ssi-khang-dinh-vi-the-tien-phong-cong-nghe-voi-giai-thuong-cong-nghe-xuat-sac-viet-nam-2025.html"><i
                                                    class="ic-email"></i></a></li>
                                        <li><a href="#" class="print"><i class="ic-print"></i></a></li>

                                    </ul>
                                </div>
                            </div>


                        </div>
                    </div>
                    <div class="informationOther">
                        @foreach($othersBlog as $otherBlog)
                            <div class="informationOther__item row align-items-center">
                                <div class="informationOther__item__time col-lg-2 col-md-12">
                                    <p>
                                        <i class="icon_table"></i>
                                        <span>{{ \Illuminate\Support\Carbon::parse($otherBlog->created_at)->format('d/m/Y') }}</span>
                                    </p>
                                </div>
                                <div class="informationOther__item__title col-lg-8 col-md-12">
                                    <a href="{{ route('front.blogDetail', $otherBlog->slug ?? '') }}">
                                       {{ $otherBlog->name }}
                                    </a>
                                </div>
                                <div class="informationOther__item__readmore col-lg-2 col-md-12">
                                    <a  href="{{ route('front.blogDetail', $otherBlog->slug ?? '') }}">
                                        Xem thêm
                                    </a>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        app.controller('blogPage', function ($rootScope, $scope, cartItemSync, $interval) {
            $scope.cart = cartItemSync;

            $scope.addToCart = function (postId) {
                url = "{{route('cart.add.item', ['postId' => 'postId'])}}";
                url = url.replace('postId', postId);

                jQuery.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: {
                        'qty': 1
                    },
                    success: function (response) {
                        if (response.success) {
                            $interval.cancel($rootScope.promise);
                            $rootScope.promise = $interval(function () {
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);
                            toastr.success('Sản phẩm đã được thêm vào giỏ hàng');
                        } else {
                            toastr.warning(response.message);
                        }
                    },
                    error: function () {
                        toastr.toastr('Thao tác thất bại !');
                    },
                    complete: function () {
                        $scope.$applyAsync();
                    }
                });
            }




        })
    </script>
@endpush
