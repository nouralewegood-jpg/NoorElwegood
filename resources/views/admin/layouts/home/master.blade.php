<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="author" content="geo-abdelaziz.com">
    <meta name="description" content="منصة مستر محمود عبد الصمد للثانوية العامة">
    <meta content="description" name="منصة مستر محمود عبد الصمد للثانوية العامة">
    <meta content="keywords" name="">
    @include('admin.layouts.home.head')
</head>

<body>

    <!-- Google Tag Manager (noscript) -->
    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MKB95R97" height="0" width="0"
            style="display:none;visibility:hidden"></iframe></noscript>
    <!-- End Google Tag Manager (noscript) -->

    <!-- ======= nav ======= -->
    @include('admin.layouts.home.main-header')
    <!-- End nav -->

    <!-- ======= content ======= -->
    @yield('content')
    <!-- End #content -->

    <!-- ======= Footer ======= -->
    @include('admin.layouts.home.footer')
    <!-- End Footer -->


    @include('admin.layouts.home.footer-scripts')
</body>

</html>
