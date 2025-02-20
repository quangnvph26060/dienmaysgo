<?php

namespace App\Jobs;

use App\Http\Controllers\admin\BulkActionController;
use App\Models\SgoProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class GenerateProductDescription implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    public $product;
    public $prompt;

    public function __construct(SgoProduct $product, $prompt)
    {
        $this->product = $product;
        $this->prompt = $prompt;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            // Tạo prompt yêu cầu AI tạo description chuẩn SEO

            $gemini = new BulkActionController();

            $html =  $gemini->generatePrompt($this->prompt);

            $this->product->update([
                'description' => $html,
            ]);
        } catch (\Exception $e) {
            logInfo('Lỗi khi tạo mô tả sản phẩm: ' . $e->getMessage());
        }
    }
}
