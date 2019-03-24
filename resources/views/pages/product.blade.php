@extends('layouts.app')

@section('breadcrumbs')
  {{ \Breadcrumbs::render('product', $product) }}
@endsection

@section('content')

  <div class="container">
    <div class="product-quick-view">
      <div class="row align-items-center">
        <div class="col-lg-6">

          <product-gallery
            :gallery="{{ $product->gallery->toJson() }}"
          ></product-gallery>

        </div>
        <div class="col-lg-6">
          <div class="quick-view-content">
            <div class="top">
              <h3 class="head">{!! $product->title !!}</h3>
              <div class="price d-flex align-items-center">
                <span class="lnr lnr-tag"></span>
                <span class="ml-10">
                  @if($product->price_outlet)
                    {{ $product->price_outlet }}
                  @else
                    {{ $product->price }}
                  @endif
                </span>
              </div>
              <div class="category">Kategorija:
                @foreach($product->categories as $category)
                  @if($loop->last)
                    <a href="{{ $category->getUrl() }}"><span>{{ $category->title }}</span></a>
                  @else
                    <a href="{{ $category->getUrl() }}"><span>{{ $category->title }}</span>, </a>
                  @endif
                @endforeach
              </div>
              <div class="available">Dostuponost:
                <span>@if($product->stock) Na stanju @else Nema na stanju @endif</span>
              </div>
            </div>
            <div class="middle">
              <p class="content">{!! $product->short !!}</p>
            </div>
            <div >
              <div class="quantity-container d-flex align-items-center mt-15">
                Količina:
                <input type="text" id="product-quantity" class="quantity-amount ml-15" value="1" />
                <div class="arrow-btn d-inline-flex flex-column">
                  <button class="increase arrow" type="button" title="Increase Quantity"><span class="lnr lnr-chevron-up"></span></button>
                  <button class="decrease arrow" type="button" title="Decrease Quantity"><span class="lnr lnr-chevron-down"></span></button>
                </div>

              </div>
              <div class="d-flex mt-20">
                <add-to-cart
                  product-url="{{ $product->getLink() }}"
                  product-code="{{ $product->code }}"
                  inline-template
                >
                  <a @click.prevent="addToShoppingCart" class="view-btn color-2">
                    <span>Dodaj u korpu</span>
                  </a>
                </add-to-cart>

                <a href="#" class="like-btn"><span class="lnr lnr-layers"></span></a>

                <add-to-wish-list
                    product-url="{{ $product->getLink() }}"
                    product-code="{{ $product->code }}"
                    inline-template
                >
                  <a href="" @click.prevent="addToWishList" class="like-btn">
                    <span class="lnr lnr-heart"></span>
                  </a>
                </add-to-wish-list>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="container">
    <div class="details-tab-navigation d-flex justify-content-center mt-30">
      <ul class="nav nav-tabs" id="myTab" role="tablist">
        <li>
          <a class="nav-link" id="description-tab" data-toggle="tab" href="#description" role="tab" aria-controls="description" aria-expanded="true">Description</a>
        </li>
        <li>
          <a class="nav-link" id="specification-tab" data-toggle="tab" href="#specification" role="tab" aria-controls="specification">Specification</a>
        </li>
        <li>
          <a class="nav-link active" id="reviews-tab" data-toggle="tab" href="#reviews" role="tab" aria-controls="reviews">Reviews</a>
        </li>
      </ul>
    </div>
    <div class="tab-content" id="myTabContent">

      <div class="tab-pane fade" id="description" role="tabpanel" aria-labelledby="description">
        <div class="description">
          @if ($product->description)
            {!! $product->description !!}
          @else
            <h4>Nema opisa</h4>
          @endif
        </div>
      </div>

      <div class="tab-pane fade" id="specification" role="tabpanel" aria-labelledby="specification">
        <div class="specification-table">
          @foreach($product->attributes as $attribute)
            <div class="single-row">
              <span>{{ $attribute->property->title }}</span>
              <span>{{ $attribute->title }}</span>
            </div>
          @endforeach
        </div>
      </div>

      <div class="tab-pane fade show active" id="reviews" role="tabpanel" aria-labelledby="reviews">
        <product-reviews
            :comments="{{ $product->comments }}"
            :average-rate="{{ round($product->averageRate(), 2) }}"
            :total-comments="{{ $product->totalCommentCount() }}"
            auth="{{ auth()->check() }}"
            action="{{ $product->getLink() }}"
            toast-message="{{ session()->get('success') }}"
        ></product-reviews>
      </div>
    </div>
  </div>

  @include('partials.most_search')

@endsection