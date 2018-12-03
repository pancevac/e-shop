@extends('themes.'. env('APP_THEME') .'.layouts.app')

@section('content')

  {{ \Breadcrumbs::render('profile') }}

  <div class="whole-wrap">
    <div class="container">

      <div class="section-top-border">
        <div class="row">
          <div class="col-lg-4 col-sm-6 typo-sec">
            <div class="typography">
              <h1 class="typo-list">Moj nalog</h1>
            </div>
          </div>

        </div>
      </div>

      <div class="section-top-border">
        <div class="row">
          <div class="col-lg-8 col-md-8">
            <h3 class="mb-30 title_color">Dodajte informacije o sebi</h3>
            <form action="{{ route('profile.update') }}" method="POST">
              {{ csrf_field() }}
              <div class="mt-10">
                <input type="text" name="first_name" value="{{ $user->customer->first_name }}" placeholder="First Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'First Name'"
                       required class="single-input">
              </div>
              <div class="mt-10">
                <input type="text" name="last_name" value="{{ $user->customer->last_name }}" placeholder="Last Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Last Name'"
                       required class="single-input">
              </div>
              <div class="mt-10">
                <input type="text" name="name" value="{{ $user->name }}" placeholder="Username" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Username'"
                       required class="single-input">
              </div>
              <div class="mt-10">
                <input type="email" name="email" value="{{ $user->email }}" placeholder="Email address" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Email address'"
                       class="single-input" disabled>
              </div>
              <div class="input-group-icon mt-10">
                <div class="icon">
                  <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                </div>
                <input type="text" name="address1" value="{{ $user->customer->address1 }}" placeholder="Adresa 1" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Adresa 1'"
                       required class="single-input">
              </div>

              <div class="input-group-icon mt-10">
                <div class="icon">
                  <i class="fa fa-plane" aria-hidden="true"></i>
                </div>
                <input type="text" name="address2" value="{{ $user->customer->address2 }}" placeholder="Adresa 2" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Adresa 2'"
                       class="single-input">
              </div>

              <div class="input-group-icon mt-10">
                <div class="icon">
                  <i class="fa fa-thumb-tack" aria-hidden="true"></i>
                </div>
                <input type="text" name="city" value="{{ $user->customer->city }}" placeholder="Grad" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Grad'"
                       class="single-input">
              </div>

              <div class="input-group-icon mt-10">
                <div class="icon">
                  <i class="fa fa-globe" aria-hidden="true"></i>
                </div>
                <div class="form-select" id="default-select2">
                  <select name="country">
                    <option value="0">Država</option>
                    <option value="Srbija" selected>Srbija</option>
                    <option value="Hrvatska">Hrvatska</option>
                    <option value="Rumunija">Rumunija</option>
                    <option value="Madjarska">Mađarska</option>
                    <option value="Makedonija">Makedonija</option>
                  </select>
                </div>
              </div>
              <div class="mt-10">
                <button type="submit" style="margin-top: 10px" class="genric-btn success circle arrow">Ažurirajte
                  <span class="lnr lnr-arrow-right"></span>
                </button>
              </div>

            </form>

            <h3 class="mb-30 title_color" style="margin-top: 20px">Promenite lozinku</h3>
            <form action="{{ route('profile.change_password') }}" method="POST">
              {{ csrf_field() }}
              <div class="mt-10">
                <input type="password" name="password_old" placeholder="Trenutna lozinka" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Trenutna lozinka'"
                       required class="single-input-secondary">
              </div>
              <div class="mt-10">
                <input type="password" name="password" placeholder="Nova lozinka" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Nova lozinka'"
                       required class="single-input-secondary">
              </div>
              <div class="mt-10">
                <input type="password" name="password_confirmation" placeholder="Ponovite novu lozinku" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Ponovite novu lozinku'"
                       required class="single-input-secondary">
              </div>
              <div class="mt-10">
                <button type="submit" style="margin-top:10px" class="genric-btn success circle">Promenite</button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
  </div>

@endsection