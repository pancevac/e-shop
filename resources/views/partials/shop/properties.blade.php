<div class="sidebar-filter mt-50">
  <div class="top-filter-head">Filtri proizvoda</div>
  <div class="common-filter">
    {{--<div class="head">Active Filters</div>
    <ul>
      <li class="filter-list"><i class="fa fa-window-close" aria-hidden="true"></i>Gionee (29)</li>
      <li class="filter-list"><i class="fa fa-window-close" aria-hidden="true"></i>Black with red (09)</li>
    </ul>--}}
  </div>

  @if(isset($properties) && count($properties))

    @foreach($properties as $property)

      <div class="common-filter">
        <div class="head">{{ $property->title }}</div>
        <form action="#">
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
        </form>
      </div>

    @endforeach

  @endif

</div>