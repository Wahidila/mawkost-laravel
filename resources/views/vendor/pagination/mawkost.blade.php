@if ($paginator->hasPages())
<nav class="pagination">
    {{-- Previous Page Link --}}
    @if ($paginator->onFirstPage())
        <span class="disabled" aria-disabled="true">
            <i class="fa-solid fa-chevron-left" style="font-size: 0.75rem;"></i>
        </span>
    @else
        <a href="{{ $paginator->previousPageUrl() }}" rel="prev">
            <i class="fa-solid fa-chevron-left" style="font-size: 0.75rem;"></i>
        </a>
    @endif

    {{-- Pagination Elements --}}
    @foreach ($elements as $element)
        {{-- "Three Dots" Separator --}}
        @if (is_string($element))
            <span class="disabled" aria-disabled="true">{{ $element }}</span>
        @endif

        {{-- Array Of Links --}}
        @if (is_array($element))
            @foreach ($element as $page => $url)
                @if ($page == $paginator->currentPage())
                    <span class="active" aria-current="page">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
        @endif
    @endforeach

    {{-- Next Page Link --}}
    @if ($paginator->hasMorePages())
        <a href="{{ $paginator->nextPageUrl() }}" rel="next">
            <i class="fa-solid fa-chevron-right" style="font-size: 0.75rem;"></i>
        </a>
    @else
        <span class="disabled" aria-disabled="true">
            <i class="fa-solid fa-chevron-right" style="font-size: 0.75rem;"></i>
        </span>
    @endif
</nav>
@endif
