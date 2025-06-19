@extends('Front.master')

@section('title', 'products by category')
@section('css')

    <link rel="stylesheet" type="text/css" href="{{ asset('/styles/shop_styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/styles/shop_responsive.css') }}">

@endsection
@section('content')
    <div class="home">
        <div class="home_background parallax-window" data-parallax="scroll"
            data-image-src="{{ asset('/images/shop_background.jpg') }}"></div>
        <div class="home_overlay"></div>
        <div class="home_content d-flex flex-column align-items-center justify-content-center">
            <h2 class="home_title">Super Deals</h2>
        </div>
    </div>

    <!-- Shop -->

    <div class="shop">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">

                    <!-- Shop Sidebar -->
                    <div class="shop_sidebar">
                        <div class="sidebar_section">
                            <div class="sidebar_title">Categories</div>
                            <ul class="sidebar_categories">
                                @foreach ($categories as $val)
                                    <li><a
                                            href="{{ route('products.by.category', ['id' => $val->id]) }}">{{ $val->name }}</a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-lg-9">

                    <!-- Shop Content -->

                    <div class="shop_content">
                        <div class="shop_bar clearfix">
                            <div class="shop_product_count"><span>{{ count($productView) }}</span> products found</div>
                        </div>

                        <div class="product_grid">
                            <div class="product_grid_border"></div>
                            @foreach ($products as $val)
                                <!-- Product Item -->
                                <div class="product_item is_new">
                                    <div class="product_border"></div>
                                    <div class="product_image d-flex flex-column align-items-center justify-content-center">
                                        <img src="{{ $val->img }}" alt="">
                                    </div>
                                    <div class="product_content">
                                        <div class="product_price">${{ $val->newPrice }} <span
                                                style="color: red; text-decoration: line-through">
                                                @if ($val->oldPrice != null)
                                                    ${{ $val->oldPrice }}
                                                @endif
                                            </span></div>
                                        <div class="product_name">
                                            <div><a href="{{ route('product.view', ['id' => $val->id]) }}"
                                                    tabindex="0">{{ $val->name }}</a></div>
                                        </div>
                                    </div>
                                    <div class="product_fav" productId={{ $val->id }}><i class="fas fa-heart"></i>
                                    </div>
                                    <ul class="product_marks">
                                        @if ($val->oldPrice != null)
                                            <li class="product_mark product_new" style="background-color: red">
                                                -{{ round((($val->oldPrice - $val->newPrice) / $val->oldPrice) * 100) }}%
                                            </li>
                                        @endif
                                    </ul>
                                </div>
                            @endforeach

                        </div>

                        <!-- Shop Page Navigation -->
                        {{ $products->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Recently Viewed -->
    <!-- Newsletter -->

    <div class="newsletter">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div
                        class="newsletter_container d-flex flex-lg-row flex-column align-items-lg-center align-items-center justify-content-lg-start justify-content-center">
                        <div class="newsletter_title_container">
                            <div class="newsletter_icon"><img src="images/send.png" alt=""></div>
                            <div class="newsletter_title">Sign up for Newsletter</div>
                            <div class="newsletter_text">
                                <p>...and receive %20 coupon for first shopping.</p>
                            </div>
                        </div>
                        <div class="newsletter_content clearfix">
                            <form action="#" class="newsletter_form">
                                <input type="email" class="newsletter_input" required="required"
                                    placeholder="Enter your email address">
                                <button class="newsletter_button">Subscribe</button>
                            </form>
                            <div class="newsletter_unsubscribe_link"><a href="#">unsubscribe</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




@section('js')
    <script>
        $(document).ready(function() {
            $('.product_fav').click(function(e) {
                let productId = $(this).attr('productId');
                $.ajax({
                    method: 'post',
                    // url: '{{ route('login') }}',
                    url: "/add-favorite",
                    data: {
                        productId: productId

                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.data == 1) {

                            window.location.reload();
                        }

                    }
                })
            })
        });
    </script>
@endSection
