<section class="banner-area relative" id="home">
  <div class="container-fluid">
    <div class="row fullscreen align-items-center justify-content-center">
      <div class="col-lg-6 col-md-12 d-flex align-self-end img-right no-padding">
        <img class="img-fluid" src="{{ asset($banner->image) }}" alt="">
      </div>
      <div class="banner-content col-lg-6 col-md-12">
        {!! $banner->image_text !!}
        {{--<h1 class="title-top"><span>Flat</span> 75%Off</h1>
        <h1 class="text-uppercase">
          It’s Happening <br>
          this Season!
        </h1>--}}
        <button class="primary-btn text-uppercase"><a href="{{ url($banner->link) }}">{!! $banner->button_text !!}</a></button>
      </div>
    </div>
  </div>
</section>