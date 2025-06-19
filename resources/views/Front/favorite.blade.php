@extends('Front.master')

@section('title', 'Favorite')

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
                        <div class="cart_title">Wishlist</div>
                        <div class="cart_items">
                            @foreach ($data as $val)
                                <ul class="cart_list">
                                    <li class="cart_item clearfix">
                                        <div class="cart_item_image"><img src="{{ asset($val->img) }}" alt="">
                                        </div>
                                        <div class="cart_item_info d-flex flex-md-row flex-column justify-content-between">
                                            <div class="cart_item_name cart_info_col">
                                                <div class="cart_item_title">Name</div>
                                                <div class="cart_item_text">{{ $val->name }}</div>
                                            </div>
                                            <div class="cart_item_price cart_info_col">
                                                <div class="cart_item_title">Price</div>
                                                <div class="cart_item_text">$ {{ $val->newPrice }}</div>
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
                                            <div class="cart_item_total cart_info_col">
                                                <div class="cart_item_title">Add To Cart</div>
                                                <div class="cart_item_text">
                                                    <button class="btn btn-outline-dark btn-block mg-b-10 addOrder"
                                                        productCartId={{ $val->id }}>
                                                        Add
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            @endforeach
                        </div>
                        @if (count($data) > 0)
                            <div class="cart_buttons">
                                <button type="button" class="button cart_button_checkout emptyWishlist">Empty
                                    Wishlist</button>
                            </div>
                        @else
                            {{-- <div class="cart_buttons"> --}}
                                <h2 class="text-center" style="color:#0e8ce4">Wishlist is Empty</h2>
                            {{-- </div> --}}
                        @endif
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
            $('.addOrder').click(function(e) {
                e.preventDefault();
                let id = $(this).attr('productCartId');

                $.ajax({
                    method: 'POST',
                    url: "/add-favorite-cart",
                    data: {
                        id: id
                    },
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then(() => {
                                if (response.reload) {
                                    window.location.reload();
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        }
                    },
                    error: function(xhr) {
                        Swal.fire({
                            title: 'Error!',
                            text: xhr.responseJSON.message || 'Something went wrong',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            $('.deleteOrder').click(function(e) {
                e.preventDefault();
                let id = $(this).attr('productId');
                console.log(id);

                Swal.fire({
                    title: 'warning!',
                    text: 'Do want delete this order',
                    icon: 'warning',
                    confirmButtonText: 'yes!'
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'DELETE',
                            // url: '{{ route('login') }}',
                            url: "/favorite-delete/" + id,
                            data: {
                                id: id
                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                console.log(response.data);

                                if (response.data == 1) {
                                    window.location.reload();
                                }

                            }
                        })
                    }
                })
            });


            $('.emptyWishlist').click(function(e) {
                Swal.fire({
                    title: 'warning!',
                    text: 'Do want empty Wishlist?',
                    icon: 'warning',
                    confirmButtonText: 'Yes !'
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'get',
                            url: "/empty-wishlist",
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
