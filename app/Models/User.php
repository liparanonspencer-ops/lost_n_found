<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'profile_photo',
        'email',
        'password',
        'phone_number',
        'email_notifications',
        'show_phone_publicly',
        'theme_preference',
        'role',
        'otp',
        'otp_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'password',
        'remember_token',
        'otp',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'otp_expires_at' => 'datetime',
        ];
    }
    public function getPhotoUrlAttribute()
{
    if ($this->profile_photo) {
        return url('/profiles/' . basename($this->profile_photo));
    }

    // Fallback to a UI Avatar based on the user's name if no photo exists
    return "https://ui-avatars.com/api/?name=" . urlencode($this->first_name . ' ' . $this->last_name) . "&color=7F9CF5&background=EBF4FF";
}

    /**
     * Get all items posted by the user (Lost or Found).
     */
    public function items(): HasMany
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Get all claims made by this user on other people's items.
     */
    public function claims(): HasMany
    {
        return $this->hasMany(Claim::class);
    }
}