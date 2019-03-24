@extends('layouts.app')

@section('breadcrumbs')
  {{ \Breadcrumbs::render('category', $category) }}
@endsection

@section('content')

  <div class="container">
    <div class="row">
      <div class="col-xl-9 col-lg-8 col-md-7">
        <!-- Start Filter Bar -->
        <div class="filter-bar d-flex flex-wrap align-items-center">
          <a href="#" class="grid-btn active"><i class="fa fa-th" aria-hidden="true"></i></a>
          <a href="#" class="list-btn"><i class="fa fa-th-list" aria-hidden="true"></i></a>
          <div class="sorting">
            <select>
              <option value="1">Default sorting</option>
              <option value="1">Default sorting</option>
              <option value="1">Default sorting</option>
            </select>
          </div>
          <div class="sorting mr-auto">
            <select>
              <option value="1">Show 12</option>
              <option value="1">Show 12</option>
              <option value="1">Show 12</option>
            </select>
          </div>
          <div class="pagination">
            <a href="#" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
            <a href="#" class="active">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#" class="dot-dot"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
            <a href="#">6</a>
            <a href="#" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
          </div>
        </div>
        <!-- End Filter Bar -->
        <!-- Start Best Seller -->
        <section class="lattest-product-area pb-40 category-list">
          <div class="row">

            @foreach($products as $product)

              @product(['product' => $product]) @endproduct

            @endforeach


          </div>
        </section>
        <!-- End Best Seller -->
        <!-- Start Filter Bar -->
        <div class="filter-bar d-flex flex-wrap align-items-center">
          <div class="sorting mr-auto">
            <select>
              <option value="1">Show 12</option>
              <option value="1">Show 12</option>
              <option value="1">Show 12</option>
            </select>
          </div>
          <div class="pagination">
            <a href="#" class="prev-arrow"><i class="fa fa-long-arrow-left" aria-hidden="true"></i></a>
            <a href="#" class="active">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <a href="#" class="dot-dot"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
            <a href="#">6</a>
            <a href="#" class="next-arrow"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></a>
          </div>
        </div>
        <!-- End Filter Bar -->
      </div>

      @include('partials.shop.sidebar_filters')

    </div>
  </div>

  @include('partials.most_seach')

@endsection