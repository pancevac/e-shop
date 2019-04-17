@component('mail::message')
  # Porudžbina

  Vaša porudžbina je sačuvana!

  **Email:** {{ $order->email }}

  **Ime:** {{ $order->first_name }}

  **Ukupno:** ${{ \Cart::instance('shoppingCart')->subtotal() }}

@if(session()->has('coupon'))
  **Popust:** -${{ number_format($order->getDiscountPrice(), 2) }}
@endif

  **Sveukupno:** ${{ number_format($order->total_price, 2) }}

  **Kupljeni proizvodi**

  @foreach ($order->products as $product)
    Proizvod: {{ $product->title }} <br>
    Količina: {{ $product->pivot->qty }} <br>
    Cena: ${{ number_format($product->pivot->price, 2)}} <br><hr>
  @endforeach

  {{--@component('mail::button', ['url' => config('app.url'), 'color' => 'green'])--}}
  @if($order->user)
    @component('mail::button')
      Pogledajte porudžbinu
    @endcomponent
  @endif

  Thanks,<br>
  {{ config('app.name') }}
@endcomponent