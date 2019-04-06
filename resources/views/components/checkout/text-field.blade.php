<div class="{{ isset($wrapperClass) && $wrapperClass ? $wrapperClass : '' }}">
  <input
      value="{{ isset($value) && $value ? $value : '' }}"
      type="text"
      class="{{ isset($fieldClass) && $fieldClass ? $fieldClass : 'common-input' }}"
      id="{{ $id }}"
      name="{{ $name }}"
      placeholder="{{ $placeholder }}"
      onfocus="this.placeholder=''"
      onblur="this.placeholder = '{{ $placeholder }}*'"
      @if (isset($required) && $required) required @endif
      @if ($errors->has($name)) style="border-color: red" @endif
  >
  @if ($errors->has($name))
    <strong style="color: red">{{ $errors->first($name) }}</strong>
  @endif
</div>