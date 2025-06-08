@extends('backend.master')

@section('title', 'Add Featured Products')

@section('content')


    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">dashboard</a>
            <span class="breadcrumb-item active">Add Product</span>
        </nav>

        <div class="sl-pagebody">

            <div class="row row-sm mg-t-20">
                <div class="col-xl-12">
                    <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
                        <div class="row">
                            <label class="col-sm-4 form-control-label">Category Name: <span
                                    class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <select name="" id="category" class="form-control">
                                    <option value="" selected>Select Category</option>
                                    @foreach ($category as $val)
                                        <option value="{{ $val->id }}">{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!-- row -->
                        <br>
                        <div class="row">
                            <label class="col-sm-4 form-control-label">Product Name: <span
                                    class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="text" class="form-control" id="productName"
                                    placeholder="Enter Product Name">
                            </div>
                        </div><!-- row -->

                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label">Old Price: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="number" class="form-control" id="oldPrice" placeholder="Enter Old Price">
                            </div>
                        </div>

                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label">New Price: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="number" class="form-control" id="newPrice" placeholder="Enter New Price">
                            </div>
                        </div>
                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label">description: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <textarea class="form-control" id="description" placeholder="Enter New Price"> </textarea>
                            </div>
                        </div>

                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label">Product Image: <span
                                    class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="file" class="form-control" id="img">

                            </div>
                        </div>

                        <div class="form-layout-footer mg-t-30">
                            <button type="button" class="btn btn-info mg-r-5 addProduct">Add Product</button>
                        </div><!-- form-layout-footer -->
                    </div><!-- card -->
                </div><!-- col-6 -->

            </div><!-- row -->
        </div>
    </div>

@endsection




@section('js')
    <script>
        $(document).ready(function() {
            $('.addProduct').click(function() {
                // e.preventDefault();
                let category = $('#category').val();
                let productName = $('#productName').val();
                let oldPrice = $('#oldPrice').val();
                let newPrice = $('#newPrice').val();
                let description = $('#description').val();
                let img = $('#img').prop('files')[0];
                let formData = new FormData();
                formData.append('category', category);
                formData.append('productName', productName);
                formData.append('oldPrice', oldPrice);
                formData.append('newPrice', newPrice);
                formData.append('description', description);
                formData.append('img', img);

                if (category == '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Enter Category Name',
                        icon: 'error',
                        confirmButtonText: 'Ok!'
                    })
                } else if (productName == '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Enter Product Name',
                        icon: 'error',
                        confirmButtonText: 'Ok!'
                    })

                } else if (newPrice == '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Enter new price product',
                        icon: 'error',
                        confirmButtonText: 'Ok!'
                    })
                } else if (!img) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Upload product image',
                        icon: 'error',
                        confirmButtonText: 'Ok!'
                    })
                } else {
                    $.ajax({
                        method: 'post',
                        // url: '{{ route('login') }}',
                        url: "/product/featured/store",
                        contentType: false,
                        processData: false,
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.data == 1) {
                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Product Added Successfully',
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
