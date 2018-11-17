<section class="banner_area">
  <div
      class="banner_inner d-flex align-items-center"
      {{--style="background: url({{ asset('img/breadcrumb/checkout-bg.jpg') }}) no-repeat center bottom;"--}}
          @if(isset($breadcrumbs->last()->image) && $breadcrumbs->last()->image)
          style="background: url({{ asset($breadcrumbs->last()->image) }}) no-repeat center bottom;"
          @endif
      style="background: url({{ asset('img/breadcrumb/checkout-bg.jpg') }}) no-repeat center bottom;"
  >
    <div class="container">
      <div class="banner_content text-center">
        @if(isset($breadcrumbs) && count($breadcrumbs))

          <h2>{{ ucfirst($breadcrumbs->last()->title) }}</h2>
          <div class="page_link">

            @foreach($breadcrumbs as $breadcrumb)
              @if($breadcrumb->url && !$loop->last)
                <a href="{{ $breadcrumb->url }}">{{ ucfirst($breadcrumb->title) }}</a>
              @else
                <a class="active">{{ ucfirst($breadcrumb->title) }}</a>
              @endif
            @endforeach

          </div>
        @endif
      </div>
    </div>
  </div>
</section>