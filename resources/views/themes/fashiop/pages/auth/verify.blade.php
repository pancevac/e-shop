@extends('themes.'. env('APP_THEME') .'.layouts.app')

@section('content')

  {{ \Breadcrumbs::render('verification') }}

  <section class="tracking_box_area p_120">
    <div class="container">
      <div class="tracking_box_inner">

        @if (session('resent'))
          <div class="alert alert-success" role="alert">
            {{ __('Novi verifikacioni kod je poslat na vašu email adresu.') }}
          </div>
        @endif

        <p>{{ __('Pre nastavka, proverite da li je na vašu email adresu stigao verifikacioni kod.') }}</p>
        <p>{{ __('Ako niste primili email') }}, <a href="{{ route('verification.resend') }}">{{ __('kliknite ovde da pošaljete novi zahtev') }}</a>.</p>

      </div>
    </div>
  </section>

@endsection