@extends('themes.'.env('APP_THEME').'.layouts.app')

{{ \Breadcrumbs::render('order', $order) }}

@section('content')

  <section class="order_details p_120">
    <div class="container">
      @if(session()->has('first_view'))
        <h3 class="title_confirmation">Hvala, Vaša narudžbina je uspešno primljena.</h3>
      @endif
      <div class="row order_d_inner">
        <div class="col-lg-4">
          <div class="details_item">
            <h4>Informacije o narudžbini</h4>
            <ul class="list">
              <li>
                <span>Broj narudžbine</span> : {{ $order->id }}
              </li>
              <li>
                <span>Datum narudžbine</span> : {{ $order->created_at }}
              </li>
              <li>
                <span>Ukupan iznos</span> : ${{ $order->total_price }}
              </li>
              <li>
                <span>Način plaćanja</span> : Kartica
              </li>
            </ul>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="details_item">
            <h4>Adresa kupca</h4>
            <ul class="list">
              <li>
                <span>Ulica</span> : {{ $order->address1 }}
              </li>
              <li>
                <span>Grad</span> : {{ $order->city }}
              </li>
              <li>
                <span>Država</span> : {{ $order->country }}
              </li>
              <li>
                <span>Poštanski broj </span> : {{ $order->postal_code }}
              </li>
            </ul>
          </div>
        </div>
      </div>
      <div class="order_details_table">
        <h2>Detalji narudžbine</h2>
        <div class="table-responsive">
          <table class="table">
            <thead>
            <tr>
              <th scope="col">Proizvod</th>
              <th scope="col">Količina</th>
              <th scope="col">Cena</th>
            </tr>
            </thead>
            <tbody>
            @foreach($order->products as $product)

              <tr>
                <td>
                  <p><a href="{{ $product->getLink() }}">{{ $product->title }}</a></p>
                </td>
                <td>
                  <h5>x {{ $product->pivot->qty }}</h5>
                </td>
                <td>
                  <p>${{ $product->pivot->price }}</p>
                </td>
              </tr>

            @endforeach

            <tr>
              <td>
                <h4>Ukupno</h4>
              </td>
              <td>
                <h5></h5>
              </td>
              <td>
                <p>${{ $order->total_price }}</p>
              </td>
            </tr>

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </section>

@endsection
