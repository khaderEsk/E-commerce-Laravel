@extends('auth.master')


@section('title', 'forget password')
@section('content')
    <div class="d-flex align-items-center justify-content-center bg-sl-primary ht-100v">

        <div class="login-wrapper wd-300 wd-xs-350 pd-25 pd-xs-40 bg-white">
            <div class="signin-logo tx-center tx-24 tx-bold tx-inverse">starlight <span class="tx-info tx-normal">admin</span>
            </div>
            <br><br>

            <div class="form-group">
                <input type="text" class="form-control" id="email" placeholder="Enter your email">
            </div><!-- form-group -->
            <br>
            <button type="submit" class="btn btn-info btn-block loginBtn">Send</button>
        </div><!-- login-wrapper -->
    </div><!-- d-flex -->
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $('.loginBtn').click( function(e) {
                e.preventDefault();
                let email = $('#email').val();
                if (email == '') {
                    Swal.fire({
                        title: 'Error!',
                        text: 'Please enter email',
                        icon: 'error',
                        confirmButtonText: 'Ok!'
                    })
                } else {
                    console.log(email);
                    $.ajax({
                        method: 'post',
                        // url: '{{ route('login') }}',
                        url: "/user/reset-password",
                        data: {
                            email: email
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
                            } else {
                                Swal.fire({
                                    title: 'Error!',
                                    text: 'Wrong email',
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
