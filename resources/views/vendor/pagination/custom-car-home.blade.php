@if ($paginator->hasPages())
    <div class="custom-pagination">
        <div class="pagination-container">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <a class="page-link disabled" aria-disabled="true">
                    <i class="fas fa-chevron-left"></i>
                </a>
            @else
                <a class="page-link" href="{{ $paginator->previousPageUrl() }}" rel="prev">
                    <i class="fas fa-chevron-left"></i>
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                @if ($page == $paginator->currentPage())
                    <a class="page-link active">{{ $page }}</a>
                @else
                    <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a class="page-link" href="{{ $paginator->nextPageUrl() }}" rel="next">
                    <i class="fas fa-chevron-right"></i>
                </a>
            @else
                <a class="page-link disabled" aria-disabled="true">
                    <i class="fas fa-chevron-right"></i>
                </a>
            @endif
        </div>

        <div class="pagination-info">
            Showing {{ $paginator->firstItem() }} to {{ $paginator->lastItem() }} of {{ $paginator->total() }} results
        </div>
    </div>
@endif
