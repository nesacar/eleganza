@if ($paginator->hasPages())
    <ul class="e-pagination pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="e-page-item page-item disabled"><span class="e-page-link page-link"><</span></li>
        @else
            <li class="e-page-item page-item"><a class="e-page-link page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev"><</a></li>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="e-page-item page-item disabled"><span class="e-page-link page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="e-page-item page-item active"><span class="e-page-link page-link">{{ $page }}</span></li>
                    @else
                        <li class="e-page-item page-item"><a class="e-page-link page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li class="e-page-item page-item"><a class="e-page-link page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">></a></li>
        @else
            <li class="e-page-item page-item disabled"><span class="e-page-link page-link">></span></li>
        @endif
    </ul>
@endif
