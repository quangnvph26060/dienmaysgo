<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class DownloadProductImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3; // Số lần thử lại tối đa
    public int $timeout = 120; // Timeout 2 phút

    protected $imageUrl;
    protected $productName;

    public function __construct($imageUrl, $productName)
    {
        $this->imageUrl = $imageUrl;
        $this->productName = $productName;
    }

    public function handle()
    {
        if (empty($this->imageUrl) || !filter_var($this->imageUrl, FILTER_VALIDATE_URL)) {
            Log::warning("Invalid image URL for product: {$this->productName}");
            return null;
        }

        $imageName = 'products/' . md5($this->imageUrl) . '.' . pathinfo($this->imageUrl, PATHINFO_EXTENSION);

        // Kiểm tra ảnh đã tồn tại chưa
        if (Storage::exists($imageName)) {
            Log::info("Image already exists for product: {$this->productName}");
            return $imageName;
        }

        try {
            $response = Http::timeout(5)->get($this->imageUrl);

            if ($response->successful()) {
                Storage::put($imageName, $response->body());
                Log::info("Downloaded image for product: {$this->productName}");
                return $imageName;
            } else {
                Log::warning("Failed to download image for product: {$this->productName}");
                return null;
            }
        } catch (\Exception $e) {
            Log::error("Error downloading image for product {$this->productName}: " . $e->getMessage());
            return null;
        }
    }
}
