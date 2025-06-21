@extends('backend.master')

@section('title', 'profile')

@section('content')
    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Profile</span>
        </nav>

        <div class="sl-pagebody">
            <div class="card pd-20 pd-sm-40">
                <div class="form-layout">
                    <div class="row mg-b-25">
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-control-label">FirstName: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" id="name" value="{{ Auth::user()->name }}"
                                    placeholder="Enter Your FullName">
                            </div>
                        </div><!-- col-4 -->
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-control-label">E-mail address: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="email" id="email" value="{{ Auth::user()->email }}"
                                    placeholder="Enter Your E-mail">
                            </div>
                        </div><!-- col-4 -->
                        <div class="col-lg-4">
                            <div class="form-group">
                                <label class="form-control-label">Password: <span class="tx-danger">*</span></label>
                                <input class="form-control" type="text" id="password" placeholder="Enter Your Password">
                            </div>
                        </div><!-- col-4 -->

                    </div><!-- row -->

                    <div class="form-layout-footer">
                        <button class="btn btn-info mg-r-5 updateProfile">Save</button>
                    </div><!-- form-layout-footer -->
                </div><!-- form-layout -->
            </div><!-- card -->
        </div><!-- sl-pagebody -->
    </div>
@endsection


@section('js')
    <script>
        $(document).ready(function() {
            $('.updateProfile').click(function() {

                // e.preventDefault();
                let name = $('#name').val();
                let email = $('#email').val();
                let password = $('#password').val();
                let formData = new FormData();
                formData.append('name', name);
                formData.append('email', email);
                formData.append('password', password);

                if (name == '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Enter Your Name',
                        icon: 'error',
                        confirmButtonText: 'Ok!'
                    })
                } else if (email == '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please Enter Your E-mail',
                        icon: 'error',
                        confirmButtonText: 'Ok!'
                    })
                } else {
                    $.ajax({
                        method: 'post',
                        // url: '{{ route('login') }}',
                        url: "/update/profile",
                        contentType: false,
                        processData: false,
                        data: formData,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            console.log(response.data);
                            if (response.data == 1) {

                                Swal.fire({
                                    title: 'Success!',
                                    text: 'Profile Updated Successfully',
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
