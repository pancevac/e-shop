@extends('layouts.app')

@section('breadcrumbs')
  {{ \Breadcrumbs::render('profile') }}
@endsection

@section('content')

  <div class="container">

    <div class="container">
      <form action="{{ route('profile.update') }}" method="POST" class="billing-form">

        @csrf

        <div class="row">
          <div class="col-lg-8 col-md-6">
            <h3 class="billing-title mt-20 mb-10">Moj profil</h3>
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

              @component('components.checkout.email-field', [
                'id' => 'email',
                'name' => 'email',
                'value' => old('email') ? old('email') : $user ? $user->email : '',
                'wrapperClass' => 'col-lg-6',
                'placeholder' => 'E-mail',
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

              <div class="col-lg-12">
                <div class="sorting">
                  <select name="country">
                    <option value="">Drzava*</option>
                    <option value="Srbija"
                            @if ($user->customer->country === 'Srbija')
                              selected="selected"
                            @endif>Srbija</option>
                    <option value="Srbija"
                            @if ($user->customer->country === 'Makedonija')
                            selected="selected"
                        @endif>Makedonija</option>
                  </select>
                  @if ($errors->has('country'))
                    <strong style="color: red">{{ $errors->first('country') }}</strong>
                  @endif
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

              ])
              @endcomponent

              <button class="view-btn color-2 mt-20" style="margin-left: 15px">
                <span>Izmeni</span>
              </button>
              <a class="view-btn color-2 mt-20" href="{{ route('profile.change_password') }}" style="margin-left: 15px">
                <span>Izmeni lozinku</span>
              </a>

            </div>

            {{--<h3 class="billing-title mt-20 mb-10" style="margin-top: 50px">Promeni lozinku</h3>
            <div class="row">

              <form action="{{ route('profile.change_password') }}" method="post">

                @component('components.checkout.password-field', [
                  'id' => 'password',
                  'name' => 'password',
                  'value' => old('password') ? old('password') : '',
                  'wrapperClass' => 'col-lg-6',
                  'placeholder' => 'Lozinka',
                  'required' => true,
                ])
                @endcomponent

                @component('components.checkout.password-field', [
                  'id' => 'password_confirm',
                  'name' => 'password_confirm',
                  'value' => '',
                  'wrapperClass' => 'col-lg-6',
                  'placeholder' => 'Ponovite lozinku',
                  'required' => true,
                ])
                @endcomponent

                <button class="view-btn color-2 mt-20" style="margin-left: 15px">
                  <span>Izmeni</span>
                </button>

              </form>

            </div>--}}

          </div>

        </div>
      </form>
    </div>
  </div>

  @include('partials.top_sales')

@endsection