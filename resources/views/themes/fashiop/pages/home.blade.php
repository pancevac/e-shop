@extends('themes.'.env('APP_THEME').'.layouts.app')

@section('content')

  @include('themes.'.env('APP_THEME').'.partials.homeBanner', $banner)

  <!--================Hot Deals Area =================-->
  <section class="hot_deals_area section_gap">
    <div class="container-fluid">
      <div class="row">

        @foreach($widgets as $widget)

          @home_widget(['widget' => $widget]) @endhome_widget

        @endforeach

      </div>
    </div>
  </section>
  <!--================End Hot Deals Area =================-->

  <!--================Clients Logo Area =================-->
  {{--<section class="clients_logo_area">
    <div class="container-fluid">
      <div class="clients_slider owl-carousel">
        <div class="item">
          <img src="img/clients-logo/c-logo-1.png" alt="">
        </div>
        <div class="item">
          <img src="img/clients-logo/c-logo-2.png" alt="">
        </div>
        <div class="item">
          <img src="img/clients-logo/c-logo-3.png" alt="">
        </div>
        <div class="item">
          <img src="img/clients-logo/c-logo-4.png" alt="">
        </div>
        <div class="item">
          <img src="img/clients-logo/c-logo-5.png" alt="">
        </div>
      </div>
    </div>
  </section>--}}
  <!--================End Clients Logo Area =================-->

  <!--================Feature Product Area =================-->
  <section class="feature_product_area section_gap">
    <div class="main_box">
      <div class="container-fluid">
        <div class="row">
          <div class="main_title">
            <h2>Istaknuti proizvodi</h2>
            <p>Who are in extremely love with eco friendly system.</p>
          </div>
        </div>
        <div class="row">

          @foreach($products as $product)

            @home_product(['product' => $product, 'loop' => $loop]) @endhome_product

          @endforeach

        </div>

        {{--<div class="row">

          {{ $products->links('themes.'.env('APP_THEME').'.partials.pagination') }}

        </div>--}}
      </div>
    </div>
  </section>
  <!--================End Feature Product Area =================-->

@endsection