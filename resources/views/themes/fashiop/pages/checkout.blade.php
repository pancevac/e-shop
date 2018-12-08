@extends('themes.'. env('APP_THEME') .'.layouts.app')

@section('styles')

  <script src="https://js.stripe.com/v3/"></script>

@endsection

@section('content')

  {{ \Breadcrumbs::render('wish-list') }}

  <section class="checkout_area section_gap">
    <div class="container">
      @guest
      <div class="returning_customer">
        <div class="check_title">
          <h2>Naša ste stalna mušterija?
            <a href="{{ route('login') }}">Kliknite ovde da biste ste prijavili</a>
          </h2>
        </div>
        <p>Imate napravljen korisnički nalog na našem sajtu? Molimo ispod unesite kredencijale za prijavu, ako ste nova mušterija, molimo
          nastavite sa popunjavanjem sekcije za nastavak kupovine.</p>
        <form class="row contact_form" action="{{ route('login.post') }}" method="POST" novalidate="novalidate">
          {{ csrf_field() }}
          <div class="col-md-6 form-group p_star">
            <input type="text" class="form-control" id="email" name="email" value="{{ old('email') }}">
            <span class="placeholder" data-placeholder="Email adresa"></span>

            @if ($errors->has('email'))
              <strong style="color: red">{{ $errors->first('email') }}</strong>
            @endif

          </div>
          <div class="col-md-6 form-group p_star">
            <input type="password" class="form-control" id="password" name="password" value="{{ old('password') }}">
            <span class="placeholder" data-placeholder="Lozinka"></span>

            @if ($errors->has('password'))
              <strong style="color: red">{{ $errors->first('password') }}</strong>
            @endif

          </div>
          <div class="col-md-12 form-group">
            <button type="submit" value="submit" class="btn submit_btn">Prijavite se</button>
            <div class="creat_account">
              <input type="checkbox" id="f-option" name="name" {{ old('remember') ? 'checked' : '' }}>
              <label for="f-option">Zapamti me</label>
            </div>
            <a class="lost_pass" href="#">Zaboravili ste lozinku?</a>
          </div>
        </form>
      </div>
      @endguest

        <div class="billing_details">
          <div class="row">
            <div class="col-lg-8">
              <h3>Detalji kupovine</h3>
              <form id="paymentForm" class="row contact_form" action="{{ route('checkout.post') }}" method="POST" novalidate="novalidate">

                {{ csrf_field() }}
                <input type="hidden" id="stripeToken" name="stripe_token" value="">

                <div class="col-md-6 form-group p_star">
                  <input
                      value="@if(old('first_name')){{ old('first_name') }}@elseif($user && $user->customer){{ $user->customer->first_name }}@endif"
                      type="text"
                      class="form-control"
                      id="first"
                      name="first_name">
                  <span class="placeholder" data-placeholder="Ime"></span>

                  @if ($errors->has('first_name'))
                    <strong style="color: red">{{ $errors->first('first_name') }}</strong>
                  @endif

                </div>
                <div class="col-md-6 form-group p_star">
                  <input
                      value="@if(old('last_name')){{ old('last_name') }}@elseif($user && $user->customer){{ $user->customer->last_name }}@endif"
                      type="text"
                      class="form-control"
                      id="last"
                      name="last_name"
                  >
                  <span class="placeholder" data-placeholder="Prezime"></span>

                  @if ($errors->has('last_name'))
                    <strong style="color: red">{{ $errors->first('last_name') }}</strong>
                  @endif

                </div>
                <div class="col-md-6 form-group p_star">
                  <input
                      value="@if(old('phone')){{ old('phone') }}@elseif($user && $user->customer){{ $user->customer->phone }}@endif"
                      type="text"
                      class="form-control"
                      id="phone"
                      name="phone"
                  >
                  <span class="placeholder" data-placeholder="Broj telefona"></span>

                  @if ($errors->has('phone'))
                    <strong style="color: red">{{ $errors->first('phone') }}</strong>
                  @endif

                </div>
                <div class="col-md-6 form-group p_star">
                  <input
                      value="@if(old('email')){{ old('email') }}@elseif($user){{ $user->email }}@endif"
                      type="text"
                      class="form-control"
                      id="email"
                      name="email"
                      @auth disabled @endauth
                  >
                  <span class="placeholder" data-placeholder="Email adresa"></span>

                  @if ($errors->has('email'))
                    <strong style="color: red">{{ $errors->first('email') }}</strong>
                  @endif

                </div>
                <div class="col-md-12 form-group p_star">
                  <select class="country_select" name="country">
                    <option value="Srbija">Srbija</option>
                    <option value="Makedonija">Makedonija</option>
                  </select>
                </div>
                <div class="col-md-12 form-group p_star">
                  <input
                      value="@if(old('address1')){{ old('address1') }}@elseif($user && $user->customer){{ $user->customer->address1 }}@endif"
                      type="text"
                      class="form-control"
                      id="add1"
                      name="address1"
                  >
                  <span class="placeholder" data-placeholder="Adresa 1"></span>

                  @if ($errors->has('address1'))
                    <strong style="color: red">{{ $errors->first('address1') }}</strong>
                  @endif

                </div>
                <div class="col-md-12 form-group p_star">
                  <input
                      value="@if(old('address2')){{ old('address2') }}@elseif($user && $user->customer){{ $user->customer->address2 }}@endif"
                      type="text"
                      class="form-control"
                      id="add2"
                      name="address2"
                  >
                  <span class="placeholder" data-placeholder="Adresa 2"></span>

                  @if ($errors->has('address2'))
                    <strong style="color: red">{{ $errors->first('address2') }}</strong>
                  @endif

                </div>
                <div class="col-md-12 form-group p_star">
                  <input
                      @if(old('city')){{ old('city') }}@elseif($user && $user->customer){{ $user->customer->city }}@endif
                      type="text"
                      class="form-control"
                      id="city"
                      name="city">

                  <span class="placeholder" data-placeholder="Opština/Grad"></span>

                  @if ($errors->has('city'))
                    <strong style="color: red">{{ $errors->first('city') }}</strong>
                  @endif

                </div>
                <div class="col-md-12 form-group">
                  <input
                      value="@if(old('postal_code')){{ old('postal_code') }}@elseif($user && $user->customer){{ $user->customer->postal_code }}@endif"
                      type="text"
                      class="form-control"
                      id="postal_code"
                      name="postal_code"
                      placeholder="Poštanski broj/ZIP"
                  >

                  @if ($errors->has('postal_code'))
                    <strong style="color: red">{{ $errors->first('postal_code') }}</strong>
                  @endif

                </div>
                <div class="col-md-12 form-group">
                  <div class="creat_account">
                    <h3>Napomena</h3>
                  </div>
                  <textarea
                      class="form-control"
                      name="message"
                      id="message"
                      rows="1"
                      placeholder="Napišite napomenu ovde"
                  >@if(old('note')) {{ old('note') }} @endif
                  </textarea>

                  @if ($errors->has('note'))
                    <strong style="color: red">{{ $errors->first('note') }}</strong>
                  @endif

                </div>
              </form>
            </div>
            <div class="col-lg-4">

              <order-box
                  :cart-items="{{ json_encode($cartItems) }}"
                  sub-total="{{ $subTotal }}"
                  total="{{ $total }}"
                  discount="{{ $discount }}"
                  :coupon="{{ session()->has('coupon') ? json_encode(session('coupon')) : json_encode(null) }}"
              ></order-box>

            </div>
          </div>
        </div>

    </div>
  </section>

@endsection