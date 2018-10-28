@extends('themes.fashiop.layouts.app')


@section('content')

  @include('themes.'. env('APP_THEME') .'.partials.banner')

  <section class="cat_product_area section_gap">
    <form method="GET" id="filters">
    <div class="container-fluid">
      <div class="row flex-row-reverse">
        <div class="col-lg-9">
          <div class="product_top_bar">
            <div class="left_dorp">
              <select class="sorting" name="sort" onchange="document.getElementById('filters').submit()">
                <option value="1" @if(request('sort') == 1) selected @endif>Po nazivu</option>
                <option value="2" @if(request('sort') == 2) selected @endif>Cena rastuća</option>
                <option value="3" @if(request('sort') == 3) selected @endif>Cena opadajuća</option>
              </select>
              <select class="show" name="paginate" onchange="document.getElementById('filters').submit()">
                <option value="10" @if(request('paginate') == 10) selected @endif>Prikazi 10</option>
                <option value="20" @if(request('paginate') == 20) selected @endif>Prikazi 20</option>
                <option value="30" @if(request('paginate') == 30) selected @endif>Prikazi 30</option>
              </select>
            </div>
            <div class="right_page ml-auto">
              <nav class="cat_page" aria-label="Page navigation example">
                <ul class="pagination">
                  <li class="page-item">
                    <a class="page-link" href="#">
                      <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
                    </a>
                  </li>
                  <li class="page-item active">
                    <a class="page-link" href="#">1</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="#">2</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="#">3</a>
                  </li>
                  <li class="page-item blank">
                    <a class="page-link" href="#">...</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="#">6</a>
                  </li>
                  <li class="page-item">
                    <a class="page-link" href="#">
                      <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
                    </a>
                  </li>
                </ul>
              </nav>
            </div>
          </div>
          <div class="latest_product_inner row">
            @foreach($products as $product)

              @product(['product' => $product]) @endproduct

            @endforeach
          </div>
        </div>
        <div class="col-lg-3">
          <div class="left_sidebar_area">

            @include('themes.'.env('APP_THEME').'.partials.shop.categories')

            @include('themes.'.env('APP_THEME').'.partials.shop.filters')

          </div>
        </div>
      </div>

      <div class="row">

        @include('themes.'.env('APP_THEME').'.partials.pagination')

      </div>
    </div>
    </form>
  </section>

@endsection