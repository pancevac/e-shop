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
          <h2>Returning Customer?
            <a href="#">Click here to login</a>
          </h2>
        </div>
        <p>If you have shopped with us before, please enter your details in the boxes below. If you are a new customer, please proceed
          to the Billing & Shipping section.</p>
        <form class="row contact_form" action="#" method="post" novalidate="novalidate">
          <div class="col-md-6 form-group p_star">
            <input type="text" class="form-control" id="name" name="name" value=" ">
            <span class="placeholder" data-placeholder="Username or Email"></span>
          </div>
          <div class="col-md-6 form-group p_star">
            <input type="password" class="form-control" id="password" name="password" value="">
            <span class="placeholder" data-placeholder="Password"></span>
          </div>
          <div class="col-md-12 form-group">
            <button type="submit" value="submit" class="btn submit_btn">Send Message</button>
            <div class="creat_account">
              <input type="checkbox" id="f-option" name="selector">
              <label for="f-option">Remember me</label>
            </div>
            <a class="lost_pass" href="#">Lost your password?</a>
          </div>
        </form>
      </div>
      @endguest

      <checkout-form
        :cart-items="{{ json_encode($cartItems) }}"
        sub-total="{{ $subTotal }}"
        total="{{ $total }}"
        discount="{{ $discount }}"
        :coupon="{{ session()->has('coupon') ? json_encode(session('coupon')) : json_encode(null) }}"
        :user="{{ json_encode($user) }}"
      ></checkout-form>

    </div>
  </section>

@endsection