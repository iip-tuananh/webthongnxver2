@extends('site.layouts.master')
@section('title'){{ $service->name }} - {{ $config->web_title }}@endsection
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
                    <li class="breadcrumb-item">
                        <a href="{{ route('front.services') }}" title="Dịch vụ">Dịch vụ</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">{{ $service->name }}
                    </li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="pages" ng-controller="blogPage">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3 sidebar">

                    <nav class="navSidebar">
                        <ul>
                            @foreach($otherServices as $otherService)
                                <li><a href="{{ route('front.getServiceDetail', $otherService->slug) }}">{{ $otherService->name }}</a><span></span></li>
                            @endforeach
                        </ul>
                    </nav>

                </div>
                <div class="col-12 col-md-8 col-lg-9">
                    <div class="contentPost">
                        <div class="contentPost__title">
                            <a class="btnBack" href="javascript:history.back()">
                                <i class="ico-back"></i>
                                <span>Trở lại</span>
                            </a>
                            <div class="clone-h3">{{ $service->name }}”
                            </div>
                        </div>
                        <div class="contentPost__time">
                            <p>
                                <i class="icon_table"> </i>
                                <span>{{ \Carbon\Carbon::parse($service->created_at)->format('d/m/Y') }}</span>
                            </p>
                        </div>
                        <div class="contentPost__text">
                            <div style="margin-bottom: 10px"><img alt="" src="{{ $service->image->path ?? '' }}"/></div>
                            <div class="single-post-content">
                                <div class="single-post-content_text editor-content" id="font_chage">
                                    {!! $service->content !!}
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
