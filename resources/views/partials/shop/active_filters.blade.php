<div class="common-filter">
  <div class="head">Aktivni filtri</div>
  <ul>

    @php
      $attributes = $properties->reduce(function ($carry, $property) {
            return $carry->merge($property->attributes);
        }, collect([]));
    @endphp

    @foreach(request('filters') as $filter)

      @php
        $attribute = $attributes->where('idWithoutPrefix', $filter)->first();
        $query = request()->all();

        if (isset($query['filters'])) {

          $key = array_search($filter, $query['filters']);
          unset($query['filters'][$key]);
          $query['filters'] = array_values($query['filters']);

          $url = request()->fullUrlWithQuery($query);
        }

      @endphp

      @if ($attribute)
        <li class="filter-list">
          <a href="{{ $url ?? request()->fullUrl() }}" style="color: #777777">
            <i class="fa fa-window-close" aria-hidden="true"></i>
            {{ $attribute->title }}
          </a>
        </li>
      @endif

    @endforeach

  </ul>
</div>

