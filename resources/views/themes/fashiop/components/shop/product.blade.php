<div class="col-lg-3 col-md-3 col-sm-6">
  <div class="f_p_item">
    <div class="f_p_img">
      <img class="img-fluid" src="{{ \Imagecache::get($product->image, '215x287')->src }}" alt="">
      <div class="p_icon">
        <a href="#">
          <i class="lnr lnr-heart"></i>
        </a>
        <a href="#">
          <i class="lnr lnr-cart"></i>
        </a>
      </div>
    </div>
    <a href="#">
      <h4>{{ $product->title }}</h4>
    </a>
    <h5>${{ $product->price }}</h5>
  </div>
</div>