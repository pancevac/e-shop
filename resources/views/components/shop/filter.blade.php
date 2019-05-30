@php
  $checked = request('filters') && in_array($value, request('filters'));
@endphp

<li class="filter-list">
  <input
      class="pixel-radio"
      type="checkbox"
      id="{{ $label }}"
      name="filters[]"
      value="{{ $value }}"
      @if($checked) checked="checked" @endif
      onclick="document.getElementById('filters').submit();"
  >
  <label for="apple">{{ $label }}</label>
</li>
