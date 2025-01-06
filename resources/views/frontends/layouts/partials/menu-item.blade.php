@if ($item->childrens->isNotEmpty())
    @foreach ($item->childrens as $child)
        {{-- <li id="menu-item-1608" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-1608">
            <a href="{{ route('products.list', $child->slug) }}">{{ $child->name }}</a>
        </li> --}}
        <div class="submenu-item">
            <a href="{{ route('products.list', $child->slug) }}"> {{ $child->name }}</a>

        </div>
    @endforeach
@endif
