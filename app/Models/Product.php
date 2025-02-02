<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use SoftDeletes;

    protected $dateFormat = 'U';

    protected $table = 'products';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'sale_price',
        'sku',
        'stock_quantity',
        'is_active',
    ];

    public function getRouteKeyName()
    {
        return 'slug'; // Resolve product by slug
    }


    // Relationship with ProductImage
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }

    // Relationship with Category (many-to-many)
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }
}
