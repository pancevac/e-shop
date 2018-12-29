@extends('themes.'.env('APP_THEME').'.layouts.app')

@section('content')

  {{ \Breadcrumbs::render('shopping-cart') }}

  <section class="cart_area">
    <div class="container">
      <div class="cart_inner">
        <div class="table-responsive">

          <shopping-cart
              :cart-items-prop="{{ json_encode($cartItems) }}"
              sub-total-prop="{{ $subTotal }}"
              total-prop="{{ $total }}"
              coupon-prop="{{ $coupon ? $coupon->toJson() : null }}"
              previous-url="{{ url()->previous() }}"
              checkout="{{ route('checkout') }}"
          ></shopping-cart>

        </div>
      </div>
    </div>
  </section>

@endsection