@extends('Front.master')

@section('title', 'Cart')

@section('css')

    <link rel="stylesheet" type="text/css" href="{{ asset('/styles/cart_styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/styles/cart_responsive.css') }}">
@endsection

@section('content')
    <div class="cart_section">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="cart_container">
                        <div class="cart_title">Shopping Cart</div>
                        @foreach ($data as $val)
                            <div class="cart_items">
                                <ul class="cart_list">
                                    <li class="cart_item clearfix">
                                        <div class="cart_item_image"><img src="{{ asset($val->img) }}" alt="">
                                        </div>
                                        <div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
                                            <div class="cart_item_name cart_info_col">
                                                <div class="cart_item_title">Name</div>
                                                <div class="cart_item_text">{{ $val->name }}</div>
                                            </div>
                                            <div class="cart_item_quantity cart_info_col">
                                                <div class="cart_item_title">Quantity</div>
                                                <div class="cart_item_text">{{ $val->quantity }}</div>
                                            </div>
                                            <div class="cart_item_price cart_info_col">
                                                <div class="cart_item_title">Price</div>
                                                <div class="cart_item_text">$ {{ $val->newPrice }}</div>
                                            </div>
                                            <div class="cart_item_total cart_info_col">
                                                <div class="cart_item_title">Total</div>
                                                <div class="cart_item_text">${{ $val->newPrice * $val->quantity }}</div>
                                            </div>
                                            <div class="cart_item_total cart_info_col">
                                                <div class="cart_item_title">Wishlist</div>
                                                <div class="cart_item_text">
                                                    <button class="btn btn-outline-dark btn-block mg-b-10 addWishlist"
                                                        wishlistId={{ $val->id }}>
                                                        Add
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="cart_item_total cart_info_col">
                                                <div class="cart_item_title">Delete</div>
                                                <div class="cart_item_text">
                                                    <button class="btn btn-outline-danger btn-block mg-b-10 deleteOrder"
                                                        productId={{ $val->id }}>
                                                        Delete
                                                    </button>
                                                </div>
                                            </div>

                                        </div>
                                    </li>
                                </ul>
                            </div>
                        @endforeach

                        <!-- Order Total -->
                        <div class="order_total">
                            <div class="order_total_content text-md-right">
                                <div class="order_total_title">Order Total:</div>
                                <div class="order_total_amount">${{ $totalPrice }}</div>
                            </div>
                        </div>

                        <div class="cart_buttons">
                            <button type="button" class="button cart_button_clear emptyCart">Empty Cart</button>
                            <a href="{{route('pay.now')}}" class="button cart_button_checkout">Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Newsletter -->

@endsection


@section('js')
    <script>
        $(document).ready(function() {
            $('.addWishlist').click(function(e) {
                e.preventDefault();

                let id = $(this).attr('wishlistId');
                console.log(id);
                Swal.fire({
                        title: 'warning!',
                        text: 'Do want add this order wishlist?',
                        icon: 'warning',
                        confirmButtonText: 'yes!'
                    })
                    .then(result => {
                        if (result.isConfirmed) {
                            $.ajax({
                                method: 'post',
                                // url: '{{ route('login') }}',
                                url: "/add-wishlist",
                                data: {
                                    id: id

                                },
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                },
                                success: function(response) {
                                    if (response.data == 1) {
                                        window.location.reload();
                                    } else {
                                        Swal.fire({
                                            title: 'Error!',
                                            text: 'the order already add wishlist',
                                            icon: 'error',
                                            confirmButtonText: 'OK'
                                        });
                                    }

                                }
                            })
                        }
                    })
            });

            $('.deleteOrder').click(function(e) {
                let id = $(this).attr('productId');
                Swal.fire({
                    title: 'warning!',
                    text: 'Do want delete this order',
                    icon: 'warning',
                    confirmButtonText: 'yes!'
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'post',
                            // url: '{{ route('login') }}',
                            url: "/cart-delete",
                            data: {
                                id: id

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
                    }
                })
            });

            $('.emptyCart').click(function(e) {
                Swal.fire({
                    title: 'warning!',
                    text: 'Do want empty Cart?',
                    icon: 'warning',
                    confirmButtonText: 'Yes !'
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'get',
                            url: "/empty-cart",
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.data == 1) {
                                    window.location.reload();
                                }
                            }
                        })
                    }
                })
            });



        });
    </script>
@endsection
