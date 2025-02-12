<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProductView extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'ip_address', 'user_agent', 'view_count', 'start_time', 'end_time'];

    public function product()
    {
        return $this->belongsTo(SgoProduct::class);
    }

    public static function getAverageTimePerProduct($startDate = null, $endDate = null)
    {
        $query = DB::table('product_views')
            ->select('product_id', DB::raw('AVG(TIMESTAMPDIFF(SECOND, start_time, end_time)) AS avg_time_seconds'))
            ->groupBy('product_id');

        // Nếu có startDate và endDate, lọc theo thời gian
        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate, $endDate]);
        }
        // Nếu chỉ có endDate, giả định startDate là ngày hôm nay
        elseif ($endDate) {
            $query->where('created_at', '<=', $endDate);
        }
        // Nếu chỉ có startDate, lọc theo thời gian từ startDate đến ngày hôm nay
        elseif ($startDate) {
            $query->where('created_at', '>=', $startDate);
        }

        return $query->get();
    }
}
