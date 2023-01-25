<!DOCTYPE html>
<html lang="en">

<head>
    @include('Panel::layouts.head-tag')
    @yield('head-tag')

</head>

<body dir="rtl">

    @include('Panel::layouts.header')



    <section class="body-container">

        @include('Panel::layouts.sidebar')


        <section id="main-body" class="main-body">

            @yield('content')

        </section>
    </section>


    @include('Panel::layouts.script')
    @yield('script')

    <section class="toast-wrapper flex-row-reverse">
        @include('Panel::alerts.toast.success')
        @include('Panel::alerts.toast.error')
    </section>

    @include('Panel::alerts.sweetalert.error')
    @include('Panel::alerts.sweetalert.success')

    @include('sweetalert::alert')
</body>
</html>
