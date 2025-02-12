<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class UpdateOrderStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'orders:update-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update orders status from confirmed to completed after 7 days';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $now = Carbon::now();
        $updatedRows = DB::table('sgo_orders')
            ->where('status', 'confirmed')
            ->where('payment_status', 1) // Chỉ áp dụng nếu đã thanh toán
            ->where('updated_at', '<', $now->subDays(7))
            ->update(['status' => 'completed', 'updated_at' => now()]);

        $this->info("Updated {$updatedRows} orders to completed status.");
    }
}
