<div class="page-title shop-page-title product-page-title"
    style="margin:0 20px; max-width: 1230px; margin: auto;">
    <div class="page-title-inner flex-row medium-flex-wrap">
        <div class="flex-col flex-grow medium-text-center">
            <div class="is-small">
                <nav class="woocommerce-breadcrumb breadcrumbs ">
                    <a href="{{ url('/') }}">Trang chủ</a>
                    <span class="divider">&#47;</span>
                    @if (isset($category) && !is_null($category))
                        @if ($category->parent)
                            <a
                                href="{{ route('products.list', $category->parent->slug) }}">{{ convertToSentenceCase($category->parent->name) }}</a>
                            <span class="divider">&#47;</span>
                        @endif

                        <a href="javascript::void(0)">{{ convertToSentenceCase($category->name) }}</a>
                    @endif

                    @isset($product)
                        @if ($product->category)
                            <a
                                href="{{ route('products.list', $product->category->slug) }}">{{ convertToSentenceCase($product->category->name) }}</a>
                            <span class="divider">&#47;</span>
                        @endif

                        <a href="javascript::void(0)">{{ convertToSentenceCase($product->name) }}</a>
                    @endisset

                    @if (isset($title) && !is_null($title))
                        <a href="{{ $redirect }}">{{ convertToSentenceCase($title) }}</a>
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
