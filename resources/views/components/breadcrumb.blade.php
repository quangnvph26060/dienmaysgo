<div class="page-header">
    <ul class="breadcrumbs mb-3">
        <li class="nav-home">
            <a href="{{ url('admin') }}">
                <i class="icon-home"></i>
            </a>
        </li>
        <li class="separator">
            <i class="icon-arrow-right"></i>
        </li>
        @if (isset($redirect))
            <li class="nav-item">
                <a href="{{ $redirect['route'] }}">{{ $redirect['title'] }}</a>
            </li>
            <li class="separator">
                <i class="icon-arrow-right"></i>
            </li>
        @endif
        <li class="nav-item">
            <a href="javascript:void(0)">{{ $page }}</a>
        </li>

    </ul>
</div>
