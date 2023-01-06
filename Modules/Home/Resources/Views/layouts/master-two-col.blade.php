<!DOCTYPE html>
<html lang="en">
<head>
    @include('Home::layouts.head-tag')
    @yield('head-tag')
</head>
<body>

@include('Home::layouts.header')

<section class="container-xxl body-container">
    @yield('Home::layouts.sidebar')
</section>

@include('Panel::alerts.alert-section.success')
<main id="main-body-one-col" class="main-body">

    @yield('content')

</main>


@include('Home::layouts.footer')



@include('Home::layouts.script')
@yield('script')
</body>
</html>
