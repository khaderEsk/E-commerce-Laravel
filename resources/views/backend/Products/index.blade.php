@extends('backend.master')
@section('title', 'Products')


@section('content')
    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Products</span>
        </nav>

        <div class="sl-pagebody">

            <div class="card pd-20 pd-sm-40">

                <div class="table-responsive">
                    <table class="table mg-b-0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Category</th>
                                <th>Old Price</th>
                                <th>New Price</th>
                                <th>description</th>
                                <th>Image</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($products as $val)
                                @php($category = DB::table('categories')->where('id', '=', $val->category)->first())
                                <tr>
                                    <td>{{ $val->id }}</td>
                                    <td>{{ $val->name }}</td>
                                    <td>{{ $category->name }}</td>
                                    <td>{{ $val->oldPrice }}</td>
                                    <td>{{ $val->newPrice }}</td>
                                    <td>{{ $val->description }}</td>
                                    <td>
                                        <a href="{{ asset($val->img) }}" target="_blank">
                                            <img src="{{ asset($val->img) }}" alt="image" width="75">
                                        </a>
                                    </td>
                                    <td>
                                        <a href="{{ route('product.edit', ['id' => $val->id]) }}"
                                            class="btn btn-outline-primary btn-block mg-b-10">
                                            Edit
                                        </a>
                                        <button class="btn btn-outline-danger btn-block mg-b-10 deleteProduct"
                                            ProductId="{{ $val->id }}">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $products->links() }}
        </div>
    </div>
@endsection


@section('js')
    <script>
        $(document).ready(function() {

            $('.deleteProduct').click(function(e) {
                let id = $(this).attr('ProductId');
                Swal.fire({
                    title: 'warning!',
                    text: 'Do want delete this Product',
                    icon: 'warning',
                    confirmButtonText: 'yes!'
                }).then(result => {
                    if (result.isConfirmed) {
                        $.ajax({
                            method: 'get',
                            url: "/product/delete/" + id + "",
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
