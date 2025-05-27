@extends('auth.master')


@section('title', 'Register')
@section('content')
    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-md-100v">

        <div class="login-wrapper wd-300 wd-xs-400 pd-25 pd-xs-40 bg-white">
            <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">Create <span class="tx-info tx-normal">New
                    Account</span>
            </div>
            <br><br>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Enter your name" id="name">
            </div><!-- form-group -->


            <div class="form-group">
                <input type="email" class="form-control" placeholder="Enter your email" id="email" required>
            </div><!-- form-group -->

            <div class="form-group">
                <input type="password" class="form-control" placeholder="Enter your password" id="password">
            </div><!-- form-group -->

            <div class="form-group">
                <input type="password" class="form-control" placeholder="Enter your RePassword" id="rePassword">
            </div><!-- form-group -->
            <div class="form-group tx-12">By clicking the Sign Up button below, you agreed to our privacy policy and terms
                of use of our website.</div>
            <button type="submit" class="btn btn-info btn-block registerBtn">Sign Up</button>

            <div class="mg-t-40 tx-center">Already have an account? <a href="{{ route('login') }}" class="tx-info">Sign
                    In</a>
            </div>
        </div><!-- login-wrapper -->
    </div><!-- d-flex -->
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.registerBtn').click(function(e) {

                e.preventDefault();
                var name = $('#name').val();
                var email = $('#email').val();
                var password = $('#password').val();
                var rePassword = $('#rePassword').val();
                if (name == '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter Your Name',
                        icon: 'error',
                        confirmButtonText: 'Ok!'
                    })
                } else if (email == '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter Your Email',
                        icon: 'error',
                        confirmButtonText: 'Ok!'
                    })

                } else if (password == '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter password for Your Account',
                        icon: 'error',
                        confirmButtonText: 'Ok!'
                    })
                } else if (rePassword == '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter password Again',
                        icon: 'error',
                        confirmButtonText: 'Ok!'
                    })
                } else if (password != rePassword) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Not Match password',
                        icon: 'error',
                        confirmButtonText: 'Ok!'
                    })
                } else {
                    $.ajax({
                        method: "post",
                        url: "/create-account",
                        data: {
                            name: name,
                            email: email,
                            password: password,
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.data == 1) {
                                window.location.href = '/'
                            } else if (response.data == 0) {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'This Email Already Exists',
                                    icon: 'error',
                                    confirmButtonText: 'Ok!'
                                })
                            }
                        }
                    })
                }
            });
        });
    </script>
@endsection
