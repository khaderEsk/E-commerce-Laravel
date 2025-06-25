@extends('Front.master')

@section('title', 'Contact')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/styles/contact_styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/styles/contact_responsive.css') }}">
@endsection

@section('content')
    <div class="contact_form">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="contact_form_container">
                        <div class="contact_form_title">My Profile</div>
                        @if (Session::has('msg'))
                            <p style="text-align: center; font-size: 22px; color: red">
                                {{ Session::get('msg') }}
                            </p>
                        @endif
                        <form action="{{ route('my.account.submit') }}" method="POST" id="contact_form">
                            @csrf
                            <div
                                class="contact_form_inputs d-flex flex-md-row flex-column justify-content-between align-items-between">
                                <div style="width: 80%">
                                    <input type="text" style="width: 80%" name="name" id="contact_form_name"
                                        class="contact_form_name input_field" placeholder="Enter Your name"
                                        data-error="Name is required." value="{{ $user->name }}">
                                    @error('name')
                                        <span class="text-danger" style="display: block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div style="width: 80%">
                                    <input type="email" style="width: 80%" name="email" id="contact_form_email"
                                        class="contact_form_email input_field" placeholder="Your email"
                                        data-error="Email is required." value="{{ $user->email }}">
                                    @error('email')
                                        <span class="text-danger" style="display: block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div style="width: 80%">
                                    <input type="password" style="width: 80%" name="password" id="contact_form_phone"
                                        class="contact_form_phone input_field" placeholder="Your Password">
                                    @error('password')
                                        <span class="text-danger" style="display: block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="contact_form_button">
                                <button type="submit" class="button contact_submit_button">update</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="panel"></div>
    </div>
@endsection
