<div class="sidebar-categories">
  <div class="head">Kategorije proizvoda</div>
  <ul class="main-categories">

    @foreach ($categories as $category)

    <li class="main-nav-list">

      @if ($category->children->count())

      <a data-toggle="collapse" href="#{{ $category->slug }}" aria-expanded="false" aria-controls="{{ $category->slug }}">
        <span class="lnr lnr-arrow-right"></span>
        {{ $category->title }}<span class="number">(53)</span>
      </a>
      <ul class="collapse" id="{{ $category->slug }}" data-toggle="collapse" aria-expanded="false" aria-controls="{{ $category->slug }}">

        @foreach($category->children as $child)

          <li class="main-nav-list child"><a href="#">{{ $child->title }}<span class="number">(13)</span></a></li>

        @endforeach

      </ul>

        @else

        <a href="#">{{ $category->title }}<span class="number">(24)</span></a>

      @endif
    </li>

    @endforeach

  </ul>
</div>