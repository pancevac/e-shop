<div class="sidebar-filter mt-50">
  <div class="top-filter-head">Filtri proizvoda</div>

  @includeWhen(request()->has('filters'), 'partials.shop.active_filters')

  @if(isset($properties) && count($properties))

    @foreach($properties as $property)

      <div class="common-filter">
        <div class="head">{{ $property->title }}</div>

          <ul>

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

  @include('partials.shop.price_filter')

</div>
