<script>
    const columns = [{
            data: "checkbox",
            name: "checkbox",
            orderable: false,
            searchable: false,
            width: "5px",
            className: "text-center"
        },
        {
            data: 'name',
            name: 'name',
            render: function(data, type, row) {
                return '<a href="' + '{{ route('admin.product.detail', '__id__') }}'
                    .replace('__id__', row.id) + '">' + data + '</a>';
            }
        },
        {
            data: 'quantity',
            name: 'quantity',
        },
        {
            data: 'import_price',
            name: 'import_price'
        },
        {
            data: 'price',
            name: 'price'
        },
        {
            data: 'category_id',
            name: 'category_id'
        },
        {
            data: 'view_count',
            name: 'view_count',
            width: '10%'
        },
        {
            data: 'created_at',
            name: 'created_at'
        },
    ];
</script>
