@if($paginator->hasPages())

  <nav class="cat_page mx-auto" aria-label="Page navigation example">
    <ul class="pagination">

      {{-- Previous page link --}}
      @if($paginator->onFirstPage())
        {{--<li class="page-item">
          <a class="page-link" href="#">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
          </a>
        </li>--}}
      @else
        <li class="page-item">
          <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
            <i class="fa fa-chevron-left" aria-hidden="true"></i>
          </a>
        </li>
      @endif

      {{-- Pagination elements --}}
      @foreach($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if(is_string($element))
          <li class="page-item disabled" aria-disabled="true">
            <span class="page-link">{{ $element }}</span>
          </li>
        @endif

        {{-- Array Of Links --}}
        @if(is_array($element))
          @foreach($element as $page => $url)
            @if($page == $paginator->currentPage())
              <li class="page-item active">
                <a class="page-link">{{ $page }}</a>
              </li>
            @else
              <li class="page-item">
                <a class="page-link" href="{{ $url }}">{{ $page }}</a>
              </li>
            @endif
          @endforeach
        @endif

      @endforeach

      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
        <li class="page-item">
          <a class="page-link" href="{{ $paginator->nextPageUrl() }}">
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
          </a>
        </li>
      @else
        {{--<li class="page-item blank">
          <a class="page-link" href="#">...</a>
        </li>--}}
      @endif

    </ul>
  </nav>

@endif