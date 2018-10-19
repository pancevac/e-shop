<aside class="left_widgets cat_widgets">
  <div class="l_w_title">
    <h3>Kategorije proizvoda</h3>
  </div>
  <div class="widgets_inner">
    <ul class="list">

        @foreach($categories as $category)
          @if($category->children->count())
            <li>
              <a href="#">{{ $category->title }}</a>
              <ul class="list">
                @foreach($category->children as $child)
                  <li>
                    <a href="#">{{ $child->title }}</a>
                  </li>
                @endforeach
              </ul>
            </li>
          @else
            <li>
              <a href="#">{{ $category->title }}</a>
            </li>
          @endif
        @endforeach

    </ul>
  </div>
</aside>