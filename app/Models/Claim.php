<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Claim extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'item_id',
        'user_id',
        'message',
        'status',
        'is_resolved',
        'claim_reference',
    ];
    protected $casts = [ 'is_resolved' => 'boolean',];

    /**
     * Get the item associated with the claim.
     */
    public function item(): BelongsTo
    {
        return $this->belongsTo(Item::class);
    }

    /**
     * Get the user who made the claim.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}