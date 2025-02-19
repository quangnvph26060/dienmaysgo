<script type="application/ld+json">
    {
        "@context": "https://schema.org/",
        "@type": "Product",
        "name": "{{ $product['name'] }}",
        "image": "{{ $product['image'] }}",
        "description": "{{ $product['description'] }}",
        "brand": {
            "@type": "Brand",
            "name": "{{ $product['brand']['name'] ?? '' }}"
        },
        "offers": {
            "@type": "Offer",
            "url": "{{ url()->current() }}",
            "priceCurrency": "VND",
            "price": "{{ $product['price'] }}",
            "availability": "https://schema.org/availability",
            "itemCondition": "https://schema.org/NewCondition"
        },
        "aggregateRating": {
            "@type": "AggregateRating",
            "ratingValue": "4.5",
            "reviewCount": "{{ $product['view_count'] }}"
        }
    }
    </script>
