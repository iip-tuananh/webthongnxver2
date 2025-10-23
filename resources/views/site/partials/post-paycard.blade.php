<style>
    /* Style gọn, khớp với box-widget có sẵn */
    .post-paycard{border:1px solid #e8edf2;padding:14px;background:#fff; margin-bottom: 15px}
    .post-paycard-head{display:flex;align-items:center;justify-content:space-between;gap:10px;margin-bottom:10px}
    .ppc-badge{display:inline-block;font-size:.85rem;padding:6px 10px;border-radius:999px;border:1px solid #e8edf2}
    .ppc-badge.is-free{background:#f1f8f5;color:#0b7a3b;border-color:#d5efe3}
    .ppc-badge.is-paid{background:#fff5f0;color:#b23c17;border-color:#ffd9c9}
    .ppc-title{margin:0;font-size:1.05rem; text-align: left}

    .post-paycard-price{margin:8px 0 12px}
    .ppc-price-row{align-items:flex-end;gap:10px}
    .ppc-price-current{font-weight:700;font-size:1.05rem}
    .ppc-price-old{text-decoration:line-through;color:#9aa3ae}
    .ppc-price-free{font-weight:700;color:#0b7a3b}

    .post-paycard-actions{flex-wrap:wrap;gap:10px;margin-bottom:10px}
    .ppc-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;border-radius:10px;padding:10px 14px;border:1px solid transparent;cursor:pointer;text-decoration:none}
    .ppc-btn-primary{background:#ff6a00;color:#fff}
    .ppc-btn-primary:hover{filter:brightness(.96)}
    .ppc-btn-ghost{background:#fff;border:1px solid #e8edf2;color:#111}
    .ppc-inline-form{display:inline}

    .post-paycard-meta{margin:8px 0 0;padding:10px 2px;list-style:none}
    .post-paycard-meta li{display:flex;margin:4px 0}
    .post-paycard-meta span{color:#6b7280;min-width:110px}

    @media (max-width:600px){
        .ppc-title{font-size:1rem}
        .ppc-price-current{font-size:1.1rem}
    }

</style>
@php
    $basePrice  = (int)($blog->price ?? 0);
    $isPaid     = $blog->type == 1 ? false : true ;
    $finalPrice = $basePrice;
@endphp

<div class="post-paycard">
    <div class="post-paycard-head">
        <span class="ppc-badge {{ $isPaid ? 'is-paid' : 'is-free' }}">
            {{ $isPaid ? 'Trả phí' : 'Miễn phí' }}
        </span>
        <h5 class="ppc-title">{{ $blog->name ?? 'Bài viết' }}</h5>
    </div>

    <div class="post-paycard-price">
        @if(!$isPaid)
            <span class="ppc-price-free">Miễn phí</span>
        @else
            <div class="ppc-price-row">
                <span class="ppc-price-current">{{ number_format($finalPrice) }}₫</span>
            </div>
        @endif
    </div>

    <div class="post-paycard-actions">
        @if(! $customer)
            @if($isPaid)
                <a class="ppc-btn ppc-btn-primary"
                   href="{{ route('front.login') }}">
                    Đăng nhập để {{ $isPaid ? 'mua' : 'đọc' }}
                </a>
            @endif


        @else
            @if(!$isPaid)
            @else

                @if($blog->canAccess)
                    <button type="button" class="ppc-btn ppc-btn-primary">Đã sở hữu</button>
                @else
                    <form method="post" action="" class="ppc-inline-form">
                        @csrf
                        <input type="hidden" name="type" value="post">
                        <input type="hidden" name="post_id" value="{{ $blog->id }}">
                        <button type="button" class="ppc-btn ppc-btn-primary" ng-click="addToCart({{ $blog->id }})">Thêm vào giỏ hàng</button>
                    </form>
                @endif

            @endif
        @endguest

        {{-- Gợi ý: nếu đã mua rồi, hiện "Đọc ngay" --}}
        {{--                                            @auth--}}
        {{--                                                @if(isset($blog->owned) && $blog->owned)--}}
        {{--                                                    <a class="ppc-btn ppc-btn-ghost" href="{{ route('posts.show', $blog->slug ?? $blog->id) }}">--}}
        {{--                                                        Đã mua • Đọc ngay--}}
        {{--                                                    </a>--}}
        {{--                                                @endif--}}
        {{--                                            @endauth--}}
    </div>

    {{-- Thông tin phụ (tuỳ chọn) --}}
    <ul class="post-paycard-meta">
        @if(!empty($blog->category->name))
            <li><span>Danh mục:</span> <strong>{{ $blog->category->name }}</strong></li>
        @endif
        <li><span>Tác giả:</span> <strong>Admin</strong></li>

        @if(!empty($blog->reading_time))
            <li><span>Thời gian đọc:</span> <strong>15 phút</strong></li>
        @endif
    </ul>
</div>
