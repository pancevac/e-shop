<aside class="left_widgets p_filter_widgets">
  <div class="l_w_title">
    <h3>Filtri: </h3>
  </div>

  @if(isset($properties) && count($properties))

    @foreach($properties as $property)

      <div class="widgets_inner">
        <h4>{{ $property->title }}</h4>
        <ul class="list">

          @if(isset($property->attributes) && $property->attributes->count())
            @foreach($property->attributes as $attribute)

              @filter([
              'id' => $attribute->idWithoutPrefix,
              'value' => $attribute->idWithoutPrefix,
              'label' => $attribute->title,
              'property' => $property->title,
              ])
              @endfilter

            @endforeach
          @endif

        </ul>
      </div>

    @endforeach

  @endif

  <div class="widgets_inner">
    <h4>Cena</h4>
    <div class="range_item">
      <range-slider
          min="{{ $data['minPrice'] }}"
          max="{{ $data['maxPrice'] }}"
          min-selected="{{ $data['minPriceSelected'] }}"
          max-selected="{{ $data['maxPriceSelected'] }}"
      ></range-slider>
    </div>
  </div>
</aside>

