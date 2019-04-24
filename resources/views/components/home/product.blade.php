<div class="col-lg-3 col-md-6 single-product">
  <div class="content">
    <div class="content-overlay"></div>

    <div class="lazy-image">
      <lazy-image
          src="{{ asset($product->homeProduct) }}"
          alt=""
          placeholder="{{ asset('images/placeholder.png') }}"
      ></lazy-image>
    </div>

    <div class="content-details fadeIn-bottom">
      <div class="bottom d-flex align-items-center justify-content-center">

        <add-to-wish-list
            product-url="{{ $product->getLink() }}"
            product-code="{{ $product->code }}"
            inline-template
        >
          <a href="" @click.prevent="addToWishList"><span class="lnr lnr-heart"></span></a>
        </add-to-wish-list>

        <a href="#"><span class="lnr lnr-layers"></span></a>

        <add-to-cart
            product-url="{{ $product->getLink() }}"
            product-code="{{ $product->code }}"
            inline-template
        >
          <a href="" @click.prevent="addToShoppingCart"><span class="lnr lnr-cart"></span></a>
        </add-to-cart>

        <a href="{{ $product->getLink() }}"><span class="lnr lnr-frame-expand"></span></a>
      </div>
    </div>
  </div>
  <div class="price">
    <a href="{{ $product->getLink() }}">
      <h5>{{ $product->title }}</h5>
    </a>
    <h3>{{ currency($product->price) }}</h3>
  </div>
</div>