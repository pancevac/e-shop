<section class="home_banner_area"
        @if($banner)
        style="background: url({{ asset($banner->image) }}) no-repeat center bottom;"
        @endif
>
  <div class="overlay"></div>
  <div class="banner_inner d-flex align-items-center">
    <div class="container">
      <div class="banner_content row">
        <div class="offset-lg-2 col-lg-8">
          {{--<h3>Fashion for
            <br />Upcoming Winter</h3>
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna
            aliqua. Ut enim ad minim veniam, quis nostrud exercitation.</p>--}}
          {!! $banner->image_text !!}
          <a class="white_bg_btn" href="{{ asset($banner->link) }}">{{ $banner->button_text }}</a>
        </div>
      </div>
    </div>
  </div>
</section>