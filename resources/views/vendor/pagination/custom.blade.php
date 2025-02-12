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
                $start = max(2, $currentPage - 1);
                $end = min($lastPage - 1, $currentPage + 1);
            @endphp

            {{-- Trang 1 luôn hiển thị --}}
            <li>
                <a class="page-number {{ $currentPage == 1 ? 'current' : '' }}" href="{{ $paginator->url(1) }}">1</a>
            </li>

            {{-- Dấu ... nếu cần --}}
            @if ($start > 2)
                <li><span class="page-number disabled">...</span></li>
            @endif

            {{-- Hiển thị các trang gần trang hiện tại --}}
            @for ($i = $start; $i <= $end; $i++)
                <li>
                    @if ($i == $currentPage)
                        <span aria-current="page" class="page-number current">{{ $i }}</span>
                    @else
                        <a class="page-number" href="{{ $paginator->url($i) }}">{{ $i }}</a>
                    @endif
                </li>
            @endfor

            {{-- Dấu ... nếu cần --}}
            @if ($end < $lastPage - 1)
                <li><span class="page-number disabled">...</span></li>
            @endif

            {{-- Trang cuối luôn hiển thị --}}
            @if ($lastPage > 1)
                <li>
                    <a class="page-number {{ $currentPage == $lastPage ? 'current' : '' }}" href="{{ $paginator->url($lastPage) }}">{{ $lastPage }}</a>
                </li>
            @endif

            {{-- Trang kế tiếp --}}
            @if ($paginator->hasMorePages())
                <li>
                    <a class="page-number" href="{{ $paginator->nextPageUrl() }}"><i class="icon-angle-right"></i></a>
                </li>
            @else
                <li>
                    <span class="page-number disabled"><i class="icon-angle-right"></i></span>
                </li>
            @endif
        </ul>
    </nav>
@endif
