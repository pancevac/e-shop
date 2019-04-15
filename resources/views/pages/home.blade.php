@extends('layouts.app')

@section('content')

  @include('partials.home.banner')

  <!-- Start category Area -->
  <section class="category-area section-gap section-gap" id="catagory">
    <div class="container">
      <div class="row d-flex justify-content-center">
        <div class="menu-content pb-40">
          <div class="title text-center">
            <h1 class="mb-10">Shop za različite kategorije</h1>
            <p>Dodatni opis ...</p>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-lg-8 col-md-8 mb-10">
          <div class="row category-bottom">

            @foreach($widgets->take(2) as $widget)

              <div class="col-lg-6 col-md-6 mb-30">
                <div class="content">
                  <a href="{{ url($widget->link) }}" target="_blank">
                    <div class="content-overlay"></div>
                    <img class="content-image img-fluid d-block mx-auto" src="{{ asset(\Imagecache::get($widget->image, '310x221')->src) }}" alt="">
                    <div class="content-details fadeIn-bottom">
                      <h3 class="content-title">{{ $widget->title }}</h3>
                    </div>
                  </a>
                </div>
              </div>

            @endforeach

            @php
            $widget = $widgets->offsetGet(2);
            @endphp

            <div class="col-lg-12">
              <div class="content">
                <a href="{{ $widget->link }}" target="_blank">
                  <div class="content-overlay"></div>
                  <img class="content-image img-fluid d-block mx-auto" src="{{ asset(\Imagecache::get($widget->image, '690x229')->src) }}" alt="">
                  <div class="content-details fadeIn-bottom">
                    <h3 class="content-title">{{ $widget->title }}</h3>
                  </div>
                </a>
              </div>
            </div>

          </div>
        </div>

        @if (isset($widgets[3]))
          @php
          $fourth = $widgets->offsetGet(3);
          @endphp

          <div class="col-lg-4 col-md-4 mb-10">
            <div class="content">
              <a href="{{ $fourth->link }}" target="_blank">
                <div class="content-overlay"></div>
                <img class="content-image img-fluid d-block mx-auto" src="{{ asset(\Imagecache::get($widget->image, '310x895')->src) }}" alt="">
                <div class="content-details fadeIn-bottom">
                  <h3 class="content-title">{{ $fourth->title }}</h3>
                </div>
              </a>
            </div>
          </div>

        @endif
      </div>
    </div>
  </section>
  <!-- End category Area -->

  <section class="women-product-area section-gap" id="women">
    <div class="container">
      <div class="countdown-content pb-40">
        <div class="title text-center">
          <h1 class="mb-10">Istaknuti proizvodi</h1>
          <p>Proizvodi koji su preporučeni od strane naših kupaca.</p>
        </div>
      </div>
      <div class="row">

        @foreach($products as $product)

          @home_product(['product' => $product]) @endhome_product

        @endforeach

      </div>
    </div>
  </section>

  @include('partials.most_search')

@endsection