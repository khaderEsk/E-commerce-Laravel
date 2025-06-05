@extends('backend.master')
@section('title', 'categories')

@section('content')
    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Categories</span>
        </nav>

        <div class="sl-pagebody">
            <div class="sl-page-title">
                <h5>Categories</h5>
            </div><!-- sl-page-title -->

            <div class="card pd-20 pd-sm-40 mg-t-50">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-primary mg-b-0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Order</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categories as $category)
                                <tr>
                                    <td>{{ $category->id }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $category->order }}</td>
                                    <td>
                                        <a href="{{ route('category.edit', ['id' => $category->id]) }}"
                                            class="btn btn-outline-primary btn-block mg-b-10">Edit</a>
                                        <button class="btn btn-outline-danger btn-block mg-b-10 deleteCategory"
                                            CateId="{{ $category->id }}">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div><!-- table-responsive -->
                {{ $categories->links() }}
            </div><!-- sl-pagebody -->

        </div>
    </div>
@endsection
@section('js')
    <script>
        $(document).ready(function() {

            $('.deleteCategory').click(function(e) {
                let id = $(this).attr('CateId');
                Swal.fire({
                    title: 'warning!',
                    text: 'Do want delete this Category',
                    icon: 'warning',
                    confirmButtonText: 'yes!'
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'post',
                            // url: '{{ route('login') }}',
                            url: "/category/delete",
                            data: {
                                id: id

                            },
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function(response) {
                                if (response.data == 1) {
                                    window.location.reload();
                                }

                            }
                        })
                    }
                })
            });

        });
    </script>
@endsection
