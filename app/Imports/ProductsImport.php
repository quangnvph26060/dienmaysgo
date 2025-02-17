<?php

namespace App\Imports;

use App\Jobs\ProcessProductImport;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class ProductsImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        $batchSize = 100; // Số lượng sản phẩm mỗi batch
        $chunks = $rows->chunk($batchSize);

        foreach ($chunks as $chunk) {
            ProcessProductImport::dispatch($chunk->toArray());
        }
    }
}
