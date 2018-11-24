@extends('themes.'.env('APP_THEME').'.layouts.app')

@section('content')

  {{ \Breadcrumbs::render('wish-list') }}

  <section class="cart_area">
    <div class="container">
      <div class="cart_inner">
        <div class="table-responsive">

          <wish-list-items
              :wish-list-items="{{ json_encode($wishListItems) }}"
          ></wish-list-items>

        </div>
      </div>
    </div>
  </section>

@endsection
<script>
  import WishListItems from "../../../../client/scripts/components/WishListItems";
  export default {
    components: {WishListItems}
  }
</script>