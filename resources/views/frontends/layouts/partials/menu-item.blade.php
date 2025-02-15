@if ($item->childrens->isNotEmpty())
    @foreach ($item->childrens as $child)
        <li> <a href="{{ route('products.detail', $child->slug) }}"> {{ $child->name }}</a></li>
    @endforeach
@endif
