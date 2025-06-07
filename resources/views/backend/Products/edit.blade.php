@extends('backend.master')

@section('title', 'edit category')

@section('content')
    @php($category = DB::table('categories')->where('id', '=', $product->category)->first())
    @php($categories = DB::table('categories')->get())
    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">dashboard</a>
            <a class="breadcrumb-item" href="{{ route('view.product') }}">Products</a>
            <span class="breadcrumb-item active">Edit Product</span>
        </nav>

        <div class="sl-pagebody">

            <div class="row row-sm mg-t-20">
                <div class="col-xl-12">
                    <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
                        <div class="row">
                            <label class="col-sm-4 form-control-label">product Name: <span
                                    class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="text" class="form-control" id="productName" value="{{ $product->name }}">
                            </div>
                        </div><!-- row -->

                        <div class="row">
                            <label class="col-sm-4 form-control-label">Category Name: <span
                                    class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <select name="" id="category" class="form-control">
                                    <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                                    @foreach ($categories as $val)
                                        <option value="{{ $val->id }}">{{ $val->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div><!-- row -->

                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label">Old Price: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="number" class="form-control" id="oldPrice" value="{{ $product->oldPrice }}">
                            </div>
                        </div>

                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label">new Price: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="number" class="form-control" id="newPrice" value="{{ $product->newPrice }}">
                            </div>
                        </div>

                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label">new Price: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <textarea class="form-control" id="description" > {{ $product->description }}</textarea>
                            </div>
                        </div>
                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label">Image: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <a href="{{ asset($product->img) }}" target="_blank">
                                    <img src="{{ asset($product->img) }}" alt="image" width="100">
                                </a>
                                <input type="file" class="form-control" id="img" value="{{ $product->img }}">
                            </div>
                        </div>

                        <input type="hidden" id="id" value="{{ $product->id }}">
                        <div class="form-layout-footer mg-t-30">
                            <button type="button" class="btn btn-info mg-r-5" id="editProduct">Save</button>
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
            $('#editProduct').click(function() {
                // e.preventDefault();
                let category = $('#category').val();
                let productName = $('#productName').val();
                let oldPrice = $('#oldPrice').val();
                let newPrice = $('#newPrice').val();
                let description = $('#description').val();
                let id = $('#id').val();
                let formData = new FormData();
                if ($('#img').prop('files')[0] != null) {
                    let img = $('#img').prop('files')[0];
                    formData.append('img', img);
                }
                formData.append('category', category);
                formData.append('productName', productName);
                formData.append('oldPrice', oldPrice);
                formData.append('newPrice', newPrice);
                formData.append('description', description);
                formData.append('id', id);

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

                } else if (oldPrice == '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Enter old price product',
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
                        url: "/product/updated",
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
                                    text: 'Product Updated Successfully',
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
