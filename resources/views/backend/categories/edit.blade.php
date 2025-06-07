@extends('backend.master')

@section('title', 'edit category')

@section('content')

    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">dashboard</a>
            <a class="breadcrumb-item" href="{{ route('category') }}">Categories</a>
            <span class="breadcrumb-item active">Edit Category</span>
        </nav>

        <div class="sl-pagebody">

            <div class="row row-sm mg-t-20">
                <div class="col-xl-12">
                    <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
                        <div class="row">
                            <label class="col-sm-4 form-control-label">Category Name: <span
                                    class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="text" class="form-control" id="name" placeholder="Enter Category Name"
                                    value="{{ $category->name }}">
                            </div>
                        </div><!-- row -->
                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label">Category Order: <span
                                    class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="number" class="form-control" id="order" placeholder="Enter Category Orde"
                                    value="{{ $category->order }}">
                            </div>
                        </div>
                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label">Image: <span class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <a href="{{ asset($category->img) }}" target="_blank">
                                    <img src="{{ asset($category->img) }}" alt="image" width="100">
                                </a>
                                <input type="file" class="form-control" id="img" value="{{ $category->img }}">
                            </div>
                        </div>
                        <input type="hidden" id="id" value="{{ $category->id }}">
                        <div class="form-layout-footer mg-t-30">
                            <button type="button" class="btn btn-info mg-r-5" id="saveCate">Save</button>
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
            $('#saveCate').click(function(e) {
                e.preventDefault();
                let name = $('#name').val();
                let order = $('#order').val();
                let id = $('#id').val();
                let formData = new FormData();

                if ($('#img').prop('files')[0] != null) {
                    let img = $('#img').prop('files')[0];
                    formData.append('img', img);
                }
                formData.append('id', id);
                formData.append('name', name);
                formData.append('order', order);
                if (name == '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter Category Name',
                        icon: 'error',
                        confirmButtonText: 'Ok!'
                    })
                } else if (order == '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter Category Order',
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
                        url: "/category/updated",
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
                                    text: 'Category Updated Successfully',
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
