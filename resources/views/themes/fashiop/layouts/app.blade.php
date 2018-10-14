<!doctype html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link rel="icon" href="img/favicon.png" type="image/png">
  <title>Fashiop</title>
  <!-- Bootstrap CSS -->
  {{--<link rel="stylesheet" href="css/bootstrap.css">
  <link rel="stylesheet" href="vendors/linericon/style.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="vendors/owl-carousel/owl.carousel.min.css">
  <link rel="stylesheet" href="vendors/lightbox/simpleLightbox.css">
  <link rel="stylesheet" href="vendors/nice-select/css/nice-select.css">
  <link rel="stylesheet" href="vendors/animate-css/animate.css">
  <link rel="stylesheet" href="vendors/jquery-ui/jquery-ui.css">--}}
  <!-- main css -->
  <link rel="stylesheet" href="{{ asset('client/css/style.css') }}">
  {{--<link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/responsive.css">--}}
</head>

<body>

<!--================Header Menu Area =================-->
@include('themes.'. env('APP_THEME') .'.partials.header')
<!--================Header Menu Area =================-->

<!--================Home Banner Area =================-->
@include('themes.'. env('APP_THEME') .'.partials.banner')
<!--================End Home Banner Area =================-->

<!--================Login Box Area =================-->
@yield('content')
<!--================End Login Box Area =================-->

<!--================ Subscription Area ================-->
@include('themes.'. env('APP_THEME') .'.partials.subscription')
<!--================ End Subscription Area ================-->

<!--================ start footer Area  =================-->
@include('themes.'. env('APP_THEME') .'.partials.footer')
<!--================ End footer Area  =================-->




<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
{{--<script src="js/jquery-3.2.1.min.js"></script>
<script src="js/popper.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/stellar.js"></script>
<script src="vendors/lightbox/simpleLightbox.min.js"></script>
<script src="vendors/nice-select/js/jquery.nice-select.min.js"></script>
<script src="vendors/isotope/imagesloaded.pkgd.min.js"></script>
<script src="vendors/isotope/isotope-min.js"></script>
<script src="vendors/owl-carousel/owl.carousel.min.js"></script>
<script src="js/jquery.ajaxchimp.min.js"></script>
<script src="js/mail-script.js"></script>
<script src="vendors/jquery-ui/jquery-ui.js"></script>
<script src="vendors/counter-up/jquery.waypoints.min.js"></script>
<script src="vendors/counter-up/jquery.counterup.js"></script>
<script src="js/theme.js"></script>--}}
<script src="{{ asset('client/js/main.js') }}"></script>
</body>

</html>