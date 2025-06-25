@extends('backend.master')
@section('title', 'Contact Us')

@section('content')
    <div class="sl-mainpanel">
        <nav class="breadcrumb sl-breadcrumb">
            <a class="breadcrumb-item" href="{{ route('dashboard') }}">Dashboard</a>
            <span class="breadcrumb-item active">Contact Us</span>
        </nav>

        <div class="sl-pagebody">
            <div class="sl-page-title">
                <h5>Contact Us</h5>
            </div><!-- sl-page-title -->

            @if (count($messages) > 0)
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
                                    <th>Phone</th>
                                    <th>message</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php($i = 1)
                                @foreach ($messages as $val)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $val->name }}</td>
                                        <td><a href="mailto:{{ $val->email }}">{{ $val->email }}</a></td>
                                        <td><a href="tel:{{ $val->phone }}">{{ $val->phone }}</a></td>
                                        <td>{{ mb_substr($val->message, 0, 10) }}...</td>
                                        <td>
                                            <a href="#"data-toggle="modal"
                                                data-target="#modaldemo1{{ $val->id }}" class="btn btn-dark">View</a>
                                            <a href="{{ route('contact.delete', ['id' => $val->id]) }}"
                                                class="btn btn-danger">Delete</a>

                                        </td>
                                    </tr>
                                    <div id="modaldemo1{{ $val->id }}" class="modal fade">
                                        <div class="modal-dialog modal-dialog-vertical-center" role="document">
                                            <div class="modal-content bd-0 tx-14">
                                                <div class="modal-header pd-y-20 pd-x-25">
                                                    <h6 class="tx-14 mg-b-0 tx-uppercase tx-inverse tx-bold">Message Preview
                                                    </h6>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body pd-25">
                                                    <h4 class="lh-3 mg-b-20" style="color: rgba(100, 100, 223, 0.945)">The
                                                        Message was sent by:
                                                        {{ $val->name }}</h4>
                                                    <p class="mg-b-5" style="color: black">{{ $val->message }}</p>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary pd-x-20"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div><!-- modal-dialog -->
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div><!-- card -->
            @else
                <h1 style="text-align: center; color:rgba(100, 100, 223, 0.945)"> Don't have Any Massage</h1>
            @endif
        </div>
    </div>
@endsection
