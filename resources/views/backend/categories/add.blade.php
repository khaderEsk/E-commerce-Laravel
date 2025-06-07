@extends('backend.master')

@section('title', 'add category')

@section('content')

    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">dashboard</a>
            <span class="breadcrumb-item active">Add Category</span>
        </nav>

        <div class="sl-pagebody">

            <div class="row row-sm mg-t-20">
                <div class="col-xl-12">
                    <div class="card pd-20 pd-sm-40 form-layout form-layout-4">
                        <div class="row">
                            <label class="col-sm-4 form-control-label">Category Name: <span
                                    class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="text" class="form-control" id="name" placeholder="Enter Category Name">
                            </div>
                        </div><!-- row -->
                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label">Category Order: <span
                                    class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="number" class="form-control" id="order"
                                    placeholder="Enter Category Order">
                            </div>
                        </div>
                        <div class="row mg-t-20">
                            <label class="col-sm-4 form-control-label">Category Image: <span
                                    class="tx-danger">*</span></label>
                            <div class="col-sm-8 mg-t-10 mg-sm-t-0">
                                <input type="file" class="form-control" id="img">

                            </div>
                        </div>
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
                let img = $('#img').prop('files')[0];
                let formData = new FormData();
                formData.append('img', img);
                formData.append('order', order);
                formData.append('name', name);
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
                        url: "/add-category/store",
                        contentType: false,
                        processData: false,
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
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
                                    text: 'Category Added Successfully',
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
