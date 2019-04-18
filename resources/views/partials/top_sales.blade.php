<section class="pt-100 pb-100">
  <div class="container">
    <div class="organic-section-title text-center">
      <h3>Najprodavaniji proizvodi</h3>
    </div>
    <div class="row mt-30">

      @foreach ($topSales as $product)

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="single-search-product d-flex">
            <a href="{{ $product->getLink() }}"><img src="{{ asset($product->image) }}" alt=""></a>
            <div class="desc">
              <a href="{{ $product->getLink() }}" class="title">{{ $product->title }}</a>
              <div class="price"><span class="lnr lnr-tag"></span> ${{ $product->price }}</div>
            </div>
          </div>
        </div>

      @endforeach

    </div>
  </div>
</section>