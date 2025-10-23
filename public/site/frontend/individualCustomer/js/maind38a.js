"use strict";

function _typeof(obj) { "@babel/helpers - typeof"; return _typeof = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ? function (obj) { return typeof obj; } : function (obj) { return obj && "function" == typeof Symbol && obj.constructor === Symbol && obj !== Symbol.prototype ? "symbol" : typeof obj; }, _typeof(obj); }
function _defineProperty(obj, key, value) { key = _toPropertyKey(key); if (key in obj) { Object.defineProperty(obj, key, { value: value, enumerable: true, configurable: true, writable: true }); } else { obj[key] = value; } return obj; }
function _toPropertyKey(arg) { var key = _toPrimitive(arg, "string"); return _typeof(key) === "symbol" ? key : String(key); }
function _toPrimitive(input, hint) { if (_typeof(input) !== "object" || input === null) return input; var prim = input[Symbol.toPrimitive]; if (prim !== undefined) { var res = prim.call(input, hint || "default"); if (_typeof(res) !== "object") return res; throw new TypeError("@@toPrimitive must return a primitive value."); } return (hint === "string" ? String : Number)(input); }
/* global Waypoint, google */
// Image svg
function imgSVG() {
  $('img.svg').each(function () {
    var $img = $(this);
    var imgID = $img.attr('id');
    var imgClass = $img.attr('class');
    var imgURL = $img.attr('src');
    $.get(imgURL, function (data) {
      // Get the SVG tag, ignore the rest
      var $svg = $(data).find('svg');

      // Add replaced image's ID to the new SVG
      if (typeof imgID !== 'undefined') {
        $svg = $svg.attr('id', imgID);
      }
      // Add replaced image's classes to the new SVG
      if (typeof imgClass !== 'undefined') {
        $svg = $svg.attr('class', imgClass + ' replaced-svg');
      }

      // Remove any invalid XML tags as per http://validator.w3.org
      $svg = $svg.removeAttr('xmlns:a');

      // Replace image with new SVG
      $img.replaceWith($svg);
    }, 'xml');
  });
}

// Nav Search
function navSearch() {
  var btnSearch = $('.navbar__search--open');
  var btnSearchClose = $('.navbar__search--close');
  var wrapSearch = $('.navbar__search--layer');
  btnSearch.click(function (e) {
    e.stopPropagation();
    if (btnSearch.hasClass('active')) {
      $(this).removeClass('active');
      wrapSearch.removeClass('active');
    } else {
      $(this).addClass('active');
      wrapSearch.addClass('active');
    }
  });
  btnSearchClose.bind('click', function (e) {
    e.stopPropagation();
    btnSearch.removeClass('active');
    wrapSearch.removeClass('active');
  });
}

// Layout
function gotoTop() {
  var topTop = $('.toTop');
  $(window).scroll(function () {
    if ($(this).scrollTop() > 200) {
      topTop.stop().fadeIn(200);
    } else {
      topTop.stop().fadeOut(200);
    }
  });
  topTop.click(function () {
    $('body,html').animate({
      scrollTop: 0
    }, 500);
    return false;
  });
  $('.footer').waypoint(function (direction) {
    topTop.toggleClass('unsticky', direction === 'down');
  }, {
    offset: '100%'
  });
}

// Áp dụng tất cả [data-waypoint]
function waypointEl() {
  var way = $('[data-waypoint]');
  way.each(function () {
    var _el = $(this),
      _ofset = _el.data('waypoint'),
      _up = _el.data('waypointup');
    _el.waypoint(function (direction) {
      if (direction == 'down') {
        _el.addClass('active');
      } else {
        if (_up) {
          _el.removeClass('active');
        }
      }
    }, {
      offset: _ofset
    });
  });
}

// Detect scroll down apply thiner Header - Layout
function outviewHeader() {
  var header = $('#header');
  $(window).scroll(function () {
    if ($(this).scrollTop() > 100) {
      header.addClass('thiner');
    } else {
      header.removeClass('thiner');
    }
  });
}
function banner() {
  $('.hero-banner .sBanner__inner').on('init', function () {
    $('.hero-banner .sBanner__inner').animate({
      opacity: 1
    }, 350);
  });
  $('.hero-banner .sBanner__inner').slick({
    dots: false,
    prevArrow: $('.arrow--prev'),
    nextArrow: $('.arrow--next'),
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    adaptiveHeight: true,
    fade: true,
    cssEase: 'linear',
    autoplay: true,
    autoplaySpeed: 5500,
    lazyLoad: 'ondemand'
  });
  $('.sBanner__item__title').lettering('words');
  $('.sBanner__item__desc').lettering('words');
}

// Effect text - sSSIIBoard - home page
function sSSIIBoard() {
  $('.sSSIIBoard .sSSIIBoard-banner').on('init', function () {
    $('.sSSIIBoard .sSSIIBoard-banner').animate({
      opacity: 1
    }, 350);
  });
  $('.sSSIIBoard-banner_item__title').lettering('words');
  $('.sSSIIBoard-banner_item__desc').lettering('words');
}

// Gọi các hàm - home page
function bannerSlider() {
  banner(); // Init slider
  sSSIIBoard(); // Effect text
}

function navSidebar() {
  var $expand = $('.navSidebar .arrow');
  $expand.click(function (event) {
    event.preventDefault();
    var el = $(this),
      elContent = el.next('ul'),
      elWrap = elContent.parent('li'),
      allContent = el.parent('li').parent('ul').children('li').children('ul'),
      allWrap = allContent.parent('li');
    if (elWrap.hasClass('active')) {
      elWrap.removeClass('active');
      elContent.stop().slideUp(200);
    } else {
      allContent.stop().slideUp(200);
      allWrap.removeClass('active');
      elWrap.addClass('active');
      elContent.stop().slideDown(200);
    }
  });
  var navLi = $('.navSidebar li.current');
  navLi.parents('li').addClass('active').children('ul').show();
}

// Zoom Image
function imgZoom() {
  $('#organizationalChart').elevateZoom({
    zoomType: 'lens',
    lensShape: 'round',
    lensSize: 350,
    borderSize: 0,
    responsive: true,
    containLensZoom: true
  });
}

