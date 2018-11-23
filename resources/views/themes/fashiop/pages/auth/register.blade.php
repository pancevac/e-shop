@extends('themes.'. env('APP_THEME') .'.layouts.app')

@section('content')

  {{ \Breadcrumbs::render('register') }}

  <section class="login_box_area p_120">
    <div class="container">
      <div class="row">
        <div class="col-lg-6">
          <div class="login_box_img">
            <img class="img-fluid" src="img/login.jpg" alt="">
            <div class="hover">
              <h4>Imate nalog?</h4>
              {{--<p>There are advances being made in science and technology everyday, and a good example of this is the</p>--}}
              <a class="main_btn" href="{{ route('login') }}">Prijavite se</a>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="login_form_inner reg_form">
            <h3>Napravite nalog</h3>
            <form class="row login_form" action="{{ route('register') }}" method="POST" id="contactForm" novalidate="novalidate">
              @csrf

              <div class="col-md-12 form-group">
                <input type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" id="name" name="name" placeholder="Ime" value="{{ old('name') }}" required autofocus>

                @if ($errors->has('name'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('name') }}</strong>
                  </span>
                @endif
              </div>

              <div class="col-md-12 form-group">
                <input type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" id="email" name="email" placeholder="Email Adresa" value="{{ old('email') }}" required>

                @if ($errors->has('email'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                  </span>
                @endif
              </div>

              <div class="col-md-12 form-group">
                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" placeholder="Lozinka" required>

                @if ($errors->has('password'))
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('password') }}</strong>
                  </span>
                @endif
              </div>
              <div class="col-md-12 form-group">
                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Potvrdite lozinku" required>
              </div>

              <div class="col-md-12 form-group">
                <button type="submit" value="submit" class="btn submit_btn">Registruj se</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>

@endsection