<section class="banner-area organic-breadcrumb">
  <div class="container">
    <div class="breadcrumb-banner d-flex flex-wrap align-items-center">
      <div class="col-first">

        @if(isset($breadcrumbs) && count($breadcrumbs))
            <h1>{{ ucfirst($breadcrumbs->last()->title) }}</h1>
        @endif

        <nav class="d-flex align-items-center justify-content-start">

          @foreach($breadcrumbs as $breadcrumb)
            @if($breadcrumb->url && !$loop->last)
              <a href="{{ $breadcrumb->url }}">
                {{ ucfirst($breadcrumb->title) }}
                <i class="fa fa-caret-right" aria-hidden="true"></i>
              </a>
            @else
              <a href="">{{ ucfirst($breadcrumb->title) }}</a>
            @endif
          @endforeach

        </nav>
      </div>
    </div>
  </div>
</section>