// More/Less Content
function moreLess() {
  $('.limitCharacter').each(function () {
    var el = $(this),
      height = el.data('height'),
      more = el.data('more'),
      less = el.data('less');
    el.readmore({
      speed: 200,
      collapsedHeight: height,
      moreLink: '<a href="#">' + more + '</a>',
      lessLink: '<a href="#">' + less + '</a>',
      afterToggle: function afterToggle(trigger, element, expanded) {
        if (el.parents('.slick-initialized').length) {
          var heightSlide = el.parents('.slick-slide').height();
          el.parents('.slick-list').animate({
            height: heightSlide
          }, 200);
        }
      }
    });
  });
}
function history1() {
  var el = $('#timelineAbout'),
    elNav = $('#timelineAboutContent');
  el.on('init', function (event, slick) {
    el.find('.timeline__title').click(function () {
      var _this = $(this),
        index = _this.parents('.slick-slide').data('slick-index');
      el.slick('slickGoTo', index);
    });
  }).slick({
    infinite: true,
    speed: 300,
    slidesToShow: 7,
    slidesToScroll: 1,
    cssEase: 'linear',
    prevArrow: '<a class="arrow--1 arrow--prev" href="javascript:void(0)"><i class="arrow_triangle-left"></i></a>',
    nextArrow: '<a class="arrow--1 arrow--next" href="javascript:void(0)"><i class="arrow_triangle-right"></i></a>',
    asNavFor: elNav,
    // focusOnSelect: true,
    responsive: [{
      breakpoint: 1024,
      settings: {
        slidesToShow: 5
      }
    }, {
      breakpoint: 992,
      settings: {
        slidesToShow: 4
      }
    }, {
      breakpoint: 700,
      settings: {
        slidesToShow: 3
      }
    }, {
      breakpoint: 640,
      settings: {
        slidesToShow: 2
      }
    }]
  });
  elNav.slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    speed: 300,
    cssEase: 'linear',
    arrows: false,
    asNavFor: el,
    centerPadding: 0,
    fade: true,
    centerMode: true,
    focusOnSelect: true
  });
}
function prize() {
  $('.prizeSlide').slick({
    slidesToShow: 2,
    slidesToScroll: 2,
    //speed: 500,
    // cssEase: 'linear',
    arrows: true,
    prevArrow: '<a class="arrow--1 arrow--prev arrow--middle" href="javascript:void(0)"><i class="arrow_triangle-left"></i></a>',
    nextArrow: '<a class="arrow--1 arrow--next arrow--middle" href="javascript:void(0)"><i class="arrow_triangle-right"></i></a>',
    centerPadding: 0,
    rows: 2,
    // centerMode: true,
    focusOnSelect: true,
    responsive: [{
      breakpoint: 992,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }, {
      breakpoint: 640,
      settings: {
        rows: 1,
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }]
  });
}
function historyOther() {
  var el = $('#timelineEvent'),
    elNav = $('#timelineContent');
  el.on('init', function (event, slick) {
    el.find('.timeline__title').click(function () {
      var _this = $(this),
        index = _this.parents('.slick-slide').data('slick-index');
      el.slick('slickGoTo', index);
    });
  }).slick({
    infinite: true,
    speed: 300,
    slidesToShow: 5,
    slidesToScroll: 1,
    cssEase: 'linear',
    prevArrow: '<a class="arrow--1 arrow--prev" href="javascript:void(0)"><i class="arrow_triangle-left"></i></a>',
    nextArrow: '<a class="arrow--1 arrow--next" href="javascript:void(0)"><i class="arrow_triangle-right"></i></a>',
    asNavFor: elNav,
    // focusOnSelect: true,
    responsive: [{
      breakpoint: 1024,
      settings: {
        slidesToShow: 4
      }
    }, {
      breakpoint: 992,
      settings: {
        slidesToShow: 4
      }
    }, {
      breakpoint: 700,
      settings: {
        slidesToShow: 3
      }
    }, {
      breakpoint: 640,
      settings: {
        slidesToShow: 2
      }
    }]
  });
  elNav.slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    speed: 300,
    cssEase: 'linear',
    arrows: false,
    asNavFor: el,
    centerPadding: 0,
    adaptiveHeight: true,
    centerMode: true
  });
}
function historyOther1() {
  var el = $('#timelineEvent1'),
    elNav = $('#timelineContent1');
  el.on('init', function (event, slick) {
    el.find('.timeline__title').click(function () {
      var _this = $(this),
        index = _this.parents('.slick-slide').data('slick-index');
      el.slick('slickGoTo', index);
    });
  }).slick({
    infinite: true,
    speed: 300,
    slidesToShow: 5,
    slidesToScroll: 1,
    cssEase: 'linear',
    prevArrow: '<a class="arrow--1 arrow--prev" href="javascript:void(0)"><i class="arrow_triangle-left"></i></a>',
    nextArrow: '<a class="arrow--1 arrow--next" href="javascript:void(0)"><i class="arrow_triangle-right"></i></a>',
    asNavFor: elNav,
    // focusOnSelect: true,
    responsive: [{
      breakpoint: 1024,
      settings: {
        slidesToShow: 4
      }
    }, {
      breakpoint: 992,
      settings: {
        slidesToShow: 4
      }
    }, {
      breakpoint: 700,
      settings: {
        slidesToShow: 3
      }
    }, {
      breakpoint: 640,
      settings: {
        slidesToShow: 2
      }
    }]
  });
  elNav.slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    speed: 300,
    cssEase: 'linear',
    arrows: false,
    asNavFor: el,
    centerPadding: 0,
    adaptiveHeight: true,
    //fade: true,
    centerMode: true
  });
}
function historyOther2() {
  var el = $('#timelineEvent2'),
    elNav = $('#timelineContent2');
  el.on('init', function (event, slick) {
    el.find('.timeline__title').click(function () {
      var _this = $(this),
        index = _this.parents('.slick-slide').data('slick-index');
      el.slick('slickGoTo', index);
    });
  }).slick({
    infinite: true,
    speed: 300,
    slidesToShow: 7,
    slidesToScroll: 1,
    cssEase: 'linear',
    prevArrow: '<a class="arrow--1 arrow--prev" href="javascript:void(0)"><i class="arrow_triangle-left"></i></a>',
    nextArrow: '<a class="arrow--1 arrow--next" href="javascript:void(0)"><i class="arrow_triangle-right"></i></a>',
    asNavFor: elNav,
    // focusOnSelect: true,
    responsive: [{
      breakpoint: 1024,
      settings: {
        slidesToShow: 5
      }
    }, {
      breakpoint: 992,
      settings: {
        slidesToShow: 4
      }
    }, {
      breakpoint: 700,
      settings: {
        slidesToShow: 3
      }
    }, {
      breakpoint: 640,
      settings: {
        slidesToShow: 2
      }
    }]
  });
  elNav.slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    speed: 300,
    cssEase: 'linear',
    arrows: false,
    asNavFor: el,
    centerPadding: 0,
    adaptiveHeight: true,
    centerMode: true
  });
}
function showMenuChild() {
  var btnNav = $('.btn-nav');
  btnNav.each(function () {
    var el = $(this);
    el.click(function (event) {
      event.preventDefault();
      el.next().slideToggle();
      el.toggleClass('open-nav');
    });
    el.next().click(function () {
      el.next().slideToggle();
      el.toggleClass('open-nav');
    });
  });
}
function getValuedropdown() {
  var el = $('.nav-tabs li a');
  el.click(function () {
    var selText = $(this).html();
    $(this).parents('.prizeSlide__year').find('.btn-nav').html(selText);
  });
}

// Hotnews
function hotNews() {
  $('.hotNews__slide').slick({
    dots: false,
    arrows: false,
    infinite: true,
    speed: 500,
    fade: true,
    cssEase: 'linear',
    autoplay: true,
    autoplaySpeed: 3000
  });
}

// Navigation Widget
function navWidget() {
  var navWidget = $('.navWidget'),
    navWidgetClose = navWidget.find('.navWidget__expand__close');
  navWidget.each(function () {
    var navWidgetContent = $(this).find('.navWidget__content');
    navWidgetContent.bind('click', function (e) {
      if ($(this).parents('.navWidget').find('.navWidget__expand').length) {
        e.preventDefault();
      }
    });
  });
  navWidgetClose.bind('click', function (e) {
    var el = $(this),
      expand = el.parents('.navWidget__expand');
    e.preventDefault();
    expand.stop().slideUp(300);
    el.parents('.navWidget').removeClass('active');
  });
  navWidget.bind('click', function () {
    var el = $(this),
      expand = el.find('.navWidget__expand');
    if (expand.is(':hidden')) {
      navWidget.find('.navWidget__expand').stop().slideUp(300).queue(function (next) {
        expand.stop().slideDown(300);
        next();
      });
      navWidget.removeClass('active');
      el.addClass('active');
    } else {
      expand.stop().slideUp(300);
      el.removeClass('active');
    }
  });
  navWidget.find('.navWidget__expand').bind('click', function (e) {
    e.stopPropagation();
  });
  $('.navWidgets').bind('click', function (e) {
    e.stopPropagation();
  });
  $(document).click(function (event) {
    navWidget.removeClass('active');
    $('.navWidget__expand').stop().slideUp(300);
  });
}

