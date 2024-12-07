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
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <li>
                        <span class="page-number disabled">{{ $element }}</span>
                    </li>
                @endif

                {{-- Các số trang --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <li>
                                <span aria-current="page" class="page-number current">{{ $page }}</span>
                            </li>
                        @else
                            <li>
                                <a class="page-number" href="{{ $url }}">{{ $page }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
            @endforeach

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
