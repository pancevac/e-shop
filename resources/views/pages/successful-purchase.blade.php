@extends('layouts.app')

@section('breadcrumbs')
  {{ \Breadcrumbs::render('order', $order) }}
@endsection

@section('content')

  <div class="container">
    @if (session()->has('first_view'))
      <p class="text-center">Hvala, Vaša narudžbina je uspešno primljena.</p>
    @endif
    <div class="row mt-50">
      <div class="col-md-4">
        <h3 class="billing-title mt-20 pl-15">Detalji porudžbine</h3>
        <table class="order-rable">
          <tr>
            <td>ID poružbine</td>
            <td>: {{ $order->id }}</td>
          </tr>
          <tr>
            <td>Vreme poručivanja</td>
            <td>: {{ $order->created_at->format('Y-m-d H:m') }}</td>
          </tr>
          <tr>
            <td>Ukupno</td>
            <td>: {{ currency($order->total_price) }}</td>
          </tr>
          <tr>
            <td>Način plaćanja</td>
            <td>: Kreditna kartica(Stripe)</td>
          </tr>
        </table>
      </div>
      <div class="col-md-4">
        <h3 class="billing-title mt-20 pl-15">Adresa poružbine</h3>
        <table class="order-rable">
          <tr>
            <td>Adresa</td>
            <td>: {{ $order->address1 }}</td>
          </tr>
          <tr>
            <td>Grad</td>
            <td>: {{ $order->city }}</td>
          </tr>
          <tr>
            <td>Država</td>
            <td>: {{ $order->country }}</td>
          </tr>
          <tr>
            <td>Poštanski broj</td>
            <td>: {{ $order->postal_code }}</td>
          </tr>
        </table>
      </div>
      {{--<div class="col-md-4">
        <h3 class="billing-title mt-20 pl-15">Shipping Address</h3>
        <table class="order-rable">
          <tr>
            <td>Street</td>
            <td>: 56/8 panthapath</td>
          </tr>
          <tr>
            <td>City</td>
            <td>: Dhaka</td>
          </tr>
          <tr>
            <td>Country</td>
            <td>: Bangladesh</td>
          </tr>
          <tr>
            <td>Postcode</td>
            <td>: 1205</td>
          </tr>
        </table>
      </div>--}}
    </div>
  </div>
  <!-- End Checkout Area -->
  <!-- Start Billing Details Form -->
  <div class="container">
    <div class="billing-form">
      <div class="row">
        <div class="col-12">
          <div class="order-wrapper mt-50">
            <h3 class="billing-title mb-10">Vaša porudžbina</h3>
            <div class="order-list">
              <div class="list-row d-flex justify-content-between">
                <div>Proizvod</div>
                <div>Ukupno</div>
              </div>

              @foreach($order->products as $product)

                <div class="list-row d-flex justify-content-between">
                  <div><a href="{{ $product->getLink() }}">{{ $product->title }}</a></div>
                  <div>x {{ $product->pivot->qty }}</div>
                  <div>{{ currency($product->pivot->price) }}</div>
                </div>

              @endforeach

              <div class="list-row d-flex justify-content-between">
                <h6>Ukupno</h6>
                <div>{{ currency($order->subtotal_price) }}</div>
              </div>
              @if ($order->getDiscount())
                <div class="list-row d-flex justify-content-between">
                  <h6>Popust</h6>
                  <div>- {{ currency($order->getDiscount()) }}</div>
                </div>
                <div class="list-row border-bottom-0 d-flex justify-content-between">
                  <h6>Sveukupno</h6>
                  <div class="total">{{ currency($order->total_price) }}</div>
                </div>
              @endif
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('partials.top_sales')

@endsection