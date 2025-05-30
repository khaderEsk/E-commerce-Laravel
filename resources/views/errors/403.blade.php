<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Twitter -->
    <meta name="twitter:site" content="@themepixels">
    <meta name="twitter:creator" content="@themepixels">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="Starlight">
    <meta name="twitter:description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="twitter:image" content="http://themepixels.me/starlight/img/starlight-social.png">

    <!-- Facebook -->
    <meta property="og:url" content="http://themepixels.me/starlight">
    <meta property="og:title" content="Starlight">
    <meta property="og:description" content="Premium Quality and Responsive UI for Dashboard.">

    <meta property="og:image" content="http://themepixels.me/starlight/img/starlight-social.png">
    <meta property="og:image:secure_url" content="http://themepixels.me/starlight/img/starlight-social.png">
    <meta property="og:image:type" content="image/png">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="600">

    <!-- Meta -->
    <meta name="description" content="Premium Quality and Responsive UI for Dashboard.">
    <meta name="author" content="ThemePixels">

    <title>Starlight Responsive Bootstrap 4 Admin Template</title>

    <!-- vendor css -->
    <link href="{{ asset('/backend/lib/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ asset('/backend/lib/Ionicons/css/ionicons.css') }}" rel="stylesheet">


    <!-- Starlight CSS -->
    <link rel="stylesheet" href="{{ asset('/backend/css/starlight.css') }}">
</head>

<body>

    <div class="ht-100v bg-sl-primary d-flex align-items-center justify-content-center">
        <div class="wd-lg-70p wd-xl-50p tx-center pd-x-40">
            <h1 class="tx-100 tx-xs-140 tx-normal tx-white mg-b-0">403!</h1>
            <h5 class="tx-xs-24 tx-normal tx-info mg-b-30 lh-5">The page your are looking for has not been found.</h5>
            <p class="tx-16 mg-b-30 tx-white-5">The page you are looking for might have been removed, had its name
                changed,
                or unavailable. Maybe you could try a search:</p>

            <div class="d-flex justify-content-center">
                <div class="d-flex wd-xs-300">
                    <input type="text" class="form-control form-control-inverse ht-40" placeholder="Search...">
                    <button class="btn btn-info bd-0 mg-l-5 ht-40"><i class="fa fa-search"></i></button>
                </div>
            </div><!-- d-flex -->

            <div class="tx-center mg-t-20">... or back to <a href="{{route('error.403')}}">home</a></div>
        </div>
    </div><!-- ht-100v -->

    <script src="{{ asset('/backend/lib/jquery/jquery.js') }}"></script>
    <script src="{{ asset('/backend/lib/popper.js/popper.js') }}"></script>
    <script src="{{ asset('/backend/lib/bootstrap/bootstrap.js') }}"></script>

</body>
