@extends('themes.'. env('APP_THEME') .'.layouts.app')

@section('content')

  {{ \Breadcrumbs::render('product', $product) }}

  <!--================Single Product Area =================-->
  <div class="product_image_area">
    <div class="container">
      <div class="row s_product_inner">
        <div class="col-lg-6">
          <div class="s_product_img">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
              <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active">
                  <img src="{{ asset(\Imagecache::get($product->image, '60x60')->src) }}" alt="">
                </li>
                @if(!empty($product->gallery))
                  @foreach($product->gallery as $image)

                    <li data-target="#carouselExampleIndicators" data-slide-to="{{ $loop->iteration }}">
                      <img src="{{ asset($image->product_thumbnail) }}" alt="">
                    </li>

                  @endforeach
                @endif
              </ol>
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <img class="d-block w-100" src="{{ asset(\Imagecache::get($product->image, 'product_image')->src) }}" alt="First slide">
                </div>
                @if(!empty($product->gallery))
                  @foreach($product->gallery as $image)

                    <div class="carousel-item">
                      <img class="d-block w-100" src="{{ asset($image->gallery_image) }}" alt="First slide">
                    </div>

                  @endforeach
                @endif

              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-5 offset-lg-1">
          <div class="s_product_text">
            <h3>{!! $product->title !!}</h3>
            <h2>$
              @if($product->price_outlet)
                {{ $product->price_outlet }}
              @else
                {{ $product->price }}
              @endif
            </h2>
            <ul class="list">
              <li>
                <a class="active">
                  <span>Category</span> :
                  @foreach($product->categories as $category)
                    @if($loop->last)
                      <a href="{{ $category->getUrl() }}">{{ $category->title }}</a>
                    @else
                    <a href="{{ $category->getUrl() }}">{{ $category->title }}, </a>
                    @endif
                  @endforeach
                </a>
              </li>
              <li>
                <a href="#">
                  <span>Dostuponost</span> : @if($product->stock) Na stanju @else Nema na stanju @endif</a>
              </li>
            </ul>
            <p>{!! $product->short !!}</p>
            <div class="product_count">
              <label for="qty">Količina:</label>
              <input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty">
              <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;"
                      class="increase items-count" type="button">
                <i class="lnr lnr-chevron-up"></i>
              </button>
              <button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;"
                      class="reduced items-count" type="button">
                <i class="lnr lnr-chevron-down"></i>
              </button>
            </div>
            <add-to-cart
                product-url="{{ $product->getLink() }}"
                page-type="single-product"
                product-code="{{ $product->code }}"
            ></add-to-cart>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--================End Single Product Area =================-->

  <product-description-area
      :comments="{{ $product->comments }}"
      :average-rate="{{ round($product->averageRate(), 2) }}"
      :total-comments="{{ $product->totalCommentCount() }}"
      description="{{ $product->description }}"
      :attributes="{{ $product->attributes->toJson() }}"
      :auth="true"
      action="{{ $product->getLink() }}"
      csrf="{{ csrf_token() }}"
      toast-message="{{ session()->get('success') }}"
  ></product-description-area>

@endsection