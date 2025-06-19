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
            <h2 class="home_title">{{ $selectCate->name }}</h2>
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

                        <div class="product_grid">
                            {{-- <div class="product_grid_border"></div> --}}
                            @foreach ($products as $product)
                                <!-- Product Item -->
                                <div class="product_item is_new">
                                    <div class="product_border"></div>
                                    <div class="product_image d-flex flex-column align-items-center justify-content-center">
                                        <img src="{{ asset($product->img) }}" alt="">
                                    </div>
                                    <div class="product_content">
                                        <div class="product_price">${{ $product->newPrice }}
                                            <span
                                                style="color: red; text-decoration: line-through">${{ $product->oldPrice }}</span>
                                        </div>
                                        <div class="product_name">
                                            <div><a href="{{ route('product.view', ['id' => $product->id]) }}"
                                                    tabindex="0">{{ $product->name }}</a></div>
                                        </div>
                                    </div>
                                    <div class="product_fav"  productId={{ $product->id }}><i class="fas fa-heart"></i></div>
                                    <ul class="product_marks">
                                        <li class="product_mark product_discount">-25%</li>

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
