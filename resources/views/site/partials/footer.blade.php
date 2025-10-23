<footer class="footer">

    <div class="footer__widgets">
        <div class="container">
            <div class="footer__widgets__content">
                <div class="row">
                    @foreach($business as $b)
                        <div class="col-6 col-lg-3">
                            <h3 class="navBox"><a href="{{ $b->content }}" rel="nofollow"
                                                  style="background-image: url({{ $b->image->path ?? '' }})"
                                                  title="{{ $b->title }}"><span class="navBox__title"><span
                                            class="navBox__title__line"></span><span class="navBox__title__subline"></span><span
                                            class="navBox__title__inner"><span>{{ $b->title }}</span></span></span></a></h3>
                        </div>

                    @endforeach
                </div>
                <style type="text/css">section.pages.pressRelease .contentPost .contentPost__text {
                        font-family: 'Arial';
                    }

                    section.pages.pressRelease .contentPost .contentPost__text b, section.pages.pressRelease .contentPost .contentPost__text strong {
                        font-weight: bold;
                    }
                </style>
            </div>
        </div>
    </div>


    <div class="footer__top">
        <div class="container">
            <div class="footer__top__content">
                <div class="row">
                    <div class="col-12 col-md-4">
                        <div class="footer__top__box">
                            <h3>
                                Điều khoản chung
                            </h3>
                            <ul>
                                @foreach($polices as $policy)
                                    <li>
                                        <a target="_self" href="{{ route('front.policy', $policy->slug) }}"
                                           title="{{ $policy->title }}" rel="nofollow">
                                            {{ $policy->title }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="footer__top__box">
                            <h3>
                                Hỗ trợ
                            </h3>
                            <ul>
                                <li>
                                    <a target="_self" href="{{ route('front.abouts') }}" title="Về chúng tôi" rel="nofollow">
                                        Về chúng tôi
                                    </a>
                                </li>
                                <li>
                                    <a target="_self" href="{{ route('front.contact') }}" title="Liên hệ" rel="nofollow">
                                        Liên hệ
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-6 col-md-4">
                        <div class="footer__top__box">
                            <h3>liên kết với {{ $config->short_name_company }}</h3>
                            <ul class="social">
                                <li><a target="_blank" href="{{ $config->facebook }}"
                                       title="facebook" rel="nofollow"><i class="fa fa-facebook"></i></a></li>
                                <li><a target="_blank" href="{{ $config->youtube }}"
                                       title="youtube" rel="nofollow"><i class="fa fa-youtube-play"></i></a></li>

                            </ul>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="footer__bottom">
        <div class="container">
            <div class="footer__bottom__inner">
                <div class="title">
                    {{ $config->web_title }}
                </div>
                <ul>

                    <li>
                        <i class="icon_pin"></i>
                        Ðịa chỉ: {{ $config->address_company }}
                    </li>
                    <li>
                        <i class="icon_phone"></i>
                        Điện thoại: {{ $config->hotline }}
                    </li>
                    <li>
                        <i class="icon_mail"></i>
                        Mail: {{ $config->email }}
                    </li>
                </ul>
                <div class="footer-copyright">
                    &copy; Copyright  {{ $config->short_name_company }} 2025
                </div>
            </div>
        </div>
    </div>


    <a class="toTop unsticky" href="#" style="opacity: 1;"><i class="fa fa-long-arrow-up"></i><span>top</span></a>


    <style>
        .social-box-mb {
            margin-top: 1.875em;
            text-align: left;
        }

        .social-box {
            text-align: right;
        }

        .footer_ssiam .footer__top__box ul.social li a i.fa-facebook {
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg width='1792' height='1792' viewBox='0 0 1792 1792' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill='%23FFFFFF' d='M1343 12v264h-157q-86 0-116 36t-30 108v189h293l-39 296h-254v759H734V905H479V609h255V391q0-186 104-288.5T1115 0q147 0 228 12z'/%3E%3C/svg%3E");
        }

        .footer_ssiam .footer__top__box ul.social li a i.fa-linkedin {
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg width='1792' height='1792' viewBox='0 0 1792 1792' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill='%23FFFFFF' d='M477 625v991H147V625h330zm21-306q1 73-50.5 122T312 490h-2q-82 0-132-49t-50-122q0-74 51.5-122.5T314 148t133 48.5T498 319zm1166 729v568h-329v-530q0-105-40.5-164.5T1168 862q-63 0-105.5 34.5T999 982q-11 30-11 81v553H659q2-399 2-647t-1-296l-1-48h329v144h-2q20-32 41-56t56.5-52 87-43.5T1285 602q171 0 275 113.5t104 332.5z'/%3E%3C/svg%3E");
        }

        .footer_ssiam .footer__top__box ul.social li a i.fa-youtube-play {
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg width='1792' height='1792' viewBox='0 0 1792 1792' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill='%23FFFFFF' d='M711 1128l484-250-484-253v503zm185-862q168 0 324.5 4.5T1450 280l73 4q1 0 17 1.5t23 3 23.5 4.5 28.5 8 28 13 31 19.5 29 26.5q6 6 15.5 18.5t29 58.5 26.5 101q8 64 12.5 136.5T1792 788v176q1 145-18 290-7 55-25 99.5t-32 61.5l-14 17q-14 15-29 26.5t-31 19-28 12.5-28.5 8-24 4.5-23 3-16.5 1.5q-251 19-627 19-207-2-359.5-6.5T336 1512l-49-4-36-4q-36-5-54.5-10t-51-21-56.5-41q-6-6-15.5-18.5t-29-58.5T18 1254q-8-64-12.5-136.5T0 1004V828q-1-145 18-290 7-55 25-99.5T75 377l14-17q14-15 29-26.5t31-19.5 28-13 28.5-8 23.5-4.5 23-3 17-1.5q251-18 627-18z'/%3E%3C/svg%3E");
        }

        .footer_ssiam .footer__top__box ul.social li a:hover i.fa-facebook {
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg width='1792' height='1792' viewBox='0 0 1792 1792' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill='%23ABABAB' d='M1343 12v264h-157q-86 0-116 36t-30 108v189h293l-39 296h-254v759H734V905H479V609h255V391q0-186 104-288.5T1115 0q147 0 228 12z'/%3E%3C/svg%3E");
        }

        .footer_ssiam .footer__top__box ul.social li a:hover i.fa-linkedin {
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg width='1792' height='1792' viewBox='0 0 1792 1792' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill='%23ABABAB' d='M477 625v991H147V625h330zm21-306q1 73-50.5 122T312 490h-2q-82 0-132-49t-50-122q0-74 51.5-122.5T314 148t133 48.5T498 319zm1166 729v568h-329v-530q0-105-40.5-164.5T1168 862q-63 0-105.5 34.5T999 982q-11 30-11 81v553H659q2-399 2-647t-1-296l-1-48h329v144h-2q20-32 41-56t56.5-52 87-43.5T1285 602q171 0 275 113.5t104 332.5z'/%3E%3C/svg%3E");
        }

        .footer_ssiam .footer__top__box ul.social li a:hover i.fa-youtube-play {
            background-image: url("data:image/svg+xml;charset=utf-8,%3Csvg width='1792' height='1792' viewBox='0 0 1792 1792' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath fill='%23ABABAB' d='M711 1128l484-250-484-253v503zm185-862q168 0 324.5 4.5T1450 280l73 4q1 0 17 1.5t23 3 23.5 4.5 28.5 8 28 13 31 19.5 29 26.5q6 6 15.5 18.5t29 58.5 26.5 101q8 64 12.5 136.5T1792 788v176q1 145-18 290-7 55-25 99.5t-32 61.5l-14 17q-14 15-29 26.5t-31 19-28 12.5-28.5 8-24 4.5-23 3-16.5 1.5q-251 19-627 19-207-2-359.5-6.5T336 1512l-49-4-36-4q-36-5-54.5-10t-51-21-56.5-41q-6-6-15.5-18.5t-29-58.5T18 1254q-8-64-12.5-136.5T0 1004V828q-1-145 18-290 7-55 25-99.5T75 377l14-17q14-15 29-26.5t31-19.5 28-13 28.5-8 23.5-4.5 23-3 17-1.5q251-18 627-18z'/%3E%3C/svg%3E");
        }
    </style>
</footer>

<div class="mobile">
    <div class="mobile__inner">
        <div class="mobile__scroll scroll-ui">
            <div class="mobile__top">
                <ul>
                    @if($customer)
                        @php
                            $full = trim($customer->fullname ?? '');
                            $parts = preg_split('/\s+/', $full, -1, PREG_SPLIT_NO_EMPTY);
                            $initials = count($parts) >= 2
                                ? mb_substr($parts[0],0,1).mb_substr($parts[count($parts)-1],0,1)
                                : (count($parts) === 1 ? mb_substr($parts[0],0,1) : 'U');
                            $displayName = \Illuminate\Support\Str::limit($customer->fullname, 24);
                        @endphp
                        <li><a href="{{ route('front.getProfile') }}#info" title="Hi, {{$displayName}}"><i><img class="svg"
                                                                                           src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 153.37 166'%3E%3Cdefs%3E%3Cstyle%3E.cls-1%7Bfill:%23fff;stroke:%23fff;stroke-miterlimit:10;stroke-width:3px%7D%3C/style%3E%3C/defs%3E%3Ctitle%3Eic-dang-nhap%3C/title%3E%3Cg id='Layer_2' data-name='Layer 2'%3E%3Cg id='Layer_1-2' data-name='Layer 1'%3E%3Cpath class='cls-1' d='M111.63 82.16a3.9 3.9 0 0 0-1.19-2.8l-.07-.08-27.59-27.59a3.91 3.91 0 0 0-5.53 0 3.48 3.48 0 0 0 0 5.15l21 20.66H5.41a4 4 0 0 0 0 8h92.65l-20.81 21.09a4.08 4.08 0 0 0 0 5.66 4 4 0 0 0 2.75 1.22 3.86 3.86 0 0 0 2.76-1.11l26.8-26.78a3.88 3.88 0 0 0 2.07-3.42z'/%3E%3Cpath class='cls-1' d='M43.87 102a4 4 0 0 1 4 3.9v50.6h96V9.5h-96v48.1a4 4 0 0 1-8 0V6.26c0-2.16.78-4.76 2.93-4.76h104.88c2.16 0 4.19 2.6 4.19 4.76V160c0 2.16-2 4.49-4.19 4.49H42.8c-2.15 0-2.93-2.33-2.93-4.49v-54.06a4 4 0 0 1 4-3.94z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"
                                                                                           alt="Hi, {{$displayName}}"></i><span>Hi, {{$displayName}}</span></a>
                        </li>
                    @else
                        <li><a href="{{ route('front.login') }}" title="Đăng nhập"><i><img class="svg"
                                                                                           src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 153.37 166'%3E%3Cdefs%3E%3Cstyle%3E.cls-1%7Bfill:%23fff;stroke:%23fff;stroke-miterlimit:10;stroke-width:3px%7D%3C/style%3E%3C/defs%3E%3Ctitle%3Eic-dang-nhap%3C/title%3E%3Cg id='Layer_2' data-name='Layer 2'%3E%3Cg id='Layer_1-2' data-name='Layer 1'%3E%3Cpath class='cls-1' d='M111.63 82.16a3.9 3.9 0 0 0-1.19-2.8l-.07-.08-27.59-27.59a3.91 3.91 0 0 0-5.53 0 3.48 3.48 0 0 0 0 5.15l21 20.66H5.41a4 4 0 0 0 0 8h92.65l-20.81 21.09a4.08 4.08 0 0 0 0 5.66 4 4 0 0 0 2.75 1.22 3.86 3.86 0 0 0 2.76-1.11l26.8-26.78a3.88 3.88 0 0 0 2.07-3.42z'/%3E%3Cpath class='cls-1' d='M43.87 102a4 4 0 0 1 4 3.9v50.6h96V9.5h-96v48.1a4 4 0 0 1-8 0V6.26c0-2.16.78-4.76 2.93-4.76h104.88c2.16 0 4.19 2.6 4.19 4.76V160c0 2.16-2 4.49-4.19 4.49H42.8c-2.15 0-2.93-2.33-2.93-4.49v-54.06a4 4 0 0 1 4-3.94z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E"
                                                                                           alt="Đăng nhập"></i><span>Đăng nhập</span></a>
                        </li>
                        <li class="openAccount"><a target="_blank" href="{{ route('front.register') }}"
                                                   title="Mở tài khoản"><i><img class="svg"
                                                                                src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 115 115'%3E%3Cdefs%3E%3Cstyle%3E.cls-1%7Bfill:%23fff%7D%3C/style%3E%3C/defs%3E%3Ctitle%3Eic-dang-ky%3C/title%3E%3Cg id='Layer_2' data-name='Layer 2'%3E%3Cpath class='cls-1' d='M108.81 6.19A21.11 21.11 0 0 0 79 6.18L15.43 69.33a3.59 3.59 0 0 0-.84 1.32L.22 110.18A3.59 3.59 0 0 0 3.6 115a3.48 3.48 0 0 0 1.05-.16l35.75-11a3.35 3.35 0 0 0 1.49-.89l66.92-66.92a21.11 21.11 0 0 0 0-29.87zM36.27 97.63l-13.38 4.11a15.48 15.48 0 0 0-3.65-6 19.65 19.65 0 0 0-4.88-3.45l6.13-16.84h8.26v7.19a3.6 3.6 0 0 0 3.6 3.59h6.34zm52.9-52.09L45.39 89.32l1.25-5.92a3.6 3.6 0 0 0-3.51-4.34h-7.19v-7.18a3.6 3.6 0 0 0-3.59-3.6h-5.67l42.74-42.49a13.94 13.94 0 1 1 19.75 19.75zM103.73 31l-3.35 3.36a21 21 0 0 0-19.73-19.74L84 11.28A13.93 13.93 0 1 1 103.73 31zm-23.61-1.2L44.18 65.74a3.59 3.59 0 1 0 5.08 5.08L85.2 34.88a3.59 3.59 0 0 0-5.08-5.08z' id='Layer_1-2' data-name='Layer 1'/%3E%3C/g%3E%3C/svg%3E"
                                                                                alt="Mở tài khoản"></i><span>Mở tài khoản</span></a>
                        </li>
                    @endif


                </ul>
            </div>

            <div class="mobile__center">
                <ul>
                    <li><a href="{{ route('front.home-page') }}" title="Trang chủ"><span>Trang chủ</span></a>
                    <li><a href="{{ route('front.abouts') }}" title="Giới thiệu"><span>Giới thiệu</span></a>
                    </li>
                    <li><a href="{{ route('front.services') }}" title="Dịch vụ"><span>Dịch vụ</span></a>
                    </li>

                    <li><a title="Tin tức"><span>Tin tức</span></a><a class="arrow" href="#"><i
                                class="arrow_carrot-down"></i></a>
                        <ul>
                            @foreach($postsCategory as $postCategory)
                                <li><a href="{{ route('front.blogs', $postCategory->slug) }}" title="{{ $postCategory->name }}"
                                       item="nav-link">{{ $postCategory->name }}</a></li>
                            @endforeach
                        </ul>
                    </li>
                    <li><a href="{{ route('front.contact') }}" title="Liên hệ"><span>Liên hệ</span></a>
                    </li>

                    <li><a href="{{ route('cart.index') }}" title="Giỏ hàng"><span>Giỏ hàng</span></a>
                    </li>
                </ul>
            </div>

        </div>
    </div>
</div>
<div id="loader"></div>

<div class="modal fade video" id="modal-play-youtube" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                    aria-hidden="true">&times;</span></button>
            <div class="modal-body">
                <div class="embed-responsive embed-responsive-16by9">
                    <div id="render-youtube-player" class="embed-responsive-item"></div>

                </div>
            </div>
        </div>
    </div>
</div>
