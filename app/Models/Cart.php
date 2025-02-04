<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Cart extends Model
{
    use SoftDeletes;

    protected $dateFormat = 'U';

    protected $table = 'carts';

    protected $fillable = [
        'user_id',
        'session_id',
    ];

    // Relationship with User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relationship with CartItems
    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }
}
