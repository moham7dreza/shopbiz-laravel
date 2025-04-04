<!DOCTYPE html>
<html lang="fa">
<head>
    @yield('head-tag')
    @include('Home::layouts.head-tag')
</head>
<body>

@include('Home::layouts.header')

<section id="main-body-two-col" class="container-xxl body-container">
    <section class="row">

        @yield('sidebar')

        @include('Share::alerts.alert-section.success')

        <main id="main-body" class="main-body col-md-9">
            @yield('content')
        </main>

    </section>
</section>


@include('Home::layouts.footer')

@include('Home::layouts.script')
@yield('script')
@include('sweetalert::alert')
<section class="toast-wrapper low-z-index flex-row-reverse"></section>
<section class="login-toast-wrapper flex-row-reverse"></section>
</body>
</html>
