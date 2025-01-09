<div class="page-title shop-page-title product-page-title" style="margin-left: 20px">
    <div class="page-title-inner flex-row medium-flex-wrap container">
        <div class="flex-col flex-grow medium-text-center">
            <div class="is-small">
                <nav class="woocommerce-breadcrumb breadcrumbs ">
                    <a href="{{ url('/') }}">Trang chủ</a>
                    <span class="divider">&#47;</span>
                    @if (isset($category) && !is_null($category))
                        @if ($category->parent)
                            <a
                                href="{{ route('products.list', $category->parent->slug) }}">{{ $category->parent->name }}</a>
                            <span class="divider">&#47;</span>
                        @endif

                        <a href="javascript::void(0)">{{ $category->name }}</a>
                    @endif

                    @isset($product)
                        @if ($product->category)
                            <a
                                href="{{ route('products.list', $product->category->slug) }}">{{ $product->category->name }}</a>
                            <span class="divider">&#47;</span>
                        @endif

                        <a href="javascript::void(0)">{{ $product->name }}</a>
                    @endisset

                    @if (isset($title) && !is_null($title))
                        <a href="{{ $redirect }}">{{ $title }}</a>
                        <span class="divider">&#47;</span>
                    @endif

                    @isset($name)
                        <a href="javascript::void(0)">{{ $name }}</a>
                    @endisset

                </nav>
            </div>
        </div>

        <div class="flex-col medium-text-center">
        </div>
    </div>
</div>
