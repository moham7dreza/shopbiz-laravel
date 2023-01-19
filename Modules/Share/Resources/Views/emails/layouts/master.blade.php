<!doctype html>
<html lang="fa" dir="rtl">
<head>

    @include('Share::emails.layouts.head-tag')
    @yield('head-tag')

</head>
<body>

<!-- start header -->
@include('Share::emails.layouts.header')
<!-- end header -->


<!-- start main one col -->
<main id="main-body-one-col" class="main-body">
    @yield('content')
</main>
<!-- end main one col -->


<!-- start footer -->
@include('Share::emails.layouts.footer')
<!-- end footer -->

</body>
</html>
