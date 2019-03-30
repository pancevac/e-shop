@extends('layouts.app')

@section('breadcrumbs')
  {{ \Breadcrumbs::render('login') }}
@endsection

@section('content')

  <!-- Start My Account -->
  <div class="container">
    <div class="row" style="margin-bottom: 50px;">
      <div class="col-md-6">
        <div class="login-form">
          <h3 class="billing-title text-center">Prijava</h3>
          <p class="text-center mt-80 mb-40">Dobrodošli, prijavite se uz pomoć vašeg naloga. </p>
          <form action="{{ route('login') }}" method="POST">
            @csrf
            <input
                type="text"
                name="email"
                placeholder="Email*"
                onfocus="this.placeholder=''"
                onblur="this.placeholder = 'Email*'"
                required class="common-input mt-20"
                value="{{ old('email') }}"
                @if ($errors->has('email')) style="border: 1px solid red" @endif
            >
            @if ($errors->has('email'))
              <strong style="color: red">{{ $errors->first('email') }}</strong>
            @endif
            <input
                type="password"
                name="password"
                placeholder="Lozinka*"
                onfocus="this.placeholder=''"
                onblur="this.placeholder = 'Lozinka*'"
                required class="common-input mt-20"
                @if ($errors->has('password')) style="border: 1px solid red" @endif
            >
            <button class="view-btn color-2 mt-20 w-100"><span>Prijavi se</span></button>
            <div class="mt-20 d-flex align-items-center justify-content-between">
              <div class="d-flex align-items-center">
                <input type="checkbox"
                       class="pixel-checkbox"
                       id="login-1"
                       name="remember"
                    {{ old('remember') ? 'checked' : '' }}
                ><label for="login-1">Zapamti me</label>
              </div>
              <a href="#">Zaboravili ste lozinku?</a>
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-6">
        <div class="register-form">
          <h3 class="billing-title text-center">Registracija</h3>
          <p class="text-center mt-40 mb-30">Napravite vaš nalog za kupovinu. </p>
          <form action="{{ route('register') }}" method="POST">
            @csrf
            <input type="text"
                   placeholder="Ime*"
                   name="name"
                   value="{{ old('name') }}"
                   onfocus="this.placeholder=''"
                   onblur="this.placeholder = 'Ime*'"
                   required class="common-input mt-20"
                   @if ($errors->has('name')) style="border: 1px solid red" @endif
            >
            @if ($errors->has('name'))
              <strong style="color: red">{{ $errors->first('name') }}</strong>
            @endif

            <input type="email"
                   name="email"
                   value="{{ old('email') }}"
                   placeholder="Email adresa*"
                   onfocus="this.placeholder=''"
                   onblur="this.placeholder = 'Email adresa*'"
                   required class="common-input mt-20"
                   @if ($errors->has('email')) style="border: 1px solid red" @endif
            >
            @if ($errors->has('email'))
              <strong style="color: red">{{ $errors->first('email') }}</strong>
            @endif

            <input type="password"
                   name="password"
                   placeholder="Lozinka*"
                   onfocus="this.placeholder=''"
                   onblur="this.placeholder = 'Lozinka*'"
                   required class="common-input mt-20"
                   @if ($errors->has('password')) style="border: 1px solid red" @endif
            >
            @if ($errors->has('password'))
              <strong style="color: red">{{ $errors->first('password') }}</strong>
            @endif

            <input type="password"
                   name="password_confirmation"
                   placeholder="Ponovite lozinku*"
                   onfocus="this.placeholder=''"
                   onblur="this.placeholder = 'Ponovite lozinku*'"
                   required class="common-input mt-20"
            >
            <button class="view-btn color-2 mt-20 w-100"><span>Registrujte se</span></button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <!-- End My Account -->

@endsection