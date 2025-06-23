@extends('Front.master')

@section('title', 'Contact')

@section('css')
    <link rel="stylesheet" type="text/css" href="{{ asset('/styles/contact_styles.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/styles/contact_responsive.css') }}">
@endsection


@section('content')

    <div class="contact_info">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div
                        class="contact_info_container d-flex flex-lg-row flex-column justify-content-between align-items-between">

                        <!-- Contact Item -->
                        <div class="contact_info_item d-flex flex-row align-items-center justify-content-start">
                            <div class="contact_info_image"><img src="{{ asset('/images/contact_1.png') }}" alt="">
                            </div>
                            <div class="contact_info_content">
                                <div class="contact_info_title">Phone</div>
                                <div class="contact_info_text">+963 930 668 517</div>
                            </div>
                        </div>

                        <!-- Contact Item -->
                        <div class="contact_info_item d-flex flex-row align-items-center justify-content-start">
                            <div class="contact_info_image"><img src="{{ asset('/images/contact_2.png') }}" alt="">
                            </div>
                            <div class="contact_info_content">
                                <div class="contact_info_title">Email</div>
                                <div class="contact_info_text">khader9es@gmail.com</div>
                            </div>
                        </div>

                        <!-- Contact Item -->
                        <div class="contact_info_item d-flex flex-row align-items-center justify-content-start">
                            <div class="contact_info_image"><img src="{{ asset('/images/contact_3.png') }}" alt="">
                            </div>
                            <div class="contact_info_content">
                                <div class="contact_info_title">Address</div>
                                <div class="contact_info_text">10 Suffolk at Soho, London, UK</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Contact Form -->

    <div class="contact_form">
        <div class="container">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <div class="contact_form_container">
                        <div class="contact_form_title">Get in Touch</div>
                        @if (Session::has('msg'))
                            <p style="text-align: center; font-size: 22px; color: red">
                                {{ Session::get('msg') }}
                            </p>
                        @endif
                        <form action="{{ route('contact.us.submit') }}" method="POST" id="contact_form">
                            @csrf
                            <div
                                class="contact_form_inputs d-flex flex-md-row flex-column justify-content-between align-items-between">
                                <div style="width: 80%">
                                    <input type="text" style="width: 80%" name="name" id="contact_form_name"
                                        class="contact_form_name input_field" placeholder="Enter Your name"
                                        data-error="Name is required." value="{{ old('name') }}">
                                    @error('name')
                                        <span class="text-danger" style="display: block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div style="width: 80%">
                                    <input type="email" style="width: 80%" name="email" id="contact_form_email"
                                        class="contact_form_email input_field" placeholder="Your email"
                                        data-error="Email is required." value="{{ old('email') }}">
                                    @error('email')
                                        <span class="text-danger" style="display: block">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div style="width: 80%">
                                    <input type="text" style="width: 80%" name="phone" id="contact_form_phone"
                                        class="contact_form_phone input_field"
                                        placeholder="Your phone number"value="{{ old('phone') }}">
                                    @error('phone')
                                        <span class="text-danger" style="display: block">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="contact_form_text">
                                <textarea id="contact_form_message" class="text_field contact_form_message" name="message" rows="4"
                                    placeholder="Message" data-error="Please, write us a message.">
                                    {{ old('message') }}
                                </textarea>
                                @error('message')
                                    <span class="text-danger" style="display: block">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="contact_form_button">
                                <button type="submit" class="button contact_submit_button">Send Message</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
        <div class="panel"></div>
    </div>

    <!-- Map -->

    <div class="contact_map">
        <div id="google_map" class="google_map">
            <div class="map_container">
                <div id="map"></div>
            </div>
        </div>
    </div>
@endsection
