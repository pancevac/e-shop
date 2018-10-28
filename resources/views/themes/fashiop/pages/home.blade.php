@extends('themes.'.env('APP_THEME').'.layouts.app')

@section('content')

  @include('themes.'.env('APP_THEME').'.partials.homeBanner')

  <!--================Hot Deals Area =================-->
  <section class="hot_deals_area section_gap">
    <div class="container-fluid">
      <div class="row">
        <div class="col-lg-6">
          <div class="hot_deal_box">
            <img class="img-fluid" src="img/product/hot_deals/deal1.jpg" alt="">
            <div class="content">
              <h2>Hot Deals of this Month</h2>
              <p>shop now</p>
            </div>
            <a class="hot_deal_link" href="#"></a>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="hot_deal_box">
            <img class="img-fluid" src="img/product/hot_deals/deal1.jpg" alt="">
            <div class="content">
              <h2>Hot Deals of this Month</h2>
              <p>shop now</p>
            </div>
            <a class="hot_deal_link" href="#"></a>
          </div>
        </div>
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

          @for($i = 1; $i > 10; $i++)

            <h1>Test</h1>

            <div class="col col{{ $i }}">
              <div class="f_p_item">
                <div class="f_p_img">
                  <img class="img-fluid" src="img/product/feature-product/f-p-{{ $i }}.jpg" alt="">
                  <div class="p_icon">
                    <a href="#">
                      <i class="lnr lnr-heart"></i>
                    </a>
                    <a href="#">
                      <i class="lnr lnr-cart"></i>
                    </a>
                  </div>
                </div>
                <a href="#">
                  <h4>Long Sleeve TShirt</h4>
                </a>
                <h5>$150.00</h5>
              </div>
            </div>

          @endfor

        </div>

        <div class="row">

          @include('themes.'.env('APP_THEME').'.partials.pagination')

        </div>
      </div>
    </div>
  </section>
  <!--================End Feature Product Area =================-->

@endsection