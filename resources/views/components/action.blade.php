<div class="action">
    @if (isset($urlEdit))
        <a class="href-edit" href="{{ $urlEdit }}">sửa</a>
    @else
        <button class="btn-edit p-0 text-primary" style="outline: none; border: none; background: none;"
            data-resource="{{ $row }}">sửa</button>
    @endif
    |
    <form action="{{ $urlDestroy }}" method="POST" style="display: inline;">
        @csrf
        @method('DELETE')
        <button style="outline: none; background: none; border: none" class="text-danger p-0 btn-destroy">xóa</button>
    </form>
</div>
