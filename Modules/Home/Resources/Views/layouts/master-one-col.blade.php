<!DOCTYPE html>
<html lang="fa">
<head>
    @yield('head-tag')
    @include('Home::layouts.head-tag')
</head>
<body>

@include('Home::layouts.header')

<main id="main-body-one-col" class="main-body">

    @include('Share::loaders.preloader')

    @yield('content')

</main>


@include('Home::layouts.footer')



@include('Home::layouts.script')
@yield('script')



@include('Share::alerts.sweetalert.simple-delete-confirm', ['className' => 'delete'])
@include('sweetalert::alert')

{{--<section class="toast-wrapper low-z-index flex-row-reverse"></section>--}}
{{--<section class="login-toast-wrapper flex-row-reverse"></section>--}}
</body>
</html>
