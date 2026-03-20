<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Item extends Model
{
    // Allow mass assignment for these fields
    protected $fillable = [
        'item_name', 
        'type', 
        'category', 
        'description', 
        'location', 
        'image'
        ];

    /**
     * Get the user that owns the item.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get all claims for this item.
     */
    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class);
    }
}
