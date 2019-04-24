@component('mail::message')
  # Porudžbina

  Vaša porudžbina je sačuvana!

  **Email:** {{ $order->email }}

  **Ime:** {{ $order->first_name }}

  **Ukupno:** {{ currency($order->subtotal_price) }}

@if(session()->has('coupon'))
  **Popust:** {{ currency($order->getDiscount()) }}
@endif

  **Sveukupno:** {{ currency($order->total_price) }}

  **Kupljeni proizvodi**

  @foreach ($order->products as $product)
    Proizvod: {{ $product->title }} <br>
    Količina: {{ $product->pivot->qty }} <br>
    Cena: {{ currency($product->pivot->price) }} <br><hr>
  @endforeach

  {{--@component('mail::button', ['url' => config('app.url'), 'color' => 'green'])--}}
  @if($order->user)
    @component('mail::button', ['url' => $order->getLink()])
      Pogledajte porudžbinu
    @endcomponent
  @endif

  Thanks,<br>
  {{ config('app.name') }}
@endcomponent