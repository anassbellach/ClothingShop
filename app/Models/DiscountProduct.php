<?php

// DiscountProduct.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountProduct extends Model
{
    use SoftDeletes;
    protected $dateFormat = 'U';

    protected $table = 'discount_product';

    protected $fillable = [
        'discount_id',
        'product_id'
    ];
}
