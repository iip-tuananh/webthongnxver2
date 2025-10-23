@extends('site.layouts.master')
@section('title'){{ $category->name ?? 'Bài viết' }} - {{ $config->web_title }}@endsection
@section('description'){{ strip_tags(html_entity_decode($config->introduction)) }}@endsection
@section('image'){{@$config->image->path ?? ''}}@endsection

@section('css')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
    /* Ảnh làm mốc đặt badge */
    .listPost__item__image{
        position: relative;
        display: block;
        width: 100%;
        aspect-ratio: 16/9;                 /* hoặc chiều cao cố định */
        background-size: cover;
        background-position: center;
        border-radius: 8px;
        overflow: hidden;
    }
    .listPost__item__image > img{
        width:100%; height:100%; object-fit:cover; opacity:0; /* giữ SEO, không đè nền */
    }

    /* Badge chung */
    .post-badge{
        position:absolute; top:10px; left:10px; z-index:2;
        display:inline-flex; align-items:center; gap:8px;
        padding:6px 10px; border-radius:999px; color:#fff; font-weight:800; font-size:14px;
        line-height:1; box-shadow:0 6px 18px rgba(0,0,0,.18);
        pointer-events:none; /* để click xuyên xuống link */
    }
    .post-badge .fa-solid{ font-size:14px; }
    .badge-free{ background:#16a34a; }   /* xanh lá */
    .badge-paid{ background:#ff6a00; }   /* cam/đỏ */

    @media (max-width:576px){
        .post-badge{ font-size:13px; padding:5px 9px; }
        .post-badge .fa-solid{ font-size:13px; }
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
            .tagCloud{ margin-top: 20px; margin-bottom: 20px}
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

                    @if($category)
                        @if($parentCateLv1)
                            <li class="breadcrumb-item">
                                <a href="{{ route('front.blogs', $parentCateLv1->slug) }}" title="{{ $parentCateLv1->name }}">{{ $parentCateLv1->name }}</a>
                            </li>
                            @if($parentCateLv2)
                                <li class="breadcrumb-item">
                                    <a href="{{ route('front.blogs', $parentCateLv2->slug) }}" title="{{ $parentCateLv2->name }}">{{ $parentCateLv2->name }}</a>
                                </li>
                            @endif
                            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                        @else
                            <li class="breadcrumb-item active" aria-current="page">{{ $category->name }}</li>
                        @endif
                    @else
                        <li class="breadcrumb-item active" aria-current="page">Bài viết mới nhất</li>
                    @endif
                </ol>
            </nav>
        </div>
    </section>

    <section class="pages">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3 sidebar">
                    <nav class="navSidebar">
                        <ul>
                            @foreach($categories as $cate)
                                <li><a href="{{ route('front.blogs', $cate->slug) }}">{{ $cate->name }}</a></li>
                            @endforeach
                        </ul>
                    </nav>

                    <section class="tagCloud" aria-labelledby="tagCloudTitle">
                        <h3 id="tagCloudTitle" class="tagCloud__title">Tags</h3>


                        <ul class="tagCloud__list">
                            @foreach($tags as $tag)
                                <li><a href="{{ route('front.getPostByTag', $tag->slug) }}">{{ $tag->name }}</a></li>
                            @endforeach
                        </ul>

                    </section>
                </div>
                <div class="col-12 col-md-8 col-lg-9">

                    <div class="listPost">
                        <div class="row">
                            @foreach($posts as $post)
                                <div class="col-lg-4 col-sm-6 col-12">
                                    <div class="listPost__item">
                                        <a class="img-bg  listPost__item__image"
                                           href="{{ route('front.blogDetail', $post->slug) }}"
                                           style="background-image: url({{ $post->image->path ?? '' }})"
                                           title="{{ $post->name }}">

                                            @if(($post->type ?? 1) == 1)
                                                <span class="post-badge badge-free">
                                                    <i class="fa-solid fa-newspaper" aria-hidden="true"></i>
                                                    <span class="txt">Miễn phí</span>
                                                </span>
                                            @else
                                                <span class="post-badge badge-paid">
                                  <i class="fa-solid fa-lock" aria-hidden="true"></i>
                                  <span class="txt">
                                       @if(! $post->access)
                                          {{ isset($post->price) && $post->price > 0
                                                             ? number_format($post->price, 0, ',', '.') . '₫'
                                                                 : 'Liên hệ' }}
                                      @else
                                          Đã sở hữu
                                      @endif
                                  </span>
                                </span>


                                            @endif




                                            <img src="{{ $post->image->path ?? '' }}" alt="maps">
                                        </a>
                                        <div class="listPost__item__body">
                                            <a href="{{ route('front.blogDetail', $post->slug) }}">
                                                {{ $post->name }}
                                            </a>
                                        </div>
                                    </div>
                                </div>

                            @endforeach

                        </div>
                    </div>

                    {{ $posts->links('site.pagination.paginate2') }}


                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')
    <script>
        $(document).on('change', '#list', function () {
            var url = $(this).find('option:selected').data('url') || '';
            if (url) window.location.href = url;
        });

    </script>
@endpush
