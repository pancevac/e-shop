<div class="col-lg-6">
  <div class="hot_deal_box">
    <img class="img-fluid" src="{{ $widget->getImage() }}" alt="">
    <div class="content">
      <h2>{{ $widget->title }}</h2>
      <p>{{ $widget->button_text }}</p>
    </div>
    <a class="hot_deal_link" href="{{ $widget->getLink() }}"></a>
  </div>
</div>