@extends('layouts.app')

@section('breadcrumbs')
  {{ \Breadcrumbs::render('orders') }}
@endsection

@section('content')

  <!-- End Checkout Area -->
  <!-- Start Billing Details Form -->
  <div class="container">
    <div class="billing-form">
      <div class="row">
        <div class="col-12">
          <div class="order-wrapper mt-50">
            <h3 class="billing-title mb-10">Vaše porudžbine</h3>
            <div class="order-list">
              <div class="list-row d-flex justify-content-between">
                <div>Order ID</div>
                <div>Ukupno proizvoda</div>
                <div>Ukupno</div>
              </div>

              @foreach($orders as $order)

                <div class="list-row d-flex justify-content-between">
                  <div><a href="{{ $order->getLink() }}">{{ $order->getKey() }}</a></div>
                  <div>x {{ $order->countProducts }}</div>
                  <div>{{ currency($order->total_price) }}</div>
                </div>

              @endforeach

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  @include('partials.top_sales')

@endsection