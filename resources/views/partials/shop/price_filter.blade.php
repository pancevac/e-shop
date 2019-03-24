<div class="common-filter">
  <div class="head">Cena</div>
  <div class="price-range-area">
    <div id="price-range"></div>
    <div class="value-wrapper d-flex">
      <div class="price">Cena:</div>
      {{--<span>$</span><div id="lower-value"></div> <div class="to">do</div>
      <span>$</span><div id="upper-value"></div>--}}

      <range-slider
          min="{{ $data['minPrice'] }}"
          max="{{ $data['maxPrice'] }}"
          min-selected="{{ $data['minPriceSelected'] }}"
          max-selected="{{ $data['maxPriceSelected'] }}"
      ></range-slider>
    </div>
  </div>
</div>