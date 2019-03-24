<div class="filter-bar d-flex flex-wrap align-items-center">
  <a href="#" class="grid-btn active"><i class="fa fa-th" aria-hidden="true"></i></a>
  <a href="#" class="list-btn"><i class="fa fa-th-list" aria-hidden="true"></i></a>
  <div class="sorting">
    <select name="sort" onchange="document.getElementById('filters').submit()">
      <option value="1" @if(request('sort') == 1) selected @endif>Po nazivu</option>
      <option value="2" @if(request('sort') == 2) selected @endif>Cena rastuća</option>
      <option value="3" @if(request('sort') == 3) selected @endif>Cena opadajuća</option>
    </select>
  </div>
  <div class="sorting mr-auto">
    <select name="show" onchange="document.getElementById('filters').submit()">
      <option value="10" @if(request('show') == 10) selected @endif>Prikazi 10</option>
      <option value="20" @if(request('show') == 20) selected @endif>Prikazi 20</option>
      <option value="30" @if(request('show') == 30) selected @endif>Prikazi 30</option>
    </select>
  </div>

  {{ $products->appends(request()->input())->links('partials.pagination') }}

</div>