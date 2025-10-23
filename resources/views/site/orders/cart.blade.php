@extends('site.layouts.master')
@section('title')
    Giỏ hàng
@endsection

@section('css')
<style>
    /* ====== GIỎ HÀNG – BẢNG HÀNG HÓA (TRÁI) ====== */
    .cart-title{
        font-size:20px; font-weight:800; margin:0 0 14px;
    }

    .table.checkout-table{
        width:100%;
        border-collapse:separate; border-spacing:0;
        background:#fff;
        border:1px solid #eee;
        border-radius:10px;
        overflow:hidden; /* bo góc hàng đầu */
        display:table;
    }

    .checkout-table th,
    .checkout-table td{
        padding:14px 16px;
        vertical-align:middle;
        border-top:1px solid #f1f3f5;
        color:#222;
    }
    .checkout-table tr:first-child th{
        border-top:0;
        background:#fafafa;
        color:#555;
        font-weight:800;
        text-align:left;
    }

    .checkout-table .respimg{
        width:84px; height:56px; object-fit:cover; border-radius:6px; display:block;
    }

    .product-name{ font-size:16px; margin:0; font-weight:700; line-height:1.3; }
    .order-money{ margin:0; font-weight:800; color:#111; }

    .order-count{
        width:90px; height:40px; text-align:center;
        border:1px solid #e5e7eb; border-radius:6px; outline:0;
    }
    .order-count:focus{ box-shadow:0 0 0 3px rgba(16,185,129,.15); border-color:#cbd5e1; }

    .pr-remove a{
        display:inline-flex; align-items:center; justify-content:center;
        width:32px; height:32px; border-radius:8px; background:#f3f4f6; color:#111; text-decoration:none;
    }
    .pr-remove a:hover{ background:#e5e7eb; }

    /* ====== GIỎ HÀNG – TỔNG TIỀN (PHẢI) ====== */
    .cart-totals{
        background:#222; color:#fff;
        border:1px solid #333; border-radius:10px;
        padding:18px; position:sticky; top:90px; /* bám theo khi cuộn */
        box-shadow:0 14px 40px rgba(0,0,0,.18);
    }
    .cart-totals h3{
        margin:6px 0 14px; font-size:22px; font-weight:800; color:#fff;
    }
    .total-table{ width:100%; border-collapse:collapse; margin-bottom:14px; }
    .total-table th, .total-table td{
        padding:12px 0; border-bottom:1px solid rgba(255,255,255,.14);
    }
    .total-table th{ text-align:left; color:#cbd5e1; font-weight:700; }
    .total-table td{ text-align:right; font-weight:800; color:#fff; }

    /* Nút thanh toán */
    .cart-totals_btn{
        width:100%; height:48px; border:0; border-radius:8px;
        background:#3f7f2e; color:#fff; font-weight:800; letter-spacing:.2px;
        cursor:pointer; transition:filter .15s ease;
    }
    .cart-totals_btn:hover{ filter:brightness(1.05); }
    .cart-totals_btn:active{ transform:translateY(1px); }

    /* ====== RESPONSIVE ====== */
    /* Ẩn cột ảnh/giá trên màn nhỏ (giống ảnh mẫu) */
    @media (max-width: 767.98px){
        .hidden-xs{ display:none !important; }
        .order-count{ width:76px; height:38px; }
        .cart-totals{ position:static; margin-top:16px; }
        .cart-title{ margin-top:6px; }
    }

    /* Cho phép bảng trượt ngang khi nội dung quá rộng */
    @media (max-width: 575.98px){
        .table.checkout-table{
            display:block; overflow-x:auto; -webkit-overflow-scrolling:touch;
        }
    }
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
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ route('front.home-page') }}" title="Trang chủ">Trang chủ</a>
                    </li>
                    <li class="breadcrumb-item active" aria-current="page">Giỏ hàng
                    </li>
                </ol>
            </nav>
        </div>
    </section>


    <section  class="pages" >
        <div class="content" ng-controller="CartController">
            <!--section   -->
            <section>
                <div class="container">
                    <!-- CHECKOUT TABLE -->
                    <div class="row">
                        <div class="col-md-8">
                            <h4 class="cart-title">Giỏ hàng: </h4>
                            <table class="table table-border checkout-table" >
                                <tbody>
                                <tr>
                                    <th class="hidden-xs">Hình ảnh</th>
                                    <th>Bài viết</th>
                                    <th class="hidden-xs">Giá</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                    <th></th>
                                </tr>
                                <tr ng-repeat="item in items" ng-cloak>
                                    <td class="hidden-xs">
                                        <a href="#"><img src="<% item.attributes.image %>" alt="" class="respimg"></a>
                                    </td>
                                    <td>
                                        <h5 class="product-name"><% item.name %></h5>
                                    </td>
                                    <td class="hidden-xs">
                                        <h5 class="order-money"><% (+item.price > 0) ? ((+item.price) | number) + '₫' : 'Liên hệ' %> </h5>
                                    </td>
                                    <td>
                                        <input type="number" name="cartin1" value="1" max="50" min="1" class="order-count" disabled>
                                    </td>
                                    <td>
                                        <h5 class="order-money"> <% (+item.price > 0)
                                            ? (((+item.price) * (+item.quantity || 1)) | number) + '₫'
                                            : 'Liên hệ' %> </h5>
                                    </td>
                                    <td class="pr-remove">
                                        <a href="#" title="Remove" ng-click="removeItem(item.id)"><i class="fas fa-times"></i></a>
                                    </td>
                                </tr>

                                </tbody>
                            </table>
                            <!-- COUPON -->

                            <!-- /COUPON -->
                        </div>
                        <div class="col-md-4">
                            <!-- CART TOTALS  -->
                            <div class="cart-totals  fl-wrap">
                                <h3>Tổng tiền</h3>
                                <table class="total-table" ng-cloak>
                                    <tbody>
                                    <tr>
                                        <th>Tạm tính:</th>
                                        <td><% total | number%>₫ </td>
                                    </tr>
                                    <tr>
                                        <th>Tổng thanh toán:</th>
                                        <td><% total | number%>₫ </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <a href="/thanh-toan">
                                    <button type="button" class="cart-totals_btn color-bg">Thanh toán</button>
                                </a>
                            </div>
                            <!-- /CART TOTALS  -->
                        </div>
                    </div>
                    <!-- /CHECKOUT TABLE -->
                </div>
            </section>
        </div>

    </section>

@endsection

@push('scripts')
    <script>
        document.querySelectorAll('.cart-item').forEach(item => {
            item.addEventListener('click', e => {
                if (e.target.classList.contains('qty-btn')) {
                    const input = item.querySelector('.qty-input');
                    console.log( input.value)
                    let val = parseInt(input.value,10) || 1;
                    if (e.target.classList.contains('minus')) val = Math.max(1, val - 1);
                    else val++;
                    input.value = val;
                    // updateCart();
                }
            });
            // khi gõ số trực tiếp
            item.querySelector('.qty-input').addEventListener('change', e => {
                if (e.target.value < 1) e.target.value = 1;
                // updateCart();
            });
        });
    </script>

     <script>
        app.controller('CartController', function($scope, cartItemSync, $interval, $rootScope) {
            $scope.items = @json($cartCollection);
            $scope.total_qty = "{{ $total_qty }}";
            $scope.checkCart = true;
            $scope.total = "{{$total_price}}";

            $scope.countItem = Object.keys($scope.items).length;

            jQuery(document).ready(function() {
                if ($scope.total_qty == 0) {
                    $scope.checkCart = false;
                    $scope.$applyAsync();
                }
            })

            $scope.changeQty = function(qty, product_id) {
                updateCart(qty, product_id)
            }

            $scope.incrementQuantity = function(product) {
                product.quantity = Math.min(product.quantity + 1, 9999);
            };

            $scope.decrementQuantity = function(product) {
                product.quantity = Math.max(product.quantity - 1, 0);
            };

            function updateCart(qty, product_id) {
                jQuery.ajax({
                    type: 'POST',
                    url: "{{ route('cart.update.item') }}",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    data: {
                        product_id: product_id,
                        qty: qty
                    },
                    success: function(response) {
                        if (response.success) {
                            $scope.items = response.items;
                            $scope.total = response.total;
                            $scope.total_qty = response.count;
                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function() {
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);

                            $scope.$applyAsync();
                        }
                    },
                    error: function(e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function() {
                        $scope.$applyAsync();
                    }
                });
            }

            $scope.removeItem = function(post_id) {
                jQuery.ajax({
                    type: 'GET',
                    url: "{{ route('cart.remove.item') }}",
                    data: {
                        post_id: post_id
                    },
                    success: function(response) {
                        if (response.success) {
                            $scope.items = response.items;
                            $scope.total = response.total;
                            $scope.total_qty = response.count;
                            if ($scope.total_qty == 0) {
                                $scope.checkCart = false;
                            }

                            $interval.cancel($rootScope.promise);

                            $rootScope.promise = $interval(function() {
                                cartItemSync.items = response.items;
                                cartItemSync.total = response.total;
                                cartItemSync.count = response.count;
                            }, 1000);

                            $scope.countItem = Object.keys($scope.items).length;

                            $scope.$applyAsync();
                        }
                    },
                    error: function(e) {
                        toastr.error('Đã có lỗi xảy ra');
                    },
                    complete: function() {
                        $scope.$applyAsync();
                    }
                });
            }
        });
    </script>
@endpush
