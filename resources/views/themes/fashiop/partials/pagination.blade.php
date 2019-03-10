
@if ($paginator->hasPages())

  <nav class="cat_page mx-auto" aria-label="Page navigation example">
    <ul class="pagination">

      @if (! $paginator->onFirstPage())

      <li class="page-item">
        <a class="page-link" href="{{ $paginator->previousPageUrl() }}">
          <i class="fa fa-chevron-left" aria-hidden="true"></i>
        </a>
      </li>

      @endif

      @foreach($elements as $element)

          {{-- "Three Dots" Separator --}}
          @if (is_string($element))
            <li class="disabled" aria-disabled="true">
              <span>{{ $element }}</span>
            </li>
          @endif

          @if (is_array($element))

            @foreach ($element as $page => $url)
              @if ($page == $paginator->currentPage())
                <li class="page-item active" aria-current="page"><a class="page-link">{{ $page }}</a></li>
              @else
                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
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
        @endif

    </ul>
  </nav>

@endif