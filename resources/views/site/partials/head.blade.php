<link rel="preload" href="/site/frontend/assets/css/clone-heading.css" as="style">
<link rel="preload" href="/site/frontend/assets/css/styles.min3cc5.css?v=1.6" as="style">
<link rel="preload" href="/site/frontend/assets/css/banner-home-pagec619.css?v=1.0" as="style">
<link rel="preload" href="/site/frontend/assets/fonts/ArialMTviet.html" as="font" crossorigin>
<link rel="preload" href="/site/frontend/assets/fonts/UVNHongHaHepBold.html" as="font" crossorigin>
<link rel="preload" href="/site/frontend/images/bg-services.png" as="image">
<link rel="preload" href="/site/frontend/assets/fonts/Flaticon.html" as="font" crossorigin>
<style>
    #loader {
        position: fixed;
        top: 0;
        left: 0;
        height: 100%;
        width: 100%;
        z-index: 9999;
        background-color: rgba(255,255,255,0.7);
    }
    #loader:not(.loading) {
        display: none;
    }
    #loader::before {
        content: "";
        display: block;
        border: 10px solid #ccc;
        border-top: 10px solid red;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        -webkit-animation: mtkLoader 2s linear infinite;
        animation: mtkLoader 2s linear infinite;
        position: absolute;
        left: 50%;
        top: 50%;
        margin-left: -30px;
        margin-top: -30px;
    }
    /* Safari */
    @-webkit-keyframes mtkLoader {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }
    @keyframes  mtkLoader {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
</style>
<style type="text/css">
    .page-chi-tiet-tin-tuc-san-pham .item-chi-tiet-tin-tuc__desc {
        white-space: normal;
    }
</style>

<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
<meta name="csrf-token" content="wQv90NAsGLGGrMbNxuVv93jgCDck2L3ai0csj3Xg">

<title>@yield('title')</title>

<meta name="keywords" content=""/>


<link rel="shortcut icon" type="image/x-icon" href="{{@$config->favicon->path ?? ''}}" />
<link rel="apple-touch-icon" sizes="180x180" href="{{@$config->favicon->path ?? ''}}">
<link rel="icon" type="image/png" sizes="32x32" href="{{@$config->favicon->path ?? ''}}">
<link rel="icon" type="image/png" sizes="16x16" href="{{@$config->favicon->path ?? ''}}">

<meta name="robots" content="index, follow" />
<meta name="googlebot" content="index, follow">
<meta name="revisit-after" content="1 days" />
<meta name="generator" content="@yield('title')" />
<meta name="rating" content="General">
<meta name="application-name" content="{{ $config->web_title }}" />
<meta name="theme-color" content="#ed3235" />
<meta name="msapplication-TileColor" content="#ed3235" />
<meta name="apple-mobile-web-app-capable" content="yes" />
<meta name="apple-mobile-web-app-title" content="index.html" />
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:title" content="@yield('title')">
<meta property="og:description" content="@yield('description')">
<meta property="og:image" content="@yield('image')">
<meta property="og:site_name" content="{{ url()->current() }}">
<meta property="og:image:alt" content="{{ $config->web_title }}">
<meta itemprop="description" content="@yield('description')">
<meta itemprop="image" content="@yield('image')">
<meta itemprop="url" content="{{ url()->current() }}">

<meta property="og:type" content="website" />
<meta property="og:locale" content="vi_VN" />
<meta name="twitter:card" content="summary" />
<meta name="twitter:site" content="{{ url()->current() }}" />


<meta name="msapplication-TileColor" content="#FF0000">
<meta name="msapplication-TileImage" content="//site/frontend/assets/images/icons/ms-icon-144x144.png">
<meta name="theme-color" content="#FF0000">

<link href="/site/frontend/assets/css/clone-heading.css" rel="stylesheet">
<link href="/site/frontend/assets/css/styles.min3cc5.css?v=1.6" rel="stylesheet">
<link href="/site/frontend/assets/css/banner-home-pagec619.css?v=1.0" rel="stylesheet">

<link href="/site/frontend/assets/css/style-2019-07-08c619.css?v=1.0" rel="stylesheet">
<link href="/site/frontend/assets/css/style-2021-05-20.css" rel="stylesheet">
<link href="/site/frontend/assets/css/style-2021-05-24.css" rel="stylesheet">
<link href="/site/frontend/assets/css/style-2021-05-27.css" rel="stylesheet">


<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

<style>
    /* Ẩn mọi phần tử có ng-cloak cho tới khi Angular biên dịch xong */
    [ng-cloak], [data-ng-cloak], [x-ng-cloak],
    .ng-cloak, .data-ng-cloak, .x-ng-cloak {
        display: none !important;
    }
</style>
