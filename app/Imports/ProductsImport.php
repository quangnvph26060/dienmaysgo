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
        $batchSize = 10; // Tăng batch size để giảm số lượng job
        $chunks = $rows->chunk($batchSize);

        foreach ($chunks as $chunk) {
            ProcessProductImport::dispatch($chunk->toArray())->onQueue('high'); 
        }
    }
}
