<!DOCTYPE html>
<html class="no-js" lang="en">

<head>
    @include('site.partials.head')

    <style>
        .navbar-brand-ssi-am img {
            height: 4.1em;
            margin-top: 0.432em;
        }
        .navbar-brand-ssi-am {
            position: relative;
            z-index: 2;
            /* display: inline-block; */
            margin-top: .92857em;
            transition-delay: .15s;
            transition: all .2s ease-in-out;
        }

        @media (max-width: 991px) {
            .navbar-brand-ssi-am {
                margin-top: .71429em
            }
            .navbar-brand-ssi-am img {
                height: 3.21429em;
                margin-top: 0.8em;
            }
        }
    </style>


    @yield('css')
</head>

<body ng-app="App">
@include('site.partials.header')

<main class="wrapper">
    @yield('content')
</main>
@include('site.partials.footer')



<script  src="/site/frontend/assets/js/jquery-3.3.1.min.js" ></script>

<script  src="/site/frontend/assets/js/home-main.js" ></script>

<script src="/site/cdn-cgi/scripts/7d0fa10a/cloudflare-static/rocket-loader.min.js"></script>

<script>
    (function () {
        function c() {
            var b = a.contentDocument || a.contentWindow.document;
            if (b) {
                var d = b.createElement('script');
                d.innerHTML = "window.__CF$cv$params={r:'99066c386b610447',t:'MTc2MDc3MzU5NS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/site/cdn-cgi/challenge-platform/h/g/scripts/jsd/e9c9e9d67513/maind41d.js';document.getElementsByTagName('head')[0].appendChild(a);";
                b.getElementsByTagName('head')[0].appendChild(d)
            }
        }

        if (document.body) {
            var a = document.createElement('iframe');
            a.height = 1;
            a.width = 1;
            a.style.position = 'absolute';
            a.style.top = 0;
            a.style.left = 0;
            a.style.border = 'none';
            a.style.visibility = 'hidden';
            document.body.appendChild(a);
            if ('loading' !== document.readyState) c(); else if (window.addEventListener) document.addEventListener('DOMContentLoaded', c); else {
                var e = document.onreadystatechange || function () {
                };
                document.onreadystatechange = function (b) {
                    e(b);
                    'loading' !== document.readyState && (document.onreadystatechange = e, c())
                }
            }
        }
    })();</script>

    <script>
        var CSRF_TOKEN = "{{ csrf_token() }}";
        window.USER_AVATAR_URL = "{{ $customer->avatar->path ?? '/site/img/user.png' }}";
    </script>

    @include('site.partials.angular_mix')


    <script>
        app.controller('registerForm', function ($rootScope, $scope, $interval) {
            $scope.errors = [];
            $scope.errorsLogin = [];
            $scope.registerSubmit = function () {
                var url = "{{route('front.submitRegister')}}";
                var data = jQuery('#form-register').serialize();
                $scope.loading = true;
                jQuery.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: data,
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                            jQuery('#form-register')[0].reset();
                            window.location.href = response.redirect_url;
                            $scope.errors = [];
                        } else {
                            $scope.errors = response.errors;
                            toastr.error(response.message);
                        }
                    },
                    error: function () {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        $scope.loading = false;
                        $scope.$apply();
                    }
                });
            }

            $scope.submitLogin = function () {
                var url = "{{route('front.submitLogin')}}";
                var data = jQuery('#form-login').serialize();
                $scope.loading = true;
                jQuery.ajax({
                    type: 'POST',
                    url: url,
                    headers: {
                        'X-CSRF-TOKEN': CSRF_TOKEN
                    },
                    data: data,
                    success: function (response) {
                        if (response.success) {
                            toastr.success(response.message);
                            window.location.href = response.redirect_url;
                            $scope.errorsLogin = [];
                        } else {
                            $scope.errorsLogin = response.errors;
                            toastr.warning(response.message);
                        }
                    },
                    error: function () {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        $scope.loading = false;
                        $scope.$apply();
                    }
                });
            }

        })
    </script>

    <script>
        app.controller('headerPartial', function ($rootScope, $scope, cartItemSync, $interval, $window) {
            $scope.cart = cartItemSync;
            $scope.avatarPreviewUrl = window.USER_AVATAR_URL;

            $scope.incrementQuantity = function (product) {
                product.quantity = Math.min(product.quantity + 1, 9999);
            };

            $scope.decrementQuantity = function (product) {
                product.quantity = Math.max(product.quantity - 1, 0);
            };


            $scope.changeQty = function (qty, item) {
                updateCart(qty, item)
            }

            function updateCart(qty, item) {
                jQuery.ajax({
                    type: 'POST',
                    url: "{{route('cart.update.item')}}",
                    headers: {
                        'X-CSRF-TOKEN': "{{csrf_token()}}"
                    },
                    data: {
                        product_id: item.id,
                        variant_id: item.attributes.variant_id,
                        qty: qty
                    },
                    beforeSend: function() {
                        jQuery('.loading-spin').show();
                        // showOverlay();
                    },
                    success: function (response) {
                        if (response.success) {
                            $scope.items = response.items;
                            $scope.total = response.total;
                            $scope.countItem = response.count;

                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function(){
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);

                            $scope.$applyAsync();
                        }
                    },
                    error: function (e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        jQuery('.loading-spin').hide();
                        // hideOverlay();
                        $scope.$applyAsync();
                    }
                });
            }

            $scope.removeItem = function (post_id) {
                jQuery.ajax({
                    type: 'GET',
                    url: "{{route('cart.remove.item')}}",
                    data: {
                        post_id: post_id
                    },
                    success: function (response) {
                        if (response.success) {
                            $scope.items = response.items;
                            $scope.total = response.total;
                            if ($scope.total == 0) {
                                $scope.checkCart = false;
                            }

                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function(){
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);

                            $scope.countItem = response.count;

                            $scope.$applyAsync();
                        }
                    },
                    error: function (e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function () {
                        $scope.$applyAsync();
                    }
                });
            }



            $scope.search = function () {
                if (!$scope.keywords || !$scope.keywords.trim()) {
                    alert('Vui lòng nhập từ khóa tìm kiếm!');
                    return;
                }

                // Xây URL cơ bản
                var url = '/tim-kiem?keywords=' + encodeURIComponent($scope.keywords.trim());

                // Điều hướng
                $window.location.href = url;
            };

            $('.btn-logout').on('click', function(e){
                e.preventDefault();

                $.ajax({
                    url: '{{ route("front.logout") }}',
                    type: 'POST',
                    data: {
                        _token: CSRF_TOKEN
                    },
                    success: function() {
                        window.location.href = '{{ route("front.home-page") }}';
                    },
                    error: function() {
                        window.location.href = '{{ route("front.home-page") }}';
                    }
                });
            });


        });


        app.factory('cartItemSync', function ($interval) {
            var cart = {items: null, total: null};

            cart.items = @json($cartItems);
            cart.count = {{$cartItems->sum('quantity')}};
            cart.total = {{$totalPriceCart}};

            return cart;
        });

    </script>





    @stack('scripts')
</body>

</html>
