@extends('site.layouts.master')
@section('title')Giới thiệu - {{ $config->web_title }}@endsection
@section('description'){{ strip_tags(html_entity_decode($config->introduction)) }}@endsection
@section('image'){{@$config->image->path ?? ''}}@endsection

@section('css')
    <link type="text/css" rel="stylesheet" href="/site/css/editor-content.css">

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

                        <li class="breadcrumb-item active" aria-current="page">Về chúng tôi</li>
                    </ol>
                </nav>
            </div>
        </section>
        <section class="pages about">
            <div class="container">
                <nav class="tabLinks">
                    <div class="tabLinks__dropdown">Về chúng tôi
                    </div>

                    <ul>
                        <li class="active"><a target="_self" href="#!"
                                              title="$menu-&gt;title">Về chúng tôi</a></li>
                    </ul>
                </nav>
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-12">
                        {!! $config->web_des !!}
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



@endpush