//show info contact
function infoContact() {
  var el = $('.navLink li a');
  el.click(function (e) {
    var elP = $(this).parent().parent();
    e.preventDefault();
    if (elP.hasClass('active')) {
      elP.removeClass('active');
    } else {
      $('.navLink li').removeClass('active');
      elP.addClass('active');
    }
  });
  $('.navLink').bind('click', function (e) {
    e.stopPropagation();
  });
  $(document).click(function (event) {
    $('.navLink li').removeClass('active');
  });
}
function mobileMenu() {
  var $toggle = $('.navbar-toggle');
  var $mobileMenu = $('.mobile');
  var $navbar = $('.navbar');
  $toggle.click(function (e) {
    e.stopPropagation();
    if ($mobileMenu.hasClass('active')) {
      $toggle.removeClass('active');
      $mobileMenu.removeClass('active');
      $navbar.removeClass('active');
    } else {
      $toggle.addClass('active');
      $mobileMenu.addClass('active');
      $navbar.addClass('active');
    }
  });
  $mobileMenu.find('.mobile__top').click(function (e) {
    e.stopPropagation();
  });
  $mobileMenu.find('.mobile__center').click(function (e) {
    e.stopPropagation();
  });
  $(document).click(function (event) {
    $toggle.removeClass('active');
    $mobileMenu.removeClass('active');
  });
  var $expand = $('.mobile__center .arrow');
  $expand.click(function (event) {
    event.preventDefault();
    el = $(this);
    elContent = el.next('ul'), elWrap = elContent.parents('li');
    allContent = el.parents('.mobile__center').children('ul').children('li').children('ul'), allWrap = allContent.parent('li');
    if (elWrap.hasClass('expand')) {
      elWrap.removeClass('expand');
      elContent.stop().slideUp(200);
    } else {
      allContent.stop().slideUp(200);
      allWrap.removeClass('expand');
      elWrap.addClass('expand');
      elContent.stop().slideDown(200);
    }
  });
  var navLi = $('.mobile__center li.active');
  navLi.parents('li').addClass('expand').children('ul').show();
}
function tabLinks() {
  var dropdown = $('.tabLinks__dropdown');
  dropdown.click(function (e) {
    e.stopPropagation();
    var el = $(this);
    if (el.hasClass('active')) {
      el.removeClass('active');
    } else {
      el.addClass('active');
    }
  });
  dropdown.next('ul').click(function (e) {
    e.stopPropagation();
  });
  $(document).click(function (event) {
    dropdown.removeClass('active');
  });
}
function alignMenuCenter() {
  var $menu = $('.navbar__menu__list');
  var $menuItem = $('.navbar__menu__item');
  if ($menuItem.length < 1) return;
  if ($menuItem.length > 3) {
    $menu.addClass('between');
  } else $menu.removeClass('between');
}

// ❌ [CONFIRM ĐỂ XOÁ]
function sliderPartner() {
  $('.partner').slick({
    infinite: true,
    rows: 2,
    slidesPerRow: 4,
    arrows: true,
    prevArrow: '<a class="arrow--1 partner arrow--prev" href="javascript:void(0)"><i class="arrow_triangle-left"></i></a>',
    nextArrow: '<a class="arrow--1 partner arrow--next" href="javascript:void(0)"><i class="arrow_triangle-right"></i></a>',
    responsive: [{
      breakpoint: 991,
      settings: {
        rows: 2,
        slidesPerRow: 3
      }
    }, {
      breakpoint: 479,
      settings: {
        rows: 2,
        slidesPerRow: 2
      }
    }, {
      breakpoint: 375,
      settings: {
        rows: 1,
        slidesPerRow: 1,
        autoplay: true,
        arrows: false
      }
    }]
  });
}

// ❌ [CONFIRM ĐỂ XOÁ]
function sliderCustomer() {
  $('.customer').slick({
    infinite: true,
    slidesToShow: 3,
    slidesToScroll: 3,
    arrows: true,
    prevArrow: '<a class="arrow--1 partner arrow--prev" href="javascript:void(0)"><i class="arrow_triangle-left"></i></a>',
    nextArrow: '<a class="arrow--1 partner arrow--next" href="javascript:void(0)"><i class="arrow_triangle-right"></i></a>',
    responsive: [{
      breakpoint: 479,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    }, {
      breakpoint: 375,
      settings: {
        autoplay: true,
        arrows: false,
        slidesToShow: 1
      }
    }]
  });
}
function sliderNotifyList() {
  var resizeWidth = function resizeWidth() {
    return $('.notifyBar_wrap').width($('#notifyBarList').width());
  };
  $(window).on('resize', resizeWidth);
  resizeWidth();
}
function initTabsJourSlide() {
  $('.journey__tabs__label').on('shown.bs.tab', function () {
    $('.journey__slide').slick('setPosition');
  });
}
function journeySlide() {
  $('.journey__slide').each(function () {
    $('.cardProduct__title').matchHeight();
    $(this).slick({
      slidesToShow: 3,
      slidesToScroll: 3,
      arrows: false,
      dots: true,
      dotsClass: 'slick-dots__custom gray',
      responsive: [{
        breakpoint: 992,
        settings: {
          slidesToShow: 2,
          slidesToScroll: 2
        }
      }, {
        breakpoint: 575,
        settings: {
          slidesToShow: 1,
          slidesToScroll: 1
        }
      }]
    });
  });
}
function customBanner() {
  $('.o-customBanner').each(function () {
    $(this).slick({
      dots: true,
      arrows: false,
      cssEase: 'linear',
      autoplay: true,
      autoplaySpeed: 5500,
      lazyLoad: 'ondemand',
      infinite: true,
      speed: 300,
      slidesToShow: 1,
      fade: true,
      dotsClass: 'slick-dots__custom'
    });
  });
}
function animateNumber(finalNumber) {
  var duration = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : 5000;
  var startNumber = arguments.length > 2 && arguments[2] !== undefined ? arguments[2] : 0;
  var callback = arguments.length > 3 ? arguments[3] : undefined;
  var startTime = performance.now();
  function updateNumber(currentTime) {
    var elapsedTime = currentTime - startTime;
    if (elapsedTime > duration) {
      callback(finalNumber);
    } else {
      var rate = elapsedTime / duration;
      var currentNumber = Math.round(rate * finalNumber);
      callback(Math.max(currentNumber, 0));
      requestAnimationFrame(updateNumber);
    }
  }
  requestAnimationFrame(updateNumber);
}
function numberWithDots(x) {
  if (!x) return 0;
  return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}
function counterNumber() {
  var ele = $('.cardCounterNumber__number');
  ele.each(function () {
    var number = $(this).data('number') || 0;
    var eleChild = $(this);
    animateNumber(Number(number), 3000, 0, function (number) {
      eleChild.text("".concat(numberWithDots(number), "+"));
    });
  });
}

