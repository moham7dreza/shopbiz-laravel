<!DOCTYPE html>
<html lang="en">
<head>
    @include('Home::layouts.head-tag')
    @yield('head-tag')
</head>
<body class="authentication-bg">

<main id="main-body-one-col" class="main-body">

    <div class="home-btn d-none d-sm-block m-4">
        <a href="{{ route('customer.home') }}" title="برگشت به فروشگاه"
           data-bs-toggle="tooltip"
           data-bs-placement="bottom"><i class="fas fa-home h2"></i></a>
    </div>

    @yield('content')

</main>

@include('Home::layouts.script')
@yield('script')
@include('sweetalert::alert')
</body>
</html>
