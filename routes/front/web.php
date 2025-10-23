<?php
Route::group([
    'namespace'  => 'Front',
    'middleware' => ['auth.customer.home', 'customer.active'],
], function () {
    Route::get('/profile', 'CustomerController@getProfile') ->name('front.getProfile');
    Route::post('/update-profile', 'CustomerController@updateProfile') ->name('front.updateProfile');
    Route::post('/change-password', 'CustomerController@changePassword') ->name('front.changePassword');
    Route::get('/rental-orders', 'CustomerController@getListRentalOrders') ->name('front.getListRentalOrders');
    Route::get('/buy-orders', 'CustomerController@getListBuyOrders') ->name('front.getListBuyOrders');
    Route::get('/buy-orders/{id}/show', 'CustomerController@getDetailOrder') ->name('front.getDetailOrder');
    Route::post('logout', [\App\Http\Controllers\Front\LoginController::class,'logout'])->name('front.logout');
});



Route::group(['namespace' => 'Front'], function () {
    Route::get('/','FrontController@homePage')->name('front.home-page');
    Route::get('/posts/{slug?}','FrontController@blogs')->name('front.blogs');
    Route::get('/posts/tag/{slug}','FrontController@getPostByTag')->name('front.getPostByTag');
    Route::get('/get-post-by-cate','FrontController@getPostByCate')->name('front.getPostByCate');



    Route::get('/gioi-thieu','FrontController@abouts')->name('front.abouts');
    Route::get('/dich-vu','FrontController@services')->name('front.services');
    Route::get('/dich-vu/{slug}','FrontController@getServiceDetail')->name('front.getServiceDetail');
    Route::get('/chinh-sach/{slug}','FrontController@policy')->name('front.policy');


    Route::get('/lien-he','FrontController@contact')->name('front.contact');
    Route::post('/postContact','FrontController@postContact')->name('front.submitContact');

    Route::get('/tim-kiem','FrontController@searchProduct')->name('front.searchProduct');


    // gio-hang
    Route::post('/posts/{postId}/add-post-to-cart','CartController@addItem')->name('cart.add.item');
    Route::get('/remove-post-to-cart','CartController@removeItem')->name('cart.remove.item');
    Route::get('/gio-hang','CartController@index')->name('cart.index');
    Route::post('/update-cart','CartController@updateItem')->name('cart.update.item');
    Route::get('/thanh-toan','CartController@checkout')->name('cart.checkout');
    Route::post('/checkout','CartController@checkoutSubmit')->name('cart.submit.order');
    Route::get('/dat-hang-thanh-cong.html','CartController@checkoutSuccess')->name('cart.checkout.success');
    Route::post('/apply-voucher','CartController@applyVoucher')->name('cart.apply.voucher');



    // love list
    Route::get('/san-pham-yeu-thich','WishListController@index')->name('love.add.index');
    Route::post('/{productId}/add-product-to-wishlist','WishListController@addItem')->name('love.add.item');
    Route::get('/remove-product-to-wishlist','WishListController@removeFromWishlist')->name('love.remove.item');
    Route::get('/clear-wishlist','WishListController@removeAll')->name('love.remove.allItem');


    Route::get('onlyme/clear', 'FrontController@clearData')->name('front.clearData');

    Route::get('/gg/online', [\App\Http\Controllers\Front\AnalyticsController::class, 'online'])->name('ga4.online');


});


Route::middleware('guest:customer')
    ->group(function(){
        Route::get('login', [\App\Http\Controllers\Front\LoginController::class,'showLoginForm'])->name('front.login');
        Route::post('login', [\App\Http\Controllers\Front\LoginController::class,'login'])->name('front.submitLogin');
        Route::get('register', [\App\Http\Controllers\Front\RegisterController::class,'showRegistrationForm'])->name('front.register');
        Route::post('register', [\App\Http\Controllers\Front\RegisterController::class,'registerSubmit'])->name('front.submitRegister');
    });


// chi tiết bài viết
Route::get('/{slug}','Front\FrontController@blogDetail')->name('front.blogDetail');
