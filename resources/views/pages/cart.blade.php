@extends('layouts.app')

@section('breadcrumbs')
  {{ \Breadcrumbs::render('shopping-cart') }}
@endsection

@section('content')

  <!-- Start Cart Area -->
  <div class="container" style="margin-bottom: 50px;">
    <div class="cart-title">
      <div class="row">
        <div class="col-md-5">
          <h6 class="ml-15">Proizvod</h6>
        </div>
        <div class="col-md-2">
          <h6>Cena</h6>
        </div>
        <div class="col-md-2">
          <h6>Količina</h6>
        </div>
        <div class="col-md-2">
          <h6>Ukupna cena</h6>
        </div>
        <div class="col-md-1">
          <h6>Ukloni</h6>
        </div>
      </div>
    </div>

    <cart-page inline-template>

      <div>
        <cart-list></cart-list>

        <div class="cupon-area d-flex align-items-center justify-content-between flex-wrap">
          <a href="{{ url()->previous() }}" class="view-btn color-2"><span>Nastavite kupovinu</span></a>

          <div v-if="!getCoupon" class="cuppon-wrap d-flex align-items-center flex-wrap">
            <div class="cupon-code">
              <input type="text" v-model="coupon">
              <button type="button" class="view-btn color-2" @click.prevent="submitCoupon"><span>Primenite</span></button>
            </div>
            <a href="#" class="view-btn color-2 have-btn"><span>Imate kupon?</span></a>
          </div>

        </div>

        <div v-if="getCoupon" class="subtotal-area d-flex align-items-center justify-content-end">
          <div class="title text-uppercase">Cena</div>
          <div class="subtotal">@{{ getSubTotalPrice }}</div>
        </div>

        <div v-if="getCoupon" class="subtotal-area d-flex align-items-center justify-content-end">
          <div class="title text-uppercase">
            Popust (@{{ getCoupon.code }})
            <a href="#" @click.prevent="removeCoupon">Ukloni kupon</a>
          </div>
          <div class="subtotal">-@{{ getDiscountPrice }}</div>
        </div>

        <div class="subtotal-area d-flex align-items-center justify-content-end">
          <div class="title text-uppercase">Ukupna cena</div>
          <div class="subtotal">@{{ getTotalPrice }}</div>
        </div>
      </div>
    </cart-page>

    <div class="shipping-area d-flex justify-content-end">
      {{--<div class="tile text-uppercase">Shipping</div>--}}
      <form action="{{ route('checkout') }}" class="d-inline-flex flex-column align-items-end">
        {{--<ul class="d-flex flex-column align-items-end">
          <li class="filter-list">
            <label for="flat-rate">Flat Rate:<span>$5.00</span></label>
            <input class="pixel-radio" type="radio" id="flat-rate" name="brand">
          </li>
          <li class="filter-list">
            <label for="free-shipping">Free Shipping</label>
            <input class="pixel-radio" type="radio" id="free-shipping" name="brand">
          </li>
          <li class="filter-list">
            <label for="flat-rate-2">Flat Rate:<span>$10.00</span></label>
            <input class="pixel-radio" type="radio" id="flat-rate-2" name="brand">
          </li>
          <li class="filter-list">
            <label for="local-delivery">Local Delivery:<span>$2.00</span></label>
            <input class="pixel-radio" type="radio" id="local-delivery" name="brand">
          </li>
          <li class="calculate">Calculate Shipping</li>
        </ul>
        <div class="sorting">
          <select>
            <option value="1">Bangladesh</option>
            <option value="1">India</option>
            <option value="1">Srilanka</option>
          </select>
        </div>
        <div class="sorting mt-20">
          <select>
            <option value="1">Select a State</option>
            <option value="1">Select a State</option>
            <option value="1">Select a State</option>
          </select>
        </div>
        <input type="text" placeholder="Postcode/Zipcode" onfocus="this.placeholder=''"
               onblur="this.placeholder = 'Postcode/Zipcode'" required class="common-input mt-10">--}}
        <button type="submit" class="view-btn color-2 mt-10"><span>Checkout</span></button>
      </form>

    </div>

  </div>
  <!-- End Cart Area -->

@endsection