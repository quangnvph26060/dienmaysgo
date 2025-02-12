<?php

namespace App\Listeners;

use App\Events\OrderPlaced;
use App\Models\SgoProduct;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReduceProductStock
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderPlaced $event): void
    {
        $order = $event->order;

        DB::transaction(function () use ($order) {
            foreach ($order->products as $product) {
                $lockedProduct = SgoProduct::where('id', $product->id)
                    ->lockForUpdate()
                    ->first();

                if ($lockedProduct->quantity >= $product->pivot->p_qty) {
                    $lockedProduct->decrement('quantity', $product->pivot->p_qty);
                } else {
                    // Log lỗi để theo dõi sản phẩm không đủ hàng
                    Log::error("Not enough stock for product ID: {$product->id}");
                    throw new \Exception("Not enough stock for product ID: {$product->id}");
                }
            }
        });
    }
}
