@extends('themes.'. env('APP_THEME') .'.layouts.app')

@section('content')

  {{ \Breadcrumbs::render('login') }}

  <section class="login_box_area p_120">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="login_box_img">
            <img class="img-fluid" src="{{ asset('img/login.jpg') }}" alt="">
            <div class="hover">
              <h4>Novi ste na našem sajtu?</h4>
              {{--<p>There are advances being made in science and technology everyday, and a good example of this is the</p>--}}
              <a class="main_btn" href="{{ route('register') }}">Napravite nalog</a>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="login_form_inner">
            <h3>Prijavite se</h3>
            <form class="row login_form" action="{{ route('login') }}" method="POST" id="contactForm" novalidate="novalidate">
              @csrf

              <div class="col-md-12 form-group">
                <input type="text" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" value="{{ old('email') }}" id="email" name="email" placeholder="Email adresa" required autofocus>

                @if ($errors->has('email'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                  </span>
                @endif

              </div>
              <div class="col-md-12 form-group">
                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" value="{{ old('email') }}" id="password" name="password" placeholder="Lozinka" required>

                @if ($errors->has('password'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                  </span>
                @endif

              </div>
              <div class="col-md-12 form-group">
                <div class="creat_account">
                  <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                  <label for="remember">Sačuvaj me prijavljenog</label>
                </div>
              </div>
              <div class="col-md-12 form-group">
                <button type="submit" class="btn submit_btn">Prijavi se</button>
                <a href="#">Zaboravili ste lozinku?</a>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection