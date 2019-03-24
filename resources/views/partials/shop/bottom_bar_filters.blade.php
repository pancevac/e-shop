<div class="filter-bar d-flex flex-wrap align-items-center">

  <div class="sorting mr-auto">
    <select name="show" onchange="document.getElementById('filters').submit()">
      <option value="10" @if(request('show') == 10) selected @endif>Prikazi 10</option>
      <option value="20" @if(request('show') == 20) selected @endif>Prikazi 20</option>
      <option value="30" @if(request('show') == 30) selected @endif>Prikazi 30</option>
    </select>
  </div>

  {{ $products->appends(request()->input())->links('partials.pagination') }}

</div>