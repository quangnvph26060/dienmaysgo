<?php

namespace App\Jobs;

use App\Models\SgoProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ProcessProductImport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $rows;

    public function __construct(array $rows)
    {
        $this->rows = $rows;
    }

    public function handle()
    {
        Log::info('Starting product import process with ' . count($this->rows) . ' products.');

        $data = [];
        $successCount = 0;
        $errorCount = 0;

        foreach ($this->rows as $row) {
            $imageUrl = $row['anh'];

            // Kiểm tra URL hợp lệ
            if (empty($imageUrl) || !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
                Log::warning('Invalid image URL for product: ' . $row['ten']);
                $errorCount++;
                continue;
            }

            try {
                $response = Http::head($imageUrl);
                if ($response->status() == 404) {
                    Log::warning('Image not found for product: ' . $row['ten']);
                    $errorCount++;
                    continue;
                }
            } catch (\Exception $e) {
                Log::error('Error checking image URL for product ' . $row['ten'] . ': ' . $e->getMessage());
                $errorCount++;
                continue;
            }

            try {
                $imageContents = file_get_contents($imageUrl);
                $imageName = 'products/' . Str::random(10) . '.' . pathinfo($imageUrl, PATHINFO_EXTENSION);
                Storage::put($imageName, $imageContents);
                $imagePath = $imageName;
                Log::info('Successfully downloaded image for product: ' . $row['ten']);
            } catch (\Exception $e) {
                $imagePath = null;
                Log::error('Error downloading image for product ' . $row['ten'] . ': ' . $e->getMessage());
                $errorCount++;
            }

            $data[] = [
                'name'           => $row['ten'],
                'slug'           => Str::slug($row['ten']),
                'image'          => $imagePath,
                'price'          => $row['gia_goc'],
                'discount_value' => $row['gia_giam'],
                'import_price'   => 100000,
                'brand_id'       => 23,
                'created_at'     => now(),
                'updated_at'     => now(),
            ];

            $successCount++;
        }

        if (!empty($data)) {
            SgoProduct::insert($data); // Chèn hàng loạt để tối ưu
            Log::info('Inserted ' . count($data) . ' products into the database.');
        }

        Log::info('Product import process completed. Success: ' . $successCount . ', Errors: ' . $errorCount);
    }
}
