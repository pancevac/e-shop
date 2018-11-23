@extends('themes.'. env('APP_THEME') .'.layouts.app')

@section('content')

  {{ \Breadcrumbs::render('verification') }}

  <section class="order_details p_120">
    <div class="container">
      <h3 class="title_confirmation">Uspešno ste verifikovali email adresu.</h3>
    </div>
  </section>

@endsection