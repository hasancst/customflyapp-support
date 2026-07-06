
@if ($paginator->hasPages())
    <div class="pagination-container">
        <ul class="pagination">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true">
                    <span>&lsaquo;</span>
                </li>
            @else
                <li class="page-item">
                    <a href="{{ $paginator->previousPageUrl() }}" rel="prev">&lsaquo;</a>
                </li>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li class="page-item disabled" aria-disabled="true"><span>{{ $element }}</span></li>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li class="page-item active" aria-current="page"><span>{{ $page }}</span></li>
                        @else
                            <li class="page-item"><a href="{{ $url }}">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <a href="{{ $paginator->nextPageUrl() }}" rel="next">&rsaquo;</a>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true">
                    <span>&rsaquo;</span>
                </li>
            @endif
        </ul>
    </div>

    <style>
        .pagination-container {
            display: flex;
            justify-content: center;
            margin-top: 40px;
        }
        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            gap: 5px;
        }
        .pagination .page-item a,
        .pagination .page-item span {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: #fff;
            color: var(--text-color, #333);
            text-decoration: none;
            font-weight: 600;
            border: 1px solid #eee;
            transition: all 0.2s;
        }
        .pagination .page-item.active span {
            background: var(--primary, #4e73df);
            color: #fff;
            border-color: var(--primary, #4e73df);
        }
        .pagination .page-item a:hover {
            background: #f8f9fa;
            border-color: #ddd;
        }
        .pagination .page-item.disabled span {
            opacity: 0.5;
            cursor: not-allowed;
            background: #f8f9fa;
        }
    </style>
@endif
