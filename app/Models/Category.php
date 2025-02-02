<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Category extends Model
{
    use SoftDeletes;

    protected $dateFormat = 'U';

    protected $table = 'categories';
    protected $fillable = [
        'name',
        'slug',
        'parent_id',
    ];

    public function getRouteKeyName()
    {
        return 'slug'; // Resolve category by slug
    }


    // Relationship with Parent Category
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Relationship with Products (many-to-many)
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'product_category');
    }
}
