@extends('Front.master')

@section('title', $product->name)

@section('css')

    <link rel="stylesheet" type="text/css" href="{{ asset('/styles/product_styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/styles/product_responsive.css') }}">

@endsection

@section('content')
    <div class="single_product">
        <div class="container">
            <div class="row">




                <!-- Selected Image -->
                <div class="col-lg-5 order-lg-2 order-1">
                    <div class="image_selected"><img src="{{ asset($product->img) }}" alt=""></div>
                </div>

                <!-- Description -->
                <div class="col-lg-5 order-3">
                    <div class="product_description">
                        <div class="product_category">{{ $category->name }}</div>
                        <div class="product_name">{{ $product->name }}</div>
                        <div class="rating_r rating_r_4 product_rating"><i></i><i></i><i></i><i></i><i></i></div>
                        <div class="product_text">
                            <p>{{ $product->description }}</p>
                        </div>
                        <div class="order_info d-flex flex-row">
                            <form action="#">
                                <div class="clearfix" style="z-index: 1000;">

                                    <!-- Product Quantity -->
                                    <div class="product_quantity clearfix">
                                        <span>Quantity: </span>
                                        <input id="quantity_input" type="text" pattern="[0-9]*" value="1">
                                        <div class="quantity_buttons">
                                            <div id="quantity_inc_button" class="quantity_inc quantity_control"><i
                                                    class="fas fa-chevron-up"></i></div>
                                            <div id="quantity_dec_button" class="quantity_dec quantity_control"><i
                                                    class="fas fa-chevron-down"></i></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="product_price">${{ $product->oldPrice }}</div>
                                <span style="color: red; text-decoration: line-through">${{ $product->newPrice }}</span>
                                <div class="button_container">
                                    <button type="button" class="button cart_button" productID={{ $product->id }}>Add to
                                        Cart</button>
                                    <div class="product_fav"><i class="fas fa-heart"></i></div>
                                </div>

                            </form>
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
            $('.cart_button').click(function(e) {
                let productId = $(this).attr('productID');
                let quantity = $('#quantity_input').val();
                let formData = new FormData();
                formData.append('quantity', quantity);
                formData.append('productId', productId);
                if (quantity == '' || quantity == 0) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please input quantity Product',
                        icon: 'error',
                        confirmButtonText: 'Ok!'
                    })
                } else {
                    $.ajax({
                        method: 'post',
                        // url: '{{ route('login') }}',
                        url: "/add-cart",
                        contentType: false,
                        processData: false,
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response);

                            if (response.data == 0) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Category Already Exists',
                                    icon: 'error',
                                    confirmButtonText: 'Ok!'
                                })
                            } else {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Product Added Cart Successfully',
                                    icon: 'success',
                                    confirmButtonText: 'Ok!'
                                }).then(result => {
                                    if (result.isConfirmed) {
                                        window.location.reload();
                                    }
                                });
                            }

                        }
                    })

                }
            });
        });
    </script>

@endsection

