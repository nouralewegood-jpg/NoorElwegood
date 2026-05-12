<!-- Vendor JS Files -->
<script src="{{ asset('assets-home') }}/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset('assets-home') }}/vendor/aos/aos.js"></script>
<script src="{{ asset('assets-home') }}/vendor/glightbox/js/glightbox.min.js"></script>
<script src="{{ asset('assets-home') }}/vendor/swiper/swiper-bundle.min.js"></script>
<script src="{{ asset('assets-home') }}/vendor/isotope-layout/isotope.pkgd.min.js"></script>
<script src="{{ asset('assets-home') }}/vendor/php-email-form/validate.js"></script>

<!-- إضافة مكتبة PureCounter -->
<script src="https://cdn.jsdelivr.net/npm/purecounterjs@1.5.0/dist/purecounter_vanilla.js"></script>

<!-- Template Main JS File -->
<script src="{{ asset('assets-home') }}/js/main.js"></script>
<script src="{{ asset('assets-home') }}/chatbot/chatbot.js"></script>
<script src="{{ asset('assets-home') }}/js/whatsapp.js"></script>
<!-- Blog JS -->
<script src="{{ asset('assets-home') }}/js/blog.js"></script>

<!-- Analytics System -->
@php
    $analyticsSettings = App\Models\AnalyticsSetting::getSettings();
@endphp
@if ($analyticsSettings->is_enabled)
    <script src="{{ asset('assets-home') }}/js/analytics-tracker.js"></script>
@endif

@yield('script')
@stack('scripts')
