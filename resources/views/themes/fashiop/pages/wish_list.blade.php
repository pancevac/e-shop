@extends('themes.'.env('APP_THEME').'.layouts.app')

@section('content')

  {{ \Breadcrumbs::render('wish-list') }}

  <section class="cart_area">
    <div class="container">
      <div class="cart_inner">
        <div class="table-responsive">

          <wish-list
              :wish-list-items="{{ json_encode($wishListItems) }}"
          ></wish-list>

        </div>
      </div>
    </div>
  </section>

@endsection
<script>
  import WishListItems from "../../../../client/scripts/components/WishList";
  export default {
    components: {WishListItems}
  }
</script>