// Video youtube
function video_control() {
  function youtube_parser(url) {
    var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
    var match = url.match(regExp);
    return match && match[7].length == 11 ? match[7] : false;
  }
  function vimeo_parser(url) {
    var m = url.match(/^.+vimeo.com\/(.*\/)?([^#\?]*)/);
    return m ? m[2] || m[1] : null;
  }
  function youtube_iframe(url) {
    return '<iframe src="https://www.youtube.com/embed/' + youtube_parser(url) + '?autoplay=1&mute=1&controls=0&disablekb=1&enablejsapi=1&loop=1&modestbranding=1&playsinline=1&color=white"  frameborder="0" allowfullscreen allow="autoplay"></iframe>';
  }
  function vimeo_iframe(url) {
    return '<iframe src="https://player.vimeo.com/video/' + vimeo_parser(url) + '?autoplay=1&title=0&byline=0&portrait=0&rel=0" frameborder="0" allow="autoplay" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
  }
  $('.template-guideOpenAccount__btnPlay').on('click', function (e) {
    e.preventDefault();
    var frame = $(this).closest('.template-guideOpenAccount__video'),
      linkVid = frame.data('link');
    $(this).fadeOut();
    if (linkVid.indexOf('vimeo') > -1) {
      frame.append(vimeo_iframe(linkVid));
    } else {
      frame.append(youtube_iframe(linkVid));
    }
  });
  $('.m-video_btnPlay').on('click', function (e) {
    e.preventDefault();
    var frame = $(this).closest('.m-video_thumbnail'),
      linkVid = frame.data('link');
    $(this).fadeOut();
    if (linkVid.indexOf('vimeo') > -1) {
      frame.append(vimeo_iframe(linkVid));
    } else {
      frame.append(youtube_iframe(linkVid));
    }
  });
}

/**
 * Investment Knowledge (Kiến thức đầu tư)
 * news slider
 */

function knowledge_news_slider() {
  var $block = $('.p-investmentKnowledge_news_slide');
  $block.on('init', function () {
    $('.m-cardContent_content_title').matchHeight();
    $('.m-cardContent_content_desc').matchHeight();
  });
  var options = {
    dots: false,
    arrows: true,
    autoplay: false,
    lazyLoad: 'ondemand',
    infinite: false,
    speed: 300,
    slidesToShow: 3,
    dotsClass: 'slick-dots__custom',
    responsive: [{
      breakpoint: 992,
      settings: {
        slidesToShow: 2
      }
    }, {
      breakpoint: 768,
      settings: {
        slidesToShow: 1,
        dots: true,
        arrows: false
      }
    }]
  };
  $block.slick(options);
}
function knowledge_detail_slider() {
  var $slider = $('.p-knowledgeDetail_news_slide');
  $slider.on('init', function () {
    $('.m-cardContent_content_title').matchHeight();
    $('.m-cardContent_content_desc').matchHeight();
  });
  $slider.slick({
    dots: false,
    arrows: true,
    autoplay: false,
    lazyLoad: 'ondemand',
    infinite: false,
    speed: 300,
    slidesToShow: 3,
    dotsClass: 'slick-dots__custom',
    responsive: [{
      breakpoint: 992,
      settings: {
        slidesToShow: 2
      }
    }, {
      breakpoint: 768,
      settings: {
        slidesToShow: 1,
        dots: true,
        arrows: false
      }
    }]
  });
}
function quanLyTaiKhoanSlider() {
  var options = {
    vertical: true,
    verticalSwiping: true,
    slidesToShow: 3,
    slidesToScroll: 3,
    infinite: false,
    dots: true,
    speed: 500,
    cssEase: 'linear',
    dotsClass: 'slick-dots__verticleSlider',
    arrows: true,
    prevArrow: '<a class="arrow--1 vertical arrow--prev" href="javascript:void(0)"><i class="arrow_carrot-up"></i></a>',
    nextArrow: '<a class="arrow--1 vertical arrow--next" href="javascript:void(0)"><i class="arrow_carrot-down"></i></a>'
  };
  var $el1 = $('.iboard-web-slide .slider .slider__inner');
  var $el2 = $('.web-trading-slide .slider .slider__inner');
  $el1.slick(options);
  $el2.slick(options);
  $('[data-toggle="tab"]').click(function () {
    if ($(this).attr('href') === '#iboard-web') {
      $el1.slick('refresh');
    }
    if ($(this).attr('href') === '#web-trading') {
      $el2.slick('refresh');
    }
  });
}

// HƯỚNG DẪN MỞ TÀI KHOẢN TRỰC TUYẾN
function runCounterHuongDanMoTaiKhoanSlider($slider) {
  if ($slider.length) {
    var currentSlide;
    var slidesCount;
    var updateSliderCounter = function updateSliderCounter(slick) {
      currentSlide = slick.slickCurrentSlide() + 1;
      slidesCount = slick.slideCount;
      $slider.find('.slider-current').text(currentSlide).slideDown();
    };
    $slider.on('init', function (event, slick) {
      $slider.animate({
        opacity: 1
      }, 350);
      currentSlide = slick.slickCurrentSlide() + 1;
      slidesCount = slick.slideCount;
      $slider.find('.slider-current').text(currentSlide);
      $slider.find('.slider-length').text(slidesCount);
    });
    $slider.on('beforeChange', function (event, slick, currentSlide) {
      $slider.find('.slider-current').slideUp(450, function () {
        updateSliderCounter(slick, currentSlide);
      });
    });
  }
}
function runHuongDanMoTaiKhoanSlider($slider) {
  if ($slider.length) {
    var options = {
      infinite: true,
      slidesToShow: 1,
      slidesToScroll: 1,
      arrows: true,
      prevArrow: '<a class="arrow--1 motaikhoan arrow--prev" href="javascript:void(0)"><i class="arrow_carrot-left"></i></a>',
      nextArrow: '<a class="arrow--1 motaikhoan arrow--next" href="javascript:void(0)"><i class="arrow_carrot-right"></i></a>'
    };
    runCounterHuongDanMoTaiKhoanSlider($slider);
    $slider.slick(options);
  }
}
function huongDanMoTaiKhoanSlider() {
  var $s1 = $('#buoc-1 .slider-cac-buoc-thuc-hien__inner');
  var $s2 = $('#buoc-2 .slider-cac-buoc-thuc-hien__inner');
  var $s3 = $('#buoc-3 .slider-cac-buoc-thuc-hien__inner');
  var $s4 = $('#buoc-1-xac-thuc .slider-cac-buoc-thuc-hien__inner');
  var $s5 = $('#buoc-2-xac-thuc .slider-cac-buoc-thuc-hien__inner');
  var $s6 = $('#buoc-3-xac-thuc .slider-cac-buoc-thuc-hien__inner');
  runHuongDanMoTaiKhoanSlider($s1);
  runHuongDanMoTaiKhoanSlider($s2);
  runHuongDanMoTaiKhoanSlider($s3);
  runHuongDanMoTaiKhoanSlider($s4);
  runHuongDanMoTaiKhoanSlider($s5);
  runHuongDanMoTaiKhoanSlider($s6);
  $('[data-toggle="tab"]').click(function () {
    var href = $(this).attr('href');
    if (href === '#buoc-1') {
      if ($s1) {
        $s1.slick('destroy');
        runHuongDanMoTaiKhoanSlider($s1);
      }
    }
    if (href === '#buoc-2') {
      if ($s2) {
        $s2.slick('destroy');
        runHuongDanMoTaiKhoanSlider($s2);
      }
    }
    if (href === '#buoc-3') {
      if ($s3) {
        $s3.slick('destroy');
        runHuongDanMoTaiKhoanSlider($s3);
      }
    }
    if (href === '#buoc-1-xac-thuc') {
      if ($s4) {
        $s4.slick('destroy');
        runHuongDanMoTaiKhoanSlider($s4);
      }
    }
    if (href === '#buoc-2-xac-thuc') {
      if ($s5) {
        $s5.slick('destroy');
        runHuongDanMoTaiKhoanSlider($s5);
      }
    }
    if (href === '#buoc-3-xac-thuc') {
      if ($s6) {
        $s6.slick('destroy');
        runHuongDanMoTaiKhoanSlider($s6);
      }
    }
  });
}
function clickDropdownNganHangHDNopTien() {
  $('.drop-right__nganHangs .dropdown-item').click(function () {
    var data = $(this).attr('data-value');
    var str = 'background: url(\'' + data + '\') no-repeat center / contain';
    var bankBlock = $(this).parents('.bank-block');
    bankBlock.next('.box-huong-dan-nop-tien').find(' .box-huong-dan-nop-tien__icon .img-bg').attr('style', str);
    bankBlock.find('.drop-right__nganHangs .dropdown-toggle').text($(this).text());
  });
}

// validation FORM
function validationForm() {
  var validobj = null;
  //Email validation
  $.validator.addMethod('i_mail', function (value, element) {
    return this.optional(element) || /^[a-zA-Z0-9._-]+@[a-zA-Z0-9-]+\.[a-zA-Z.]{2,5}$/i.test(value);
  }, 'Please enter a valid email address.');
  $.fn.ui_form_validate = function () {
    return this.each(function () {
      var $form = $(this),
        options = {
          ignore: '.ignore-valid'
        };
      var funcHightlight = function funcHightlight(el, erClass) {
        var $el = $(el);
        $el.addClass(erClass);
        if ($el.hasClass('at-least')) {
          $el.closest('.form-input-multi').addClass(erClass);
        }
        var elem = $(el);
        if (elem.hasClass('select2-offscreen')) {
          $('#s2id_' + elem.attr('id') + ' ul').addClass(erClass);
        } else {
          elem.addClass(erClass);
        }
      };
      options.highlight = funcHightlight;
      options.unhighlight = function (el, erClass) {
        var $el = $(el);
        $el.removeClass(erClass);
        if ($el.hasClass('at-least')) {
          $el.closest('.form-input-multi').removeClass(erClass);
        }
        var elem = $(el);
        if (elem.hasClass('select2-offscreen')) {
          $('#s2id_' + elem.attr('id') + ' ul').removeClass(erClass);
        } else {
          elem.removeClass(erClass);
        }
      };
      options.errorPlacement = function (er, el) {
        if (el.hasClass('at-least')) {
          var $input_multi = el.closest('.form-input-multi');
          if ($input_multi.length > 0) {
            er.addClass('for-at-least').insertAfter($input_multi);
          }
          return;
        } else if ($(el).hasClass('select-ui')) {
          er.insertAfter($(el).next());
        } else er.insertAfter(el);
      };
      options.invalidHandler = function () {
        $form.isHightLightTab = true;
      };
      validobj = $form.validate(options);
      var $recaptcha = $form.find('.g-recaptcha');
      if ($recaptcha.length > 0) {
        $form.on('submit', function (e) {
          if (!$recaptcha.data('captcha-ok')) {
            e.preventDefault();
            if ($('#captcha-error').length > 0) {
              return;
            }
            $recaptcha.append('<div id=\'captcha-error\' class=\'error label\'>CAPTCHA là bắt buộc</div>');
          } else {
            $('#captcha-error').remove();
          }
        });
      }
    });
  };
  $('.form-validate').ui_form_validate();
  $('.o-popup').on('hide.bs.modal', function () {
    if ($('.form-validate').length > 0) {
      $('.form-validate').trigger('reset');
    }
    if ($('label.error').length > 0) {
      $('label.error').remove();
    }
    if ($('.select-ui').length > 0) {
      $('.select-ui').val(null).trigger('change');
    }
  });
  $(document).on('change', '.select2-offscreen', function () {
    if (!$.isEmptyObject(validobj.submitted)) {
      validobj.form();
    }
  });
  $('.select-ui').on('change', function (e) {
    $('.select2-drop ul').removeClass('myErrorClass');
  });
  $(document).on('select2-opening', function (arg) {
    var elem = $(arg.target);
    if ($('#s2id_' + elem.attr('id') + ' ul').hasClass('myErrorClass')) {
      //jquery checks if the class exists before adding.
      $('.select2-drop ul').addClass('myErrorClass');
    } else {
      $('.select2-drop ul').removeClass('myErrorClass');
    }
  });
}
window.addEventListener('load', function () {
  var emailField = document.getElementById('emailFooter');
  var phoneField = document.getElementById('phoneFooter');
  emailField.addEventListener('keyup', function () {
    if (emailField.value === '') {
      $('#emailFooter-error').hide('fast');
    }
  });
  phoneField.addEventListener('keyup', function () {
    if (phoneField.value === '') {
      $('#phoneFooter-error').hide('fast');
    }
  });
});

/**
 * =============INIT FUNTION=============
 */
function init() {
  // Select UI
  $.fn.select2.defaults.set('width', '100%');
  $('.select-ui').each(function () {
    var el = $(this);
    var selectUI = el.select2({
      placeholder: el.data('placeholder'),
      minimumResultsForSearch: el.hasClass('searchable') ? 0 : 30,
      dropdownParent: el.parent('div'),
      width: 'resolve'
    });

    // Update UI Scroll - Open dropdown
    selectUI.on('select2:open', function (e) {
      var list = $(this).next().next().find('.select2-results__options');
      var idSelect = list.attr('id');
      $(this).delay(0.0001).queue(function (next) {
        // new SimpleBar($('#' + idSelect)[0])
        $('#' + idSelect).niceScroll({
          cursorcolor: '#d4d4d4',
          cursorwidth: '2px',
          cursorborder: 'none',
          cursorborderradius: 0,
          background: 'rgba(255,255,255,0.1)'
        });
        next();
      });
    });
  });
  $('.select2-ui').each(function () {
    var el = $(this);
    var selectUI = el.select2({
      placeholder: el.data('placeholder'),
      minimumResultsForSearch: 30,
      width: 'resolve'
    });

    // Update UI Scroll - Open dropdown
    selectUI.on('select2:open', function (e) {
      var list = $(this).next().next().find('.select2-results__options');
      var idSelect = list.attr('id');
      $(this).delay(0.0001).queue(function (next) {
        // new SimpleBar($('#' + idSelect)[0])
        $('#' + idSelect).niceScroll({
          cursorcolor: '#d4d4d4',
          cursorwidth: '2px',
          cursorborder: 'none',
          cursorborderradius: 0,
          background: 'rgba(255,255,255,0.1)'
        });
        next();
      });
    });
  });

  // Range UI
  // $('.range-ui').each(function(key){
  //     var el = $(this);
  //     el.attr({'id':'range-ui-' + key}).queue(function(next){
  //         $("#range-ui-" + key).ionRangeSlider();
  //         next();
  //     });
  // });

  // Scroll
  $('.scroll-ui, .prizeSlide__item .info').each(function (key) {
    var el = $(this);
    el.attr({
      id: 'scroll-ui-' + key
    }).queue(function (next) {
      new SimpleBar($('#' + el.attr('id'))[0]);
      next();
    });
  });

  // File Browse UI
  $('.file-ui .file-ui-input').change(function (e) {
    if (typeof e.target.files[0] !== 'undefined') {
      var fileName = e.target.files[0].name;
      $(this).next('.file-ui-label').text(fileName);
    }
  });
  // ❌ [CONFIRM ĐỂ XOÁ]
  // Slider Gallery
  function sliderGallery() {
    var _settings, _settings2;
    $('.culturalGallery__inner').slick({
      prevArrow: '<a class="arrow--1 arrow--prev" href="javascript:void(0)"><i class="arrow_triangle-left"></i></a>',
      nextArrow: '<a class="arrow--1 arrow--next" href="javascript:void(0)"><i class="arrow_triangle-right"></i></a>',
      infinite: true,
      speed: 300,
      slidesToScroll: 1,
      variableWidth: true,
      centerMode: true,
      centerPadding: '0',
      draggable: false,
      focusOnSelect: true,
      responsive: [{
        breakpoint: 992,
        settings: (_settings = {
          slidesToShow: 1
        }, _defineProperty(_settings, "slidesToShow", 1), _defineProperty(_settings, "variableWidth", false), _defineProperty(_settings, "centerMode", false), _settings)
      }]
    });
    $('.culturalVideo__inner').slick({
      prevArrow: '<a class="arrow--1 arrow--prev" href="javascript:void(0)"><i class="arrow_triangle-left"></i></a>',
      nextArrow: '<a class="arrow--1 arrow--next" href="javascript:void(0)"><i class="arrow_triangle-right"></i></a>',
      infinite: true,
      speed: 300,
      slidesToScroll: 1,
      variableWidth: true,
      centerMode: true,
      centerPadding: '0',
      draggable: false,
      focusOnSelect: true,
      responsive: [{
        breakpoint: 992,
        settings: (_settings2 = {
          slidesToShow: 1
        }, _defineProperty(_settings2, "slidesToShow", 1), _defineProperty(_settings2, "variableWidth", false), _defineProperty(_settings2, "centerMode", false), _settings2)
      }]
    });
    $('.sliderPost__inner').slick({
      prevArrow: '<a class="arrow--1 arrow--prev" href="javascript:void(0)"><i class="arrow_triangle-left"></i></a>',
      nextArrow: '<a class="arrow--1 arrow--next" href="javascript:void(0)"><i class="arrow_triangle-right"></i></a>',
      infinite: true,
      speed: 300,
      slidesToScroll: 1,
      variableWidth: true,
      centerMode: true,
      centerPadding: '0',
      draggable: false,
      focusOnSelect: true,
      responsive: [{
        breakpoint: 992,
        settings: {
          slidesToShow: 1,
          variableWidth: false,
          centerMode: false
        }
      }]
    });
  }

  // ❌ [CONFIRM ĐỂ XOÁ]
  function clickShowSocial() {
    var share = $('.share');
    share.click(function (e) {
      e.preventDefault();
      e.stopPropagation();
      var el = $(this);
      if (el.siblings('.handle__social').hasClass('active')) {
        el.siblings('.handle__social').removeClass('active');
      } else {
        $('.handle__social').removeClass('active');
        el.siblings('.handle__social').addClass('active');
      }
    });
    share.siblings('.handle__social').bind('click', function (e) {
      e.stopPropagation();
    });
    $(document).click(function (event) {
      share.siblings('.handle__social').removeClass('active');
    });
  }

  // ❌ [CONFIRM ĐỂ XOÁ]
  $('#accordionExample').on('shown.bs.collapse', function (e) {
    $('html, body').animate({
      scrollTop: $('#' + e.target.id).parents('.card').offset().top - 80
    }, 600);
  });

  // slider banner
  function sliderBanner() {
    $('.template-banner').slick({
      dots: true,
      infinite: true,
      arrows: false,
      speed: 500,
      autoplaySpeed: 5000,
      autoplay: true,
      cssEase: 'linear',
      dotsClass: 'slick-dots__custom'
    });
    $('.template-banner').on('beforeChange', function () {
      sSSIIBoard();
    });
  }

  //Tong quan thi truong: Trai phieu
  function marketOverviewBondSlider() {
    var $slider = $('.p-marketOverview_bond_list_slider');
    $slider.on('init', function () {
      $('.p-marketOverview_bond_list_content').matchHeight();
    });
    $slider.slick({
      dots: false,
      arrows: false,
      slidesToShow: 3,
      infinite: false,
      dotsClass: 'slick-dots__custom',
      responsive: [{
        breakpoint: 992,
        settings: {
          slidesToShow: 2,
          dots: true
        }
      }, {
        breakpoint: 768,
        settings: {
          slidesToShow: 1,
          dots: true
        }
      }]
    });
  }

  // ❌ [CONFIRM ĐỂ XOÁ]
  // WHY PRODUCT SLIDER
  function reasonProductSlider() {
    $('.o-tabs_label').on('shown.bs.tab', function () {
      $('.o-investmentReason_list').slick('setPosition');
      $('.o-investmentReason_wrap').matchHeight();
    });
    $('.o-investmentReason_list').each(function (i, val) {
      var $it = $(val);
      $it.slick({
        dots: true,
        arrows: false,
        speed: 500,
        cssEase: 'linear',
        slidesToShow: 3,
        infinite: false,
        dotsClass: 'slick-dots__custom',
        responsive: [{
          breakpoint: 992,
          settings: {
            slidesToShow: 2
          }
        }, {
          breakpoint: 768,
          settings: {
            slidesToShow: 1
          }
        }]
      });
    });
  }

  // ❌ [CONFIRM ĐỂ XOÁ]
  function auto_match_height() {
    $('.o-investmentReason_wrap').matchHeight();
  }
  function chooseAccountManagement() {
    var chooseSelectIboardWeb = $('.iboard-web-slide .chooseAccountManagement__select select');
    chooseSelectIboardWeb.on('change', function () {
      var act = $(this).val();
      $('.iboard-web-slide .chooseAccountManagement__content__item').removeClass('active');
      $('.iboard-web-slide .chooseAccountManagement__content__item[data-select="' + act + '"]').addClass('active');
    });
    var chooseSelectWebTradingSlide = $('.web-trading-slide .chooseAccountManagement__select select');
    chooseSelectWebTradingSlide.on('change', function () {
      var act = $(this).val();
      $('.web-trading-slide .chooseAccountManagement__content__item').removeClass('active');
      $('.web-trading-slide .chooseAccountManagement__content__item[data-select="' + act + '"]').addClass('active');
    });
  }
  function googlemap_ui() {
    var $mapdiv = $('#google-map-div');
    if ($mapdiv.length < 1) return;
    var json = $mapdiv.data('json');
    var map, latlng;
    var initMap = function initMap() {
      var zZoom = $(window).width() < 768 ? 12 : 16;
      latlng = new google.maps.LatLng(json.location);
      var myOptions = {
        zoom: zZoom,
        center: latlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP,
        draggable: true,
        zoomControl: true,
        scrollwheel: false,
        disableDoubleClickZoom: false
      };
      map = new google.maps.Map($mapdiv[0], myOptions);
      new google.maps.Marker({
        position: latlng,
        map: map
      });

      // run file googlemap
    };
    // $('#google-map').attr('src', $('#google-map').attr('data-src'));
    // $('#google-map').on('load', initMap);
    initMap();
  }
  function initOpenCollapsed() {
    if ($('.p-riskPolicy').length < 1) return;
    var hash = window.location.hash;
    var $hashButton = $("button.btn-card.collapsed[data-target=\"".concat(hash, "\"]"));
    if (!$hashButton) return;
    $hashButton.trigger('click');
    setTimeout(function () {
      $('html, body').animate({
        scrollTop: $hashButton.offset().top - 80
      }, 600);
    }, 800);
    $('button.btn-card').on('click', function (e) {
      var $it = $(e.currentTarget);
      var target = $it.data('target');
      if (target) {
        history.pushState({}, '', target);
      }
    });
  }

  // SO SANH CHUNG QUYEN SLIDER
  function compareWarrantsBannerSlider() {
    $('.p-compare-warrants_slider ').slick({
      dots: true,
      infinite: true,
      arrows: false,
      speed: 300,
      slidesToShow: 1,
      pauseOnHover: false,
      autoplay: true,
      autoplaySpeed: 5500,
      lazyLoad: 'ondemand'
    });
  }
  function ui_chart() {
    $('.ui-chart-pie').each(function () {
      var pie = [{
        align: String,
        verticalAl: String,
        sizePie: Int32Array,
        centerPie: [],
        x: String,
        y: String
      }];
      pie.align = 'middle';
      pie.verticalAl = 'bottom';
      pie.sizePie = 200;
      pie.centerPie = ['50%', '40%'];
      pie.x = 0;
      pie.y = 0;
      var datajson = $(this).data('json');
      $(this).highcharts({
        chart: {
          plotBackgroundColor: null,
          plotBorderWidth: null,
          plotShadow: false,
          type: 'pie',
          height: 300
        },
        legend: {
          layout: 'vertical',
          align: 'right',
          verticalAlign: 'middle',
          itemMarginTop: 10,
          itemMarginBottom: 10
        },
        events: {
          load: function load() {
            var series = this.series[0];
            var points = series.data;
            points.forEach(function (point) {
              if (point.y <= 4) {
                var myOffset = 50;
                var _point$dataLabel$attr = point.dataLabel.attr(),
                  x = _point$dataLabel$attr.x,
                  y = _point$dataLabel$attr.y;
                var angle = point.angle;
                point.dataLabel.attr({
                  x: x + Math.cos(angle) * myOffset,
                  y: y + Math.sin(angle) * myOffset
                });
              }
            });
          }
        },
        tooltip: {
          pointFormat: '<b>{point.percentage:.1f}%</b>'
        },
        title: {
          text: 'Thị phần giao dịch',
          align: 'left'
        },
        credits: {
          enabled: false
        },
        plotOptions: {
          pie: {
            showInLegend: true,
            allowPointSelect: true,
            cursor: 'pointer',
            center: pie.centerPie,
            dataLabels: {
              enabled: true,
              distance: -40,
              formatter: function formatter() {
                return this.y + '%';
              }
            },
            size: pie.sizePie
          }
        },
        series: [{
          name: 'Pool',
          data: datajson
        }],
        responsive: {
          rules: [{
            condition: {
              maxWidth: 768
            },
            chartOptions: {
              chart: {
                height: 220
              },
              plotOptions: {
                pie: {
                  dataLabels: {
                    style: {
                      fontSize: '8px'
                    }
                  },
                  size: 150
                }
              }
            }
          }]
        }
      });
    });
  }
  function extendTable_btn() {
    var $btnExtend = $('.btn-extends-table');
    $btnExtend.on('click', function (e) {
      var $it = $(e.currentTarget);
      $it.toggleClass('extend');
    });
  }

  // ❌ [CONFIRM ĐỂ XOÁ]
  // click show Social
  clickShowSocial();

  // ❌ [CONFIRM ĐỂ XOÁ]
  // Image SVG
  imgSVG();

  // ❌ [CONFIRM ĐỂ XOÁ]
  // Load nav search
  navSearch();

  // Banner - home page
  bannerSlider();

  // Go to top - layout
  gotoTop();

  // Waypoint - home page
  waypointEl();

  // header - layout
  outviewHeader();

  // Navigation Sidebar
  navSidebar();

  // Image Zoom
  imgZoom();

  // More/Less Content
  moreLess();

  //history
  history1();

  //giaithuong
  prize();
  showMenuChild();
  getValuedropdown();
  sliderGallery();

  //quan he nha dau tu
  historyOther();

  //thanh tuu va giai thuong
  historyOther1();
  historyOther2();

  // // Annals Fillter
  // annalsFillter();

  // Hot news
  hotNews();

  // Navigation Widget
  navWidget();

  //contact page
  infoContact();

  // // call datepicker
  // callDatepicker();

  //Mobile Menu
  mobileMenu();
  //tab links
  tabLinks();
  // Slider partner
  sliderPartner();
  // Slider Customer
  sliderCustomer();
  // Slider Banner
  sliderBanner();
  // register();
  // chooseMap();

  sliderNotifyList();
  journeySlide();
  customBanner();
  initTabsJourSlide();
  counterNumber();
  reasonProductSlider();
  auto_match_height();

  // HƯỚNG DẪN MỞ TÀI KHOẢN - open-account page
  video_control();
  knowledge_news_slider();
  knowledge_detail_slider();

  // HƯỚNG DẪN SỬ DỤNG - web-trading page
  quanLyTaiKhoanSlider();
  validationForm();

  // HƯỚNG DẪN MỞ TÀI KHOẢN TRỰC TUYẾN
  // buoc1thucHienMoTaiKhoanSlider();
  // buoc2TaoYeuCauMoTaiKhoanSlider();
  // buoc3BoSungThongTinCaNhanSlider();
  huongDanMoTaiKhoanSlider();
  // Dropdown chọn ngân hàng - HƯỚNG DẪN NỘP TIỀN
  clickDropdownNganHangHDNopTien();
  marketOverviewBondSlider();
  chooseAccountManagement();
  initOpenCollapsed();
  googlemap_ui();
  alignMenuCenter();
  compareWarrantsBannerSlider();
  ui_chart();
  extendTable_btn();
}
$(window).on('load', init);
$('body').imagesLoaded(function () {
  $('body').addClass('loaded');
  $('.pageLoad').fadeOut();
});
$('.p-knowledgeDetail_content iframe').wrap('<div class=\'p-knowledgeDetail_content_iframe\'></div>');
$('table').wrap('<div class=\'m__table__inner\'></div>');
"use strict";

/* global Highcharts */
(function ($) {
  Number.prototype.format = function (n, x, s, c) {
    var re = "\\d(?=(\\d{" + (x || 3) + "})+" + (n > 0 ? "\\D" : "$") + ")",
      num = this.toFixed(Math.max(0, ~~n));
    return (c ? num.replace(".", c) : num).replace(new RegExp(re, "g"), "$&" + (s || ","));
  };

  // PLUGIN: HELPER run chart bar - vertical

  $.fn.chart_bar_vertical = function () {
    var $chart = this;
    if ($chart.length < 1) {
      return;
    }
    $chart.each(function () {
      var $this = $(this),
        target = $this[0],
        json = $this.data("json"),
        listTile = [],
        listValue = [],
        listColor = [],
        maxValue = 0,
        lang = $this.data("lang");
      json.map(function (x) {
        listTile.push(x.name);
        listValue.push(x.value);
        maxValue = maxValue < x.value ? x.value : maxValue;
        listColor.push(x.color ? x.color : "#F5A01A");
      });
      Highcharts.chart(target, {
        // colors: ['#F5A01A', '#8085e9', '#8d4654', '#7798BF', '#aaeeee'],
        chart: {
          type: "bar",
          backgroundColor: "#f5f5f5",
          style: {
            fontFamily: "Arial, serif"
          },
          spacingLeft: 20,
          spacingRight: 30
        },
        title: {
          text: ""
        },
        subtitle: {
          text: ""
        },
        responsive: true,
        xAxis: {
          categories: listTile,
          title: {
            text: null
          },
          lineWidth: 1,
          lineColor: "#707070"
        },
        yAxis: {
          title: null,
          tickInterval: 10,
          tickWidth: 1,
          tickLength: 4,
          tickColor: "#707070",
          labels: {
            align: "center",
            overflow: "allow",
            format: "{value}%"
          },
          gridLineWidth: 0,
          lineWidth: 1,
          lineColor: "#707070",
          max: maxValue + 3
        },
        tooltip: false,
        //{ valueSuffix: '%' },
        plotOptions: {
          bar: {
            dataLabels: {
              enabled: true,
              formatter: function formatter() {
                return lang == "vi" ? this.y.format(1, 3, ".", ",") + "%" : this.y.format(1, 3) + "%";
              }
            },
            //'{point.y:.1f}%'
            shadow: false,
            colorByPoint: true,
            colors: listColor
          }
        },
        legend: false,
        credits: {
          enabled: false
        },
        series: [{
          name: "",
          data: listValue
        }],
        navigation: {
          buttonOptions: {
            enabled: false
          }
        }
      });
    });
    return this;
  };

  // PLUGIN: HELPER run chart line - compare

  $.fn.chart_line_compare = function (config_event) {
    var $chart = this;
    if ($chart.length < 1) {
      return;
    }
    $chart.each(function () {
      var $this = $(this),
        target = $this[0],
        json1 = $this.data("json-line-1"),
        json2 = $this.data("json-line-2"),
        json3 = $this.data("json-line-3"),
        json_column = $this.data("json-column"),
        lang = $(this).data("lang");
      var options = {
        colors: ["#0081C6", "#F5A01A", "#0081C6", "#7798BF", "#aaeeee"],
        chart: {
          backgroundColor: "#f5f5f5",
          style: {
            fontFamily: "Arial, serif"
          },
          marginRight: 40
        },
        title: {
          text: ""
        },
        subtitle: {
          text: ""
        },
        xAxis: {
          labels: {
            format: "{value:%m/%Y}"
          },
          units: [["month"]]
        },
        yAxis: {
          labels: {
            formatter: function formatter() {
              return (this.value > 0 ? " + " : "") + this.value + "%";
            },
            x: 35
          },
          plotLines: [{
            value: 0,
            width: 2,
            color: "silver"
          }]
        },
        tooltip: {
          valueDecimals: 2,
          // headerFormat: '<span style="font-size:12px;font-weight:400;padding-bottom:5px;">{point.x:%d/%m/%Y}</span><br/>',
          xDateFormat: "%Y-%m-%d",
          shared: false,
          split: false,
          followPointer: false,
          // pointFormat: '<span style="color:{point.color}">\u25CF</span> {series.name}: <b>{point.y}</b><br/>',
          formatter: function formatter() {
            var d = new Date(this.point.x),
              data_keep = $this.data("series"),
              point_y = this.point.y;
            if (data_keep && data_keep[this.point.colorIndex] && data_keep[this.point.colorIndex].data[this.point.index]) {
              // console.log(this.point.index, this.point.colorIndex, data_keep[this.point.colorIndex].data[this.point.index]);
              if (data_keep[this.point.colorIndex].data[this.point.index][2]) {
                point_y = data_keep[this.point.colorIndex].data[this.point.index][2];
              }
            }
            data_keep = null;
            return "<span style=\"font-size:12px;font-weight:400;padding-bottom:5px;\">" + (d.getDate() < 10 ? "0" + d.getDate() : d.getDate()) + "/" + (d.getMonth() < 9 ? "0" + (d.getMonth() + 1) : d.getMonth() + 1) + "/" + d.getFullYear() + "</span><br/>" + "<span style=\"color:" + this.point.color + "\">" + this.series.name + ": </span> <b>" + (lang == "vi" ? point_y.format(1, 3, ".", ",") : point_y.format(1, 3)) + "</b><br/>";
          }
        },
        legend: {
          enabled: true,
          align: "center",
          layout: "horizontal",
          verticalAlign: "bottom",
          y: 0,
          margin: 30,
          squareSymbol: true,
          symbolPadding: 10,
          symbolWidth: 50,
          symbolRadius: 0,
          itemStyle: {
            fontSize: "14px"
          },
          itemDistance: 40
        },
        credits: {
          enabled: false
        },
        // series: data_series,
        navigation: {
          buttonOptions: {
            enabled: false
          }
        },
        navigator: {
          maskFill: "rgba(45, 179, 215, 0.4)"
        },
        rangeSelector: {
          allButtonsEnabled: true,
          selected: 0,
          buttons: [{
            type: "month",
            count: 1,
            text: "1 tháng",
            id: 0
          }, {
            type: "month",
            count: 3,
            text: "3 tháng",
            id: 1
          }, {
            type: "month",
            count: 6,
            text: "6 tháng",
            id: 2
          }, {
            type: "ytd",
            text: "YTD",
            id: 3
          }, {
            type: "year",
            count: 1,
            text: "1 năm",
            id: 4
          }, {
            type: "all",
            text: "Tất cả",
            id: 5
          }],
          buttonTheme: {
            width: 50
          },
          inputDateFormat: "%d-%m-%Y",
          inputEditDateFormat: "%d-%m-%Y",
          inputDateParser: function inputDateParser(value) {
            value = value.split(/[\-]/);
            return Date.UTC(parseInt(value[2]), parseInt(value[1]) - 1, parseInt(value[0]));
          }
        },
        plotOptions: {
          line: {
            events: {
              legendItemClick: function legendItemClick() {
                return false;
              }
            }
          },
          column: {
            events: {
              legendItemClick: function legendItemClick() {
                return false;
              }
            }
          }
        }
      };
      if (config_event) {
        options.chart.events = config_event;
      }
      var data_series = [json1];
      json1.type = "line";
      if (json2) {
        json2.type = "line";
        data_series.push(json2);
      }
      if (json3) {
        json3.type = "line";
        data_series.push(json3);
      }
      if (json_column) {
        json_column.type = "column";
        json_column.yAxis = 1;
        data_series.push(json_column);
        options.chart.marginRight = null;
        options.yAxis = [{
          labels: {
            align: "left"
          },
          height: "75%",
          resize: {
            enabled: true
          }
        }, {
          labels: {
            align: "left"
          },
          top: "75%",
          height: "25%",
          offset: 0
        }];
      } else {
        options.plotOptions = {
          series: {
            compare: "percent",
            pointStart: Date.UTC(2012, 0, 1),
            pointInterval: 24 * 3600 * 1000
          },
          line: {
            events: {
              legendItemClick: function legendItemClick() {
                return false;
              }
            }
          },
          column: {
            events: {
              legendItemClick: function legendItemClick() {
                return false;
              }
            }
          }
        };
      }
      options.series = data_series;
      Highcharts.stockChart(target, options);
    });
    return this;
  };

  // PLUGIN: HELPER run chart pie
  $.fn.chart_pie = function () {
    var $chart = this;
    if ($chart.length < 1) {
      return;
    }
    $chart.each(function () {
      var $this = $(this),
        target = $this[0],
        json = $this.data("json"),
        lang = $(this).data("lang");
      Highcharts.chart(target, {
        colors: ["#984906", "#B2DF8A", "#E46C0B", "#7798BF", "#aaeeee"],
        chart: {
          type: "pie",
          backgroundColor: "#f5f5f5",
          style: {
            fontFamily: "Arial, serif"
          }
        },
        title: {
          text: ""
        },
        subtitle: {
          text: ""
        },
        credits: {
          enabled: false
        },
        tooltip: {
          formatter: function formatter() {
            return this.point.name + ": <b>" + (lang == "vi" ? this.point.percentage.format(1, 3, ".", ",") : this.point.percentage.format(1, 3)) + "%</b>";
          }
        },
        legend: {
          align: "right",
          verticalAlign: "middle",
          layout: "vertical",
          itemMarginBottom: 20,
          symbolHeight: 12,
          symbolWidth: 12,
          symbolRadius: 0,
          itemStyle: {
            textOverflow: ""
          }
        },
        plotOptions: {
          pie: {
            allowPointSelect: false,
            cursor: "pointer",
            dataLabels: {
              enabled: true,
              formatter: function formatter() {
                return (lang == "vi" ? this.point.percentage.format(1, 3, ".", ",") : this.point.percentage.format(1, 3)) + "%";
              },
              distance: -50,
              filter: {
                property: "percentage",
                operator: ">",
                value: 4
              },
              style: {
                fontSize: "16px"
              }
            },
            showInLegend: true,
            size: $this.hasClass("small") ? 200 : 324
          },
          series: {
            point: {
              events: {
                legendItemClick: function legendItemClick() {
                  return false;
                }
              }
            }
          }
        },
        series: [{
          name: null,
          colorByPoint: true,
          data: json
        }],
        responsive: {
          rules: [{
            condition: {
              callback: function callback() {
                return $(window).width() < 992;
              }
            },
            chartOptions: {
              chart: {
                marginRight: 0
              },
              plotOptions: {
                pie: {
                  size: 200
                }
              },
              legend: {
                align: "center",
                verticalAlign: "bottom"
              }
            }
          }, {
            condition: {
              callback: function callback() {
                return $this.width() < 360;
              }
            },
            chartOptions: {
              legend: {
                itemWidth: 100
              }
            }
          }]
        }
      });
    });
  };
  function ui_videobox_withjs() {
    var youtube_parser = function youtube_parser(url) {
      var regExp = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
      var match = url.match(regExp);
      return "<iframe src=\"https://www.youtube.com/embed/" + (match && match[7].length == 11 ? match[7] : false) + "?autoplay=1&controls=0&disablekb=1&enablejsapi=1&loop=1&modestbranding=1&playsinline=1&color=white\"  frameborder=\"0\" allowfullscreen allow=\"autoplay\"></iframe>";
    };
    var vimeo_parser = function vimeo_parser(url) {
      var m = url.match(/^.+vimeo.com\/(.*\/)?([^#\?]*)/);
      return "<iframe src=\"https://player.vimeo.com/video/" + (m ? m[2] || m[1] : null) + "?autoplay=1&title=0&byline=0&portrait=0&rel=0\" frameborder=\"0\" allow=\"autoplay\" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>";
    };
    $(".videoBox.with-js .btn-play").on("click", function (e) {
      var $this = $(this),
        $videoBox = $this.closest(".videoBox"),
        link = $videoBox.data("src");
      e.preventDefault();
      $videoBox.addClass("showvideo");
      if (link.indexOf("vimeo") > -1) {
        $videoBox.append(vimeo_parser(link));
      } else {
        $videoBox.append(youtube_parser(link));
      }
    });
  }
  function ui_form_tinh_toan_dong_tien() {
    $("#tenquy").on("select2:select", function (e) {
      $("#tenquyunit").text(e.params.data.text);
    });
  }
  function ui_has_hyperlink_smooth() {
    var $content = $(".has-hyperlink-smooth");
    if ($content.length < 1) {
      return;
    }
    $content.find("a[href^=\"#\"]").on("click", function (e) {
      var $a = $(this),
        $anchor = $("a[name='".concat($a.attr("href").substring(1), "']"));
      if ($anchor.length < 1) {
        return;
      }
      e.preventDefault();
      $("html, body").animate({
        scrollTop: $anchor.offset().top - 5
      }, 800);
    });
  }
  $(function () {
    ui_videobox_withjs();
    ui_form_tinh_toan_dong_tien();
    ui_has_hyperlink_smooth();
    $(".chart-bar-vertical").chart_bar_vertical();
    // $('.chart-line-compare').chart_line_compare({ render: () => { console.log("ok") } });
    $(".chart-pie").chart_pie();
  });
})(jQuery);