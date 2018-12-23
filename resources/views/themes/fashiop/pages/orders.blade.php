@extends('themes.'.env('APP_THEME').'.layouts.app')

{{ \Breadcrumbs::render('orders') }}

@section('content')

  <section class="order_details p_120">
    <div class="container">

      @if(count($orders) < 1)
        <h3 class="title_confirmation">Nemate narudžbina.</h3>
      @else

        <div class="order_details_table">
          <h2>Vaše narudžbine</h2>
          <div class="table-responsive">
            <table class="table">
              <thead>
              <tr>
                <th scope="col">Broj narudzbine</th>
                <th scope="col">Količina proizvoda</th>
                <th scope="col">Cena</th>
              </tr>
              </thead>
              <tbody>
              @foreach($orders as $order)

                <tr>
                  <td>
                    <p><a href="{{ $order->getLink() }}">{{ $order->id }}</a></p>
                  </td>
                  <td>
                    <h5>x {{ $order->products->count() }}</h5>
                  </td>
                  <td>
                    <p>${{ $order->total_price }}</p>
                  </td>
                </tr>

              @endforeach

              </tbody>
            </table>
          </div>
        </div>

      @endif
    </div>
  </section>

@endsection