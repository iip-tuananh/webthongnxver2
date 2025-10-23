@extends('site.layouts.master')
@section('title'){{ $config->web_title }}@endsection
@section('description'){{ strip_tags(html_entity_decode($config->introduction)) }}@endsection
@section('image'){{@$config->image->path ?? ''}}@endsection

@section('css')
    <link rel="stylesheet" type="text/css" href="/site/custom/home-page.css">
    <link rel="stylesheet" href="https://unpkg.com/swiper@11/swiper-bundle.min.css"/>


@endsection

@section('content')

    <section class="sBanner">
        <div class="sBanner__inner">
            @foreach($banners as $banner)
                <div class="sBanner__item">
                    <a class="overLink"
                       href="#!"></a>
                    <div class="sBanner__item__bg" style="background-image: url({{ $banner->image->path ?? '' }})">
                        <img src="{{ $banner->image->path ?? '' }}" alt=""></div>
                    <div class="container">
                        <div class="sBanner__item__inner">
                        </div>
                    </div>
                </div>

            @endforeach

        </div>
        <div class="container">
            <div class="sBanner__dots"></div>
            <div class="sBanner__arrows">
                <div class="arrow arrow--prev"><i class="arrow_left"></i></div>
                <div class="arrow arrow--next"><i class="arrow_right"></i></div>
            </div>
        </div>
    </section>

    <style scoped>
        section.sServices {
            background-image: url(/site/frontend/images/bg-services.png)
        }

        @media (max-width: 425px) {
            section.sServices {
                background-image: url(/site/frontend/images/bg-services-mobile.png)
            }
        }
    </style>
    <section class="sServices">
        <div class="container">


            <div class="row g-3 justify-content-center">

                @foreach($services as $service)
                    <div class="col-6 col-md-4 col-lg-2-4">
                        <div class="service">
                            <a href="{{ route('front.getServiceDetail', $service->slug) }}" class="service__bg"
                               style="background-image: url({{ $service->image->path ?? '' }})"></a>
{{--                            <div class="service__icon"><i class="fi flaticon-003-employee-1"></i></div>--}}
                            <div class="service__icon">
                                <img
                                    src="{{ $service->image_label->path ?? '' }}"
                                    alt="Icon {{ $service->name }}"
                                    width="48" height="48"
                                    loading="lazy" decoding="async"
                                >
                            </div>
                            <h2 class="service__title">
                                <span>{{ $service->name }}</span>
                            </h2>
                            @if($service->results && count($service->results))
                                <div class="service__list">
                                    <div>
                                        <ul>
                                            @foreach($service->results as $result)
                                                <li style="text-align: justify;"><a href="#!">{{ $result['title'] }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>

                            @endif
                        </div>
                    </div>
                @endforeach

            </div>

        </div>
    </section>


    @foreach($categoriesSpecial as $categorySpecial)
        <section class="post-slider" aria-label="Bài viết nổi bật">
            <div class="container">
                <div class="row">
                    <div class="post-slider__head">
                        <h2 class="post-slider__title">{{ $categorySpecial->name }}</h2>

                        <div class="post-slider__nav ms-auto">
                            <button class="ps-btn ps-prev" aria-label="Bài trước">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M15 18l-6-6 6-6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                            <button class="ps-btn ps-next" aria-label="Bài sau">
                                <svg width="18" height="18" viewBox="0 0 24 24" fill="none"><path d="M9 6l6 6-6 6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/></svg>
                            </button>
                        </div>
                    </div>

                    <div class="post-slider__track">

                        @foreach($categorySpecial->posts as $post)
                            <article class="post-card">
                                <a href="{{ route('front.blogDetail', $post->slug) }}" class="post-card__thumb" style="background-image:url({{ $post->image->path ?? '' }});">

                                    <!-- Trường hợp MIỄN PHÍ -->
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

                                </a>
                                <div class="post-card__body">
                                    <div class="post-card__meta">
                                        <span class="author">By Admin</span>
                                        <span class="dot">•</span>
                                        <time>{{ \Illuminate\Support\Carbon::parse($post->created_at)->format('d/m/Y') }}</time>
                                    </div>
                                    <h3 class="post-card__title">
                                        <a class="line-clamp-2" href="{{ route('front.blogDetail', $post->slug) }}">{{ $post->name }}</a>

                                        @if($post->is_hot == 1)
                                            <span class="hot-badge" title="Tin hot" aria-label="Tin hot">
                                            <i class="fa-solid fa-fire" aria-hidden="true"></i>
                                            <b>Tin hot</b>
                                        </span>
                                        @endif

                                    </h3>
                                    <p class="post-card__excerpt line-clamp-4">
                                        {{ $post->intro }}
                                    </p>
                                </div>
                            </article>

                        @endforeach
                    </div>
                </div>

            </div>

        </section>
    @endforeach

    <section class="whyus">
        <div class="wy-container">
            <div class="wy-grid">
                <!-- Media (Trái) -->
                <figure class="wy-media">
                    <img src="{{ $about->image->path ?? '' }}"
                         alt="" />
                </figure>

                <!-- Content (Phải) -->
                <div class="wy-content">
                    <div class="wy-eyebrow">
                        <span class="dot"></span>
                        <span>{{ $about->sub_title }}</span>
                        <span class="dot"></span>
                    </div>

                    <h2 class="wy-title">
                        {{ $about->title }}
                      </h2>

                      <p class="wy-intro">
                          {{ $about->intro }}
                      </p>

                    @if ($about->results && count($about->results))
                        @foreach ($about->results as $key => $why)
                            <div class="wy-feature">
                                <h3>{{ $why['title'] }}</h3>
                                <p>{{ $why['content'] }}</p>
                            </div>
                        @endforeach
                    @endif



                      <a href="{{ route('front.abouts') }}" class="wy-btn">
                          Tìm hiểu thêm
                          <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
                              <path d="M5 12h14M13 5l7 7-7 7" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                          </svg>
                      </a>
                  </div>
              </div>
          </div>
      </section>


    <section class="partners">
        <div class="container">
            <h3 class="partners-title">ĐỐI TÁC CỦA CHÚNG TÔI</h3>

            <div class="swiper partners-swiper" aria-label="Slider đối tác">
                <div class="swiper-wrapper">
                    <!-- Demo items: thay src bằng logo của bạn -->
                    @foreach($partners as $partner)
                        <div class="swiper-slide">
                            <figure class="logo-card">
                                <img src="{{ $partner->image->path ?? '' }}" alt="">
                            </figure>
                        </div>
                    @endforeach


                </div>

                <!-- Controls -->
                <div class="swiper-button-prev" aria-label="Trước"></div>
                <div class="swiper-button-next" aria-label="Sau"></div>
                <div class="swiper-pagination"></div>
            </div>
        </div>
    </section>

  @endsection

  @push('scripts')
      <script>
          app.controller('homePage', function ($rootScope, $scope, cartItemSync, $interval) {
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



            $scope.getPostByCate = function (cateId) {
                var $loader = $('.ajax-loader');
                $scope.currentCateId = cateId;
                $.ajax({
                    type: 'GET',
                    url: "/get-post-by-cate?cate_id="+cateId,
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    beforeSend: function () {
                        $loader.stop(true, true).fadeIn(100);
                    },
                    success: function (response) {
                        if (response.success) {
                            $scope.posts = response.data;
                            console.log($scope.posts)
                            $scope.$applyAsync();
                        } else {
                        }
                    },
                    error: function (e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        $loader.stop(true, true).fadeOut(100);
                    }
                });
            }

            $scope.postCategories = @json($postCategories ?? []);

            $scope.getCategoryCurrent = function (currentCateId) {
                var items = Array.isArray($scope.postCategories) ? $scope.postCategories : [];
                if (currentCateId == null || items.length === 0) return null;

                var target = String(currentCateId);
                for (var i = 0; i < items.length; i++) {
                    var it = items[i];
                    if (it && String(it.id) === target) return it;
                }
                return null;
            };

            @php
                $cats = array_values($postCategories->toArray() ?? []);
                $pick = $cats[0] ?? ($cats[1] ?? null);
                $id = data_get($pick, 'id');
            @endphp
            @if($id)
                $scope.getPostByCate({{ (int)$id }});
            @endif

            $scope.formartDate = function (date) {
                return new Date(date.replace(' ', 'T'));
            }

        })
    </script>
    <script>
        (function () {
            // Khởi tạo cho TỪNG khối .post-slider
            document.querySelectorAll('.post-slider').forEach(function (section) {
                const track = section.querySelector('.post-slider__track');
                const prev  = section.querySelector('.ps-prev');
                const next  = section.querySelector('.ps-next');
                if (!track || !prev || !next) return;

                function step() {
                    const card  = track.querySelector('.post-card');
                    if (!card) return track.clientWidth;
                    const gap   = parseInt(getComputedStyle(track).gap || 0, 10);
                    return card.getBoundingClientRect().width + gap;
                }

                prev.addEventListener('click', () =>
                    track.scrollBy({ left: -step(), behavior: 'smooth' })
                );
                next.addEventListener('click', () =>
                    track.scrollBy({ left:  step(), behavior: 'smooth' })
                );

                // Kéo bằng chuột
                let isDown = false, startX = 0, startLeft = 0;
                track.addEventListener('mousedown', (e) => {
                    isDown = true;
                    startX = e.pageX - track.getBoundingClientRect().left;
                    startLeft = track.scrollLeft;
                    track.classList.add('grabbing');
                });
                window.addEventListener('mouseup', () => {
                    isDown = false;
                    track.classList.remove('grabbing');
                });
                track.addEventListener('mouseleave', () => {
                    isDown = false;
                    track.classList.remove('grabbing');
                });
                track.addEventListener('mousemove', (e) => {
                    if (!isDown) return;
                    e.preventDefault();
                    const x = e.pageX - track.getBoundingClientRect().left;
                    const walk = (x - startX) * 1.1;
                    track.scrollLeft = startLeft - walk;
                });
            });
        })();
    </script>

      <script src="https://unpkg.com/swiper@11/swiper-bundle.min.js"></script>
      <script>
          const partnersSwiper = new Swiper('.partners-swiper', {
              loop: true,
              speed: 600,
              spaceBetween: 24,
              autoplay: { delay: 2200, disableOnInteraction: false },
              navigation: {
                  nextEl: '.partners .swiper-button-next',
                  prevEl: '.partners .swiper-button-prev'
              },
              pagination: { el: '.partners .swiper-pagination', clickable: true },
              // Responsive: 4 item desktop
              slidesPerView: 2,
              breakpoints: {
                  576: { slidesPerView: 2 },
                  768: { slidesPerView: 3 },
                  992: { slidesPerView: 4 } // >=992px hiển thị 4
              }
          });
      </script>
@endpush
