@if ($item->childrens->isNotEmpty())
    @foreach ($item->childrens as $child)
        <li id="menu-item-1608" class="menu-item menu-item-type-taxonomy menu-item-object-product_cat menu-item-1608">
            <a href="https://dienmaysgo.com/may-phat-dien-honda/">{{ $child->name }}</a>
        </li>
    @endforeach
@endif