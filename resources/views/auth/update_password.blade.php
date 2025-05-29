@extends('auth.master')


@section('title', 'update password')
@section('content')
    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">

        <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white">
            <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">starlight <span class="tx-info tx-normal">admin</span>
            </div>
            <br><br>

            <div class="form-group">
                <input type="password" class="form-control" placeholder="Enter your password" id="password">
            </div><!-- form-group -->

            <div class="form-group">
                <input type="password" class="form-control" placeholder="Enter your password Again" id="rePassword">
            </div>
            <input type="hidden" id="userId" value="{{ $user->id }}">
            <br>
            <button type="submit" class="btn btn-info btn-block updatedPasswordBtn">update Password</button>
        </div><!-- login-wrapper -->
    </div><!-- d-flex -->
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.updatedPasswordBtn').click(function(e) {
                e.preventDefault();
                let password = $('#password').val();
                let rePassword = $('#rePassword').val();
                let userId = $('#userId').val();
                if (password == '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter password for new Account',
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
                } else if (rePassword != password) {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Sorry password not match',
                        icon: 'error',
                        confirmButtonText: 'Ok!'
                    })
                } else {
                    $.ajax({
                        method: 'post',
                        // url: '{{ route('login') }}',
                        url: "/user/updated-password",
                        data: {
                            password: password,
                            userId: userId

                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(response) {
                            if (response.data == 1) {
                                Swal.fire({
                                    title: 'success!',
                                    text: 'reset password Link has been sent to your email',
                                    icon: 'success',
                                    confirmButtonText: 'Ok!'
                                })
                                window.location.href = '/login'
                            }
                        }
                    })
                }
            });
        });
    </script>
@endsection
