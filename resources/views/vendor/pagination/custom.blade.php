@if ($paginator->hasPages())
    <nav class="woocommerce-pagination">
        <ul class="page-numbers nav-pagination links text-center">
            {{-- Trang trước --}}
            @if ($paginator->onFirstPage())
                <li>
                    <span class="page-number disabled"><i class="icon-angle-left"></i></span>
                </li>
            @else
                <li>
                    <a class="page-number" href="{{ $paginator->previousPageUrl() }}"><i class="icon-angle-left"></i></a>
                </li>
            @endif

            {{-- Các trang --}}
            @php
                $currentPage = $paginator->currentPage();
                $lastPage = $paginator->lastPage();
            @endphp

            {{-- Trang đầu tiên --}}
            <li>
                <a class="page-number" href="{{ $paginator->url(1) }}">1</a>
            </li>

            {{-- Dấu "..." nếu cần --}}
            @if ($currentPage > 4)
                <li><span class="page-number disabled">...</span></li>
            @endif

            {{-- Các trang gần trang hiện tại --}}
            @for ($page = max(2, $currentPage - 1); $page <= min($lastPage - 1, $currentPage + 1); $page++)
                @if ($page == $currentPage)
                    <li>
                        <span aria-current="page" class="page-number current">{{ $page }}</span>
                    </li>
                @else
                    <li>
                        <a class="page-number" href="{{ $paginator->url($page) }}">{{ $page }}</a>
                    </li>
                @endif
            @endfor

            {{-- Dấu "..." nếu cần --}}
            @if ($currentPage < $lastPage - 3)
                <li><span class="page-number disabled">...</span></li>
            @endif

            {{-- Trang cuối cùng --}}
            <li>
                <a class="page-number" href="{{ $paginator->url($lastPage) }}">{{ $lastPage }}</a>
            </li>

            {{-- Trang kế tiếp --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="page-number" href="{{ $paginator->nextPageUrl() }}"><i class="fas fa-angle-right"></i></a>
                </li>
            @else
                <li>
                    <span class="page-number disabled"><i class="fas fa-angle-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@endif
