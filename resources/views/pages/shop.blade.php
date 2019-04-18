@extends('layouts.app')

@section('breadcrumbs')
  {{ \Breadcrumbs::render('category', $category) }}
@endsection

@section('content')

  <div class="container">

    <form method="GET" id="filters">

      <div class="row">
        <div class="col-xl-9 col-lg-8 col-md-7">

          @include('partials.shop.topbar_filters')

          <section class="lattest-product-area pb-40 category-list">
            <div class="row">

              @foreach($products as $product)

                @product(['product' => $product]) @endproduct

              @endforeach


            </div>
          </section>

          @include('partials.shop.bottom_bar_filters')

        </div>

        @include('partials.shop.sidebar_filters')

      </div>

    </form>

  </div>

  @include('partials.top_sales')

@endsection