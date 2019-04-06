<textarea
    id="{{ $id }}"
    name="{{ $name }}"
    class="{{ isset($fieldClass) && $fieldClass ? $fieldClass : 'common-input' }}"
    placeholder="{{ $placeholder }}"
    onfocus="this.placeholder=''"
    onblur="this.placeholder = '{{ $placeholder }}*'"
    @if (isset($required) && $required) required @endif
    @if ($errors->has($name)) style="border-color: red" @endif
>
  {{ isset($value) && $value ? $value : '' }}
</textarea>

@if ($errors->has($name))
  <strong style="color: red">{{ $errors->first($name) }}</strong>
@endif