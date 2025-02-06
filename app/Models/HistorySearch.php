<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorySearch extends Model
{
    use HasFactory;

    protected $fillable = [
        'keywords',
        'ip_address',
        'user_agent',
    ];

    public static function insert($keywords)
    {
        $data = [
            'keywords' => $keywords,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ];

        self::create($data);
    }

    public static function getAll($startDate = null, $endDate = null)
    {
        $query = self::query()
            ->selectRaw('keywords, COUNT(*) as count')
            ->groupBy('keywords')
            ->orderByDesc('count');

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
