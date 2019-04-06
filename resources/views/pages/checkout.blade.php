@extends('layouts.app')

@section('styles')
  <script src="https://js.stripe.com/v3/"></script>
@endsection

@section('breadcrumbs')
  {{ \Breadcrumbs::render('checkout') }}
@endsection

@section('content')

  <div class="container">

    @guest
      <div class="checkput-login">
        <div class="top-title">
          <p>Često kupujete kod nas?
            <a data-toggle="collapse" href="#checkout-login" aria-expanded="false"
               aria-controls="checkout-login">Kliknite ovde da biste ste prijavili</a>
          </p>
        </div>
        <div class="collapse" id="checkout-login">
          <div class="checkout-login-collapse d-flex flex-column">
            <p>Imate napravljen korisnički nalog na našem sajtu? Molimo ispod unesite podatke za prijavu, ako ste novi
              korisnik, molimo
              nastavite sa popunjavanjem sekcije za nastavak kupovine.</p>
            <form action="{{ route('login.post') }}" method="POST" class="d-block">
              @csrf
              <div class="row">

                @component('components.checkout.email-field', [
                  'id' => 'email',
                  'name' => 'email',
                  'placeholder' => 'E-mail adresa',
                  'fieldClass' => 'common-input mt-10',
                  'wrapperClass' => 'col-lg-4',
                  'value' => old('email'),
                  'required' => true,
                ])
                @endcomponent

                @component('components.checkout.password-field', [
                  'id' => 'password',
                  'name' => 'password',
                  'placeholder' => 'Lozinka',
                  'fieldClass' => 'common-input mt-10',
                  'wrapperClass' => 'col-lg-4',
                  'value' => old('password'),
                  'required' => true,
                ])
                @endcomponent

              </div>

              <div class="d-flex align-items-center flex-wrap">
                <button class="view-btn color-2 mt-20 mr-20"><span>Prijavite se</span></button>
                <div class="mt-20">
                  <input type="checkbox" class="pixel-checkbox" id="login-1" name="remember"
                      {{ old('remember') ? 'checked' : '' }}>
                  <label for="login-1">Zapamti me</label>
                </div>
              </div>
            </form>
            <a href="#" class="mt-10">Zaboravili ste lozinku?</a>
          </div>
        </div>
      </div>
    @endguest

  <div class="container">
    <form id="paymentForm" action="{{ route('checkout.post') }}" method="POST" class="billing-form">

      @csrf

      <input type="hidden" id="stripeToken" name="stripe_token" value="">

      <div class="row">
        <div class="col-lg-8 col-md-6">
          <h3 class="billing-title mt-20 mb-10">Detalji kupovine</h3>
          <div class="row">

            @component('components.checkout.text-field', [
              'id' => 'first',
              'name' => 'first_name',
              'value' => old('first_name') ? old('first_name') : (($user && $user->customer) ? $user->customer->first_name : ''),
              'wrapperClass' => 'col-lg-6',
              'placeholder' => 'Ime',
              'required' => true,
            ])
            @endcomponent

            @component('components.checkout.text-field', [
              'id' => 'last',
              'name' => 'last_name',
              'value' => old('last_name') ? old('last_name') : (($user && $user->customer) ? $user->customer->last_name : ''),
              'wrapperClass' => 'col-lg-6',
              'placeholder' => 'Prezime',
              'required' => true,
            ])
            @endcomponent

            @component('components.checkout.text-field', [
              'id' => 'phone',
              'name' => 'phone',
              'value' => old('phone') ? old('phone') : (($user && $user->customer) ? $user->customer->phone : ''),
              'wrapperClass' => 'col-lg-6',
              'placeholder' => 'Broj telefona',
              'required' => true,
            ])
            @endcomponent

            @component('components.checkout.email-field', [
              'id' => 'email',
              'name' => 'email',
              'value' => old('email') ? old('email') : $user ? $user->email : '',
              'wrapperClass' => 'col-lg-6',
              'placeholder' => 'E-mail',
              'required' => true,
            ])
            @endcomponent

            <div class="col-lg-12">
              <div class="sorting">
                <select name="country">
                  <option value="">Drzava*</option>
                  <option value="Srbija">Srbija</option>
                  <option value="Makedonija">Makedonija</option>
                </select>
              </div>
            </div>

            @component('components.checkout.text-field', [
              'id' => 'address1',
              'name' => 'address1',
              'value' => old('address1') ? old('address1') : (($user && $user->customer) ? $user->customer->address1 : ''),
              'wrapperClass' => 'col-lg-12',
              'placeholder' => 'Adresa 1',
              'required' => true,
            ])
            @endcomponent

            @component('components.checkout.text-field', [
              'id' => 'address2',
              'name' => 'address2',
              'value' => old('address2') ? old('address2') : (($user && $user->customer) ? $user->customer->address2 : ''),
              'wrapperClass' => 'col-lg-12',
              'placeholder' => 'Adresa 2',
            ])
            @endcomponent

            @component('components.checkout.text-field', [
              'id' => 'city',
              'name' => 'city',
              'value' => old('city') ? old('city') : (($user && $user->customer) ? $user->customer->city : ''),
              'wrapperClass' => 'col-lg-12',
              'placeholder' => 'Opština/Grad',
              'required' => true,
            ])
            @endcomponent

            @component('components.checkout.text-field', [
              'id' => 'postal_code',
              'name' => 'postal_code',
              'value' => old('postal_code') ? old('postal_code') : (($user && $user->customer) ? $user->customer->postal_code : ''),
              'wrapperClass' => 'col-lg-12',
              'placeholder' => 'Poštanski broj/ZIP',
              'required' => true,
            ])
            @endcomponent

          </div>

          @component('components.checkout.textarea-field', [
              'id' => 'message',
              'name' => 'message',
              'value' => old('message') ? old('message') : '',
              'placeholder' => 'Napomena',
            ])
          @endcomponent

        </div>

        <div class="col-lg-4 col-md-6">
          <div class="order-wrapper mt-50">
            <h3 class="billing-title mb-10">Vaša porudžbina</h3>
            <div class="order-list">
              <div class="list-row d-flex justify-content-between">
                <div>Proizvod</div>
                <div>Ukupno</div>
              </div>

              @foreach($cartItems as $item)

                <div class="list-row d-flex justify-content-between">
                  <div>{{ $item['name'] }}</div>
                  <div>x {{ $item['qty'] }}</div>
                  <div>${{ $item['price'] * $item['qty'] }}</div>
                </div>

              @endforeach

              <div class="list-row d-flex justify-content-between">
                <h6>Ukupno</h6>
                <div>${{ getSubtotalPrice() }}</div>
              </div>
              @if (getDiscount())
                <div class="list-row d-flex justify-content-between">
                  <h6>Popust</h6>
                  <div>${{ getDiscount() }}</div>
                </div>
              @endif
              <div class="list-row d-flex justify-content-between">
                <h6>Sveukupno</h6>
                <div class="total">${{ getTotalPrice() }}</div>
              </div>

              <check-box inline-template>

                <div>
                  <div class="d-flex justify-content-between" style="margin-top: 20px;">
                    <div class="d-flex align-items-center">
                      <input class="pixel-radio" type="radio" id="stripe" checked="checked">
                      <label for="paypal" class="bold-lable">Stripe</label>
                    </div>
                    <img src="img/organic-food/pm.jpg" alt="" class="img-fluid">
                  </div>
                  <p class="payment-info">Kupovina preko Stripe platforme za plaćanje, ovo je samo testno okruženje,
                    tako da se naplata ne izvršava.</p>

                  <stripe
                      ref="stripe"
                      @token="response"
                      style="margin-bottom: 20px;"
                  ></stripe>

                  <div class="mt-20 d-flex align-items-start">
                    <input
                        v-model="conditionAccepted"
                        type="checkbox"
                        class="pixel-checkbox"
                        id="terms_n_conditions"
                    >
                    <label for="login-4">Pročitao sam i prihvatam <a href="#" class="terms-link">
                        uslove korišćenja*</a>
                    </label>
                  </div>

                  <button
                      class="view-btn color-2 w-100 mt-20"
                      @click.prevent="pay">
                    <span>Kupi</span>
                  </button>
                </div>

              </check-box>
            </div>
          </div>
        </div>
      </div>
    </form>
  </div>

  @include('partials.most_search')

@endsection