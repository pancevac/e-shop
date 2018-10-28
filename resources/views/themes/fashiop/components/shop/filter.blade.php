{{--
<li>
  <a href="#">Apple</a>
</li>--}}
@php
  $checked = request('filters') && in_array($value, request('filters'));
@endphp

<div class="switch-wrap d-flex justify-content-between">
  <p>{{ $label }}</p>
  <div class="confirm-checkbox">
    <input
        type="checkbox"
        name="filters[]"
        value="{{ $value }}"
        id="{{ $label }}"
        @if($checked) checked @endif
        onclick="document.getElementById('filters').submit();"
    >
    <label for="{{ $label }}"></label>
  </div>
</div>