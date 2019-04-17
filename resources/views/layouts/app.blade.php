<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" class="no-js">
<head>
  <!-- Mobile Specific Meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <!-- CSRF -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Domain -->
  <meta name="domain" content="{{ url('/') }}">
  <!-- Favicon-->
  <link rel="shortcut icon" href="img/fav.png">
  <!-- meta character set -->
  <meta charset="UTF-8">

  {!! SEO::generate() !!}

  <link href="https://fonts.googleapis.com/css?family=Poppins:100,200,400,300,500,600,700" rel="stylesheet">
  <!--
  CSS
  ============================================= -->
 {{-- <link rel="stylesheet" href="css/linearicons.css">
  <link rel="stylesheet" href="css/owl.carousel.css">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/nice-select.css">
  <link rel="stylesheet" href="css/ion.rangeSlider.css"/>
  <link rel="stylesheet" href="css/ion.rangeSlider.skinFlat.css"/>--}}
  <link rel="stylesheet" href="{{ asset('client/css/bootstrap.css') }}">
  <link rel="stylesheet" href="{{ asset('client/css/main.css') }}">
  @yield('styles')
</head>
<body>

<div id="app">

  <cart-state
      :cart-items-prop="{{ getCartItems(true) }}"
      cart-count-prop="{{ getCartItemsCount() }}"
      cart-total-price-prop="{{ getTotalPrice(true) }}"
      cart-subtotal-price-prop="{{ getSubtotalPrice(true) }}"
      @if (session()->has('coupon')) :coupon-prop="{{ session()->get('coupon') }}" @endif
  ></cart-state>

  @include('partials.notification')

  @include('partials.nav')

  @yield('breadcrumbs')

  @yield('content')

  @include('partials.footer')

</div>


{{--<script src="js/vendor/jquery-2.2.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
        crossorigin="anonymous"></script>
<script src="js/vendor/bootstrap.min.js"></script>
<script src="js/jquery.nice-select.min.js"></script>
<script src="js/jquery.sticky.js"></script>
<script src="js/ion.rangeSlider.js"></script>
<script src="js/jquery.magnific-popup.min.js"></script>
<script src="js/owl.carousel.min.js"></script>--}}
<script src="{{ asset('client/js/main.js') }}"></script>

@yield('scripts')

</body>
</html>