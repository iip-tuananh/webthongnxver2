@extends('site.layouts.master')
@section('title'){{ $policy->title }} - {{ $config->web_title }}@endsection
@section('description'){{ strip_tags(html_entity_decode($config->introduction)) }}@endsection
@section('image'){{@$config->image->path ?? ''}}@endsection

@section('css')
    <link type="text/css" rel="stylesheet" href="/site/custom/editor-content.css">



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
                    <li class="breadcrumb-item active" aria-current="page">{{ $policy->title }}
                    </li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="pages" ng-controller="blogPage">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="contentPost">
                        <div class="contentPost__title">
                            <a class="btnBack" href="javascript:history.back()">
                                <i class="ico-back"></i>
                                <span>Trở lại</span>
                            </a>
                            <div class="clone-h3">{{ $policy->title }}
                            </div>
                        </div>
                        <div class="contentPost__time">
                            <p>
                                <i class="icon_table"> </i>
                                <span>{{ \Carbon\Carbon::parse($policy->created_at)->format('d/m/Y') }}</span>
                            </p>
                        </div>
                        <div class="contentPost__text">
                            <div class="single-post-content">
                                <div class="single-post-content_text editor-content" id="font_chage">
                                    {!! $policy->content !!}
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection

@push('scripts')

@endpush
