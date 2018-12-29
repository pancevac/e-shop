<div class="col col{{ $loop->iteration }}">
  <div class="f_p_item">
    <div class="f_p_img">

      <div class="lazy-image">
        <lazy-image
                src="{{ \Imagecache::get($product->image, '215x287')->src }}"
                alt=""
                placeholder="{{ asset('images/placeholder.png') }}"
        ></lazy-image>
      </div>

      <add-to-cart
          product-url="{{ $product->getLink() }}"
          page-type="shop"
          product-code="{{ $product->code }}"
      ></add-to-cart>
    </div>
    <a href="{{ $product->getLink() }}">
      <h4>{{ $product->title }}</h4>
    </a>
    <h5>${{ $product->price }}</h5>
  </div>
</div>