<section class="pt-100 pb-100">
  <div class="container">
    <div class="organic-section-title text-center">
      <h3>Most Searched Products</h3>
    </div>
    <div class="row mt-30">

      @for ($i = 1; $i == 12; $i++)

        <div class="col-lg-3 col-md-4 col-sm-6">
          <div class="single-search-product d-flex">
            <a href="02-11-product-details.html"><img src="{{ asset("img/r$i.jpg") }}" alt=""></a>
            <div class="desc">
              <a href="02-11-product-details.html" class="title">Pixelstore fresh Blueberry</a>
              <div class="price"><span class="lnr lnr-tag"></span> $240.00</div>
            </div>
          </div>
        </div>

      @endfor

    </div>
  </div>
</section>