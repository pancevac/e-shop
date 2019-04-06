@extends('layouts.app')

@section('breadcrumbs')
  {{ \Breadcrumbs::render('shopping-cart') }}
@endsection

@section('content')

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
          <h6>Ukloni</h6>
        </div>
        <div class="col-md-3">
          <h6>Dodaj</h6>
        </div>
      </div>
    </div>

    <wish-list
      :wish-list="{{ json_encode($wishListItems) }}"
    ></wish-list>

  </div>

@endsection