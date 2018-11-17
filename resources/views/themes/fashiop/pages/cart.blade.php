@extends('themes.'.env('APP_THEME').'.layouts.app')

@section('content')

  {{ \Breadcrumbs::render('shopping-cart') }}

  <section class="cart_area">
    <div class="container">
      <div class="cart_inner">
        <div class="table-responsive">

          <cart-items
              :cart-items="{{ json_encode($cartItems) }}"
              sub-total="{{ \Cart::instance('shoppingCart')->subtotal() }}"
              tax="{{ \Cart::instance('shoppingCart')->tax() }}"
              total="{{ \Cart::instance('shoppingCart')->total() }}"
          ></cart-items>

        </div>
      </div>
    </div>
  </section>

@endsection