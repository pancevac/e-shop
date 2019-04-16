@extends('layouts.app')

@section('breadcrumbs')
  {{ \Breadcrumbs::render('change_password') }}
@endsection

@section('content')

  <div class="container">

    <div class="container">
      <form action="{{ route('profile.change_password.submit') }}" method="POST" class="billing-form">

        @csrf

        <div class="row" style="margin-bottom: 80px;">
          <div class="col-lg-8 col-md-6">
            <h3 class="billing-title mt-20 mb-10">Izmena lozinke</h3>
            <div class="row">

              @component('components.checkout.password-field', [
                'id' => 'password_old',
                'name' => 'password_old',
                'value' => '',
                'wrapperClass' => 'col-lg-12',
                'placeholder' => 'Trenutna lozinka',
                'required' => true,
              ])
              @endcomponent

              @component('components.checkout.password-field', [
                'id' => 'password',
                'name' => 'password',
                'value' => '',
                'wrapperClass' => 'col-lg-6',
                'placeholder' => 'Nova lozinka',
                'required' => true,
              ])
              @endcomponent

              @component('components.checkout.password-field', [
                'id' => 'password_confirmation',
                'name' => 'password_confirmation',
                'value' => '',
                'wrapperClass' => 'col-lg-6',
                'placeholder' => 'Potvrdite novu lozinku',
                'required' => true,
              ])
              @endcomponent

              <button class="view-btn color-2 mt-20" style="margin-left: 15px">
                <span>Izmeni</span>
              </button>

            </div>

          </div>

        </div>
      </form>
    </div>
  </div>

@endsection