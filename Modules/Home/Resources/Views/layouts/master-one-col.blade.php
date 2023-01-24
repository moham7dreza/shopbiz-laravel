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

@include('Home::alerts.dialog-timer')
@include('Home::alerts.animate')
@include('Home::alerts.delete-confirm', ['className' => 'delete'])
@include('sweetalert::alert')

</body>
</html>
