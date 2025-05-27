@extends('auth.master')


@section('title', 'Login')
@section('content')
    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">

        <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white">
            <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">starlight <span class="tx-info tx-normal">admin</span>
            </div>
            <div class="tx-center mg-b-60">Professional Admin Template Design</div>

            <div class="form-group">
                <input type="text" class="form-control" id="email" placeholder="Enter your username">
            </div><!-- form-group -->
            <div class="form-group">
                <input type="password" class="form-control" id="password" placeholder="Enter your password">
                <a href="" class="tx-info tx-12 d-block mg-t-10">Forgot password?</a>
            </div><!-- form-group -->
            <button type="submit" class="btn btn-info btn-block loginBtn">Sign In</button>

            <div class="mg-t-60 tx-center">Not yet a member? <a href="{{ route('register') }}" class="tx-info">Sign
                    Up</a>
            </div>
        </div><!-- login-wrapper -->
    </div><!-- d-flex -->
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.loginBtn').click(function(e) {
                e.preventDefault();
                let email = $('#email').val();
                let password = $('#password').val();
                if (password == '' || email == '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter email and password',
                        icon: 'error',
                        confirmButtonText: 'Ok!'
                    })
                } else {
                    console.log(email, password);
                    $.ajax({
                        method: 'post',
                        // url: '{{ route('login') }}',
                        url: "/user/login",
                        data: {
                            email: email,
                            password: password,

                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.data == 1) {
                                window.location.href = '/dashboard'
                            } else if (response.data == 2) {
                                window.location.href = '/';
                            } else if (response.data == 0) {
                                Swal.fire({
                                    title: 'Enter Correct Password OR email',
                                    text: response.message,
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
