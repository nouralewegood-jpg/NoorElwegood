<!DOCTYPE html>
<html lang="ar" dir="rtl">
@include('layouts.head')


<body>
    @include('layouts.main-header')

    @yield('content')
    {{-- footer --}}


    {{-- float buttons --}}

    @include('layouts.footer')
    @include('layouts.float-button')
    @include('layouts.footer-script')

</body>
