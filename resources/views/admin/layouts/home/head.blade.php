
<!-- title -->
  <title>@yield("title")</title>

	<link rel="canonical" href="{{route('selection')}}" />
	<!-- Favicon -->
	<link rel="shortcut icon" href="{{ URL::asset('assetsHome/images/logo-mobile.svg')}}">

	<!-- Google Font -->
	<link rel="preconnect" href="https://fonts.googleapis.com/">
	<link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
	<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;700&amp;family=Roboto:wght@400;500;700&amp;display=swap">

	<!-- Plugins CSS -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assetsHome/vendor/font-awesome/css/all.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assetsHome/vendor/bootstrap-icons/bootstrap-icons.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assetsHome/vendor/tiny-slider/tiny-slider.css')}}">
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assetsHome/vendor/glightbox/css/glightbox.css')}}">

	<!-- Theme CSS -->
	<link rel="stylesheet" type="text/css" href="{{ URL::asset('assetsHome/css/style-rtl.css')}}">
	<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700&display=swap" rel="stylesheet">

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<script>
    $(document).keydown(function (event) {
    if (event.keyCode == 123) { // Prevent F12
        return false;
    } else if (event.ctrlKey && event.shiftKey && event.keyCode == 73) { // Prevent Ctrl+Shift+I
        return false;
    }
});

$(document).on("contextmenu", function (e) {
    e.preventDefault();
});
</script>


