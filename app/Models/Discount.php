<?php

// Discount.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use SoftDeletes;
    protected $dateFormat = 'U';

    protected $table = 'discounts';

    protected $fillable = [
        'code',
        'type',
        'value',
        'max_uses',
        'used_count',
        'starts_at',
        'expires_at'
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'discount_product')
            ->withTimestamps()
            ->withPivot('deleted_at');
    }
}
