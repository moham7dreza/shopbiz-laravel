<!DOCTYPE html>
<html lang="en">
<head>
    @include('Home::layouts.head-tag')
    @yield('head-tag')
</head>
<body>

@include('Home::layouts.header')

<main id="main-body-one-col" class="main-body">

    @yield('content')

</main>


@include('Home::layouts.footer')



@include('Home::layouts.script')
@yield('script')



@include('Home::alerts.delete-confirm', ['className' => 'delete'])
@include('sweetalert::alert')

<section class="toast-wrapper flex-row-reverse"></section>
</body>
</html>
