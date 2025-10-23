@extends('site.layouts.master')
@section('title')
    Dịch vụ - {{ $config->web_title }}
@endsection
@section('description')
    {{ strip_tags(html_entity_decode($config->introduction)) }}
@endsection
@section('image')
    {{@$config->image->path ?? ''}}
@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        /* Ảnh làm mốc đặt badge */
        .listPost__item__image {
            position: relative;
            display: block;
            width: 100%;
            aspect-ratio: 16/9; /* hoặc chiều cao cố định */
            background-size: cover;
            background-position: center;
            border-radius: 8px;
            overflow: hidden;
        }

        .listPost__item__image > img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0; /* giữ SEO, không đè nền */
        }

        /* Badge chung */
        .post-badge {
            position: absolute;
            top: 10px;
            left: 10px;
            z-index: 2;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 999px;
            color: #fff;
            font-weight: 800;
            font-size: 14px;
            line-height: 1;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .18);
            pointer-events: none; /* để click xuyên xuống link */
        }

        .post-badge .fa-solid {
            font-size: 14px;
        }

        .badge-free {
            background: #16a34a;
        }

        /* xanh lá */
        .badge-paid {
            background: #ff6a00;
        }

        /* cam/đỏ */

        @media (max-width: 576px) {
            .post-badge {
                font-size: 13px;
                padding: 5px 9px;
            }

            .post-badge .fa-solid {
                font-size: 13px;
            }
        }
    </style>

    <style>
        /* ====== TAG CLOUD (Sidebar) ====== */
        .tagCloud {
            --accent: #920d10; /* màu gạch chân tiêu đề */
            --chip-bg: #111; /* nền chip */
            --chip-bg-hover: #1a1a1a; /* hover chip */
            --chip-border: #2a2a2a; /* viền chip */
            --chip-text: #fff; /* chữ chip */
            margin-top: 24px;
        }

        .tagCloud__title {
            font-size: 1.125rem; /* 18px */
            font-weight: 700;
            margin: 0 0 14px;
            padding-top: 2px;
            position: relative;
            line-height: 1.2;
        }

        .tagCloud__title:after {
            content: "";
            display: block;
            width: 64px;
            height: 2px;
            background: var(--accent);
            margin-top: 10px;
        }

        /* danh sách tag linh hoạt, tự xuống dòng */
        .tagCloud__list {
            display: flex;
            flex-wrap: wrap;
            gap: 10px 12px; /* hàng x cột */
            list-style: none;
            padding: 0;
            margin: 0;
        }

        /* chip tag */
        .tagCloud__list a {
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
            text-transform: uppercase; /* giống mockup */
            line-height: 1;
            transition: transform .15s ease, background-color .15s ease, box-shadow .15s ease, border-color .15s ease;
            white-space: nowrap; /* giữ dạng “chip” */
        }

        .tagCloud__list a:hover {
            background: var(--chip-bg-hover);
            border-color: #3a3a3a;
            transform: translateY(-1px);
            box-shadow: 0 2px 10px rgba(0, 0, 0, .12);
        }

        .tagCloud__list a:focus-visible {
            outline: 2px solid var(--accent);
            outline-offset: 2px;
        }

        /* khoảng cách trong sidebar nhỏ hơn ở mobile */
        @media (max-width: 575.98px) {
            .tagCloud {
                margin-top: 20px;
            }

            .tagCloud__list {
                gap: 8px 10px;
            }

            .tagCloud__list a {
                padding: 9px 12px;
                font-size: 11.5px;
            }
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
    <main class="wrapper">

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
                        <li class="breadcrumb-item active" aria-current="page">Dịch vụ</li>
                    </ol>
                </nav>
            </div>
        </section>


        <section class="pages">
            <div class="container">
                <nav class="tabLinks">
                    <div class="tabLinks__dropdown">
                        Dịch vụ của chúng tôi
                    </div>
                    <ul>
                        <li class="active">
                            <a target="_self" href="{{ route('front.services') }}" title="Sản phẩm và dịch vụ">Dịch vụ của chúng tôi</a>
                        </li>
                    </ul>
                </nav>
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        <div class="listService listService--stock">
                            <h3 class="heading__list heading__list--stock"></h3>
                            <p></p>
                            <div class="row">
                                @foreach($services as $service)
                                    <div class="col-lg-6 col-md-6 col-12">
                                        <div class="listService__item">
                                            <div class="listService__item__image">
                                                <a class="img-bg image" href="{{ route('front.getServiceDetail', $service->slug) }}"
                                                   style="background-image: url({{ $service->image->path ?? '' }})"
                                                   title="maps">
                                                    <img src="{{ $service->image->path ?? '' }}" alt="maps">
                                                </a>
                                            </div>
                                            <div class="listService__item__desc">
                                                <div>
                                                    <h2 class="title">
                                                        <a href="{{ route('front.getServiceDetail', $service->slug) }}"> {{ $service->name }}</a>

                                                    </h2>
                                                    <div class="listService__item__desc__content">
                                                        {{ $service->description }}
                                                    </div>
                                                    <div class="nhan-cont"></div>
                                                </div>

                                                <a class="btn btn-gray btn-more" href="{{ route('front.getServiceDetail', $service->slug) }}" title="Chi tiết" tabindex="-1" data-readmore-toggle="" aria-controls="rmjs-1">Chi tiết</a>
                                            </div>
                                        </div>
                                    </div>

                                @endforeach

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
        $(document).on('change', '#list', function () {
            var url = $(this).find('option:selected').data('url') || '';
            if (url) window.location.href = url;
        });

    </script>


@endpush
