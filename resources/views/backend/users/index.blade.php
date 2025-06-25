@extends('backend.master')

@section('title', 'Users')

@section('content')
    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Users</span>
        </nav>

        <div class="sl-pagebody">
            <div class="sl-page-title">
                <h5>Users</h5>
            </div><!-- sl-page-title -->

            @if (count($users) > 0)
                <div class="card pd-20 pd-sm-40">
                    <div class="table-responsive">
                        <table class="table mg-b-0">
                            <thead>
                                <tr>
                                    <th>
                                        #
                                    </th>
                                    <th>Name</th>
                                    <th>E-mail</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i = 1)
                                @foreach ($users as $val)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $val->name }}</td>
                                        <td><a href="mailto:{{ $val->email }}">{{ $val->email }}</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!-- card -->
            @else
                <h1 style="text-align: center; color:rgba(100, 100, 223, 0.945)"> Don't have Any Users</h1>
            @endif
        </div>
    </div>
@endsection
