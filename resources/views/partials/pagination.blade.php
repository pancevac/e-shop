@if ($paginator->hasPages())

<div class="pagination">

  @if (! $paginator->onFirstPage())
    <a href="{{ $paginator->previousPageUrl() }}" class="prev-arrow">
      <i class="fa fa-long-arrow-left" aria-hidden="true"></i>
    </a>
  @endif

  @foreach($elements as $element)

      {{-- "Three Dots" Separator --}}
      @if (is_string($element))
        <a href="#" class="dot-dot"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
      @endif

      @if (is_array($element))
        @foreach ($element as $page => $url)
          @if ($page == $paginator->currentPage())
            <a href="#" class="active">{{ $page }}</a>
          @else
            <a href="{{ $url }}">{{ $page }}</a>
          @endif
        @endforeach
      @endif

      {{-- Next Page Link --}}
      @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" class="next-arrow">
          <i class="fa fa-long-arrow-right" aria-hidden="true"></i>
        </a>
      @endif

  @endforeach
</div>

@endif