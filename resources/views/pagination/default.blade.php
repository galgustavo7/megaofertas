@if ($paginator->hasPages())
    <nav class="pagination" role="navigation" aria-label="Paginación">
        @if ($paginator->onFirstPage())
            <span class="page-link disabled">‹ Anterior</span>
        @else
            <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">‹ Anterior</a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="page-link dots">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="page-link current">{{ $page }}</span>
                    @else
                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">Siguiente ›</a>
        @else
            <span class="page-link disabled">Siguiente ›</span>
        @endif
    </nav>
@endif
