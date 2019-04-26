<section class="pt-100 pb-100">
  <div class="container">
    <div class="organic-section-title text-center">
      <h3>Povezani proizvodi</h3>
    </div>
    <div class="row mt-30">

      @foreach ($relatedProducts as $product)

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="single-search-product d-flex">
            <a href="{{ $product->getLink() }}">
              <lazy-image-small
                src="{{ asset($product->productSmall) }}"
                placeholder="{{ asset('images/placeholder.png') }}"
              ></lazy-image-small>
            </a>
            <div class="desc">
              <a href="{{ $product->getLink() }}" class="title">{{ $product->title }}</a>
              <div class="price"><span class="lnr lnr-tag"></span> {{ currency($product->price) }}</div>
            </div>
          </div>
        </div>

      @endforeach

    </div>
  </div>
</section>