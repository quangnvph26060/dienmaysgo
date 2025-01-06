<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class configFilter extends Model
{
    use HasFactory;

    protected $fillable = [
        'filter_type',
        'title',
        'attribute_id'
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
