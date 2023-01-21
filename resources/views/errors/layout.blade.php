<!DOCTYPE html>
<html lang="fa-IR">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400">
    <!-- Google web font "Open Sans" -->
    <link rel="stylesheet" href="{{ asset('letter-assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('letter-assets/css/bootstrap.min.css') }}">

    <link rel="stylesheet" href="{{ asset('letter-assets/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('letter-assets/css/templatemo-style.css') }}">

    <script type="text/javascript" src="{{ asset('letter-assets/js/modernizr.custom.86080.js') }}"></script>

</head>

<body>

<div id="particles-js"></div>

<ul class="cb-slideshow">
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
    <li></li>
</ul>

<div class="container-fluid">
    <div class="row cb-slideshow-text-container ">
        <div class="tm-content col-xl-12 col-sm-12 col-xs-12 ml-auto section mr-5">
            <header class="mb-5"><h1 class="text-center">@yield('title')</h1></header>
            <P class="mb-5 text-center">@yield('message')</P>
        </div>
    </div>
    <div class="footer-link">
        <p>Copyright © 2022 - Techzilla.com</p>
    </div>
</div>
</body>

<script type="text/javascript" src="{{ asset('letter-assets/js/particles.js') }}"></script>
<script type="text/javascript" src="{{ asset('letter-assets/js/app.js') }}"></script>
</html>
