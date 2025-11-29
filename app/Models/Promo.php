<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Promo extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'description',
        'type',
        'discount_type',
        'discount_value',
        'max_discount',
        'min_purchase',
        'banner_image',
        'start_date',
        'end_date',
        'is_active',
        'apply_to_all_books',
    ];

    protected $casts = [
        'discount_value' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'apply_to_all_books' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($promo) {
            if (empty($promo->slug)) {
                $promo->slug = Str::slug($promo->name);
            }
        });
    }

    /**
     * Get books in this promo
     */
    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, 'promo_book');
    }

    /**
     * Check if promo is currently active
     */
    public function isCurrentlyActive(): bool
    {
        $now = now();
        return $this->is_active 
            && $now->greaterThanOrEqualTo($this->start_date) 
            && $now->lessThanOrEqualTo($this->end_date);
    }

    /**
     * Check if promo has ended
     */
    public function hasEnded(): bool
    {
        return now()->greaterThan($this->end_date);
    }

    /**
     * Check if promo hasn't started yet
     */
    public function hasNotStarted(): bool
    {
        return now()->lessThan($this->start_date);
    }

    /**
     * Get remaining time in seconds
     */
    public function getRemainingSeconds(): int
    {
        if ($this->hasEnded()) {
            return 0;
        }
        return now()->diffInSeconds($this->end_date, false);
    }

    /**
     * Calculate discount for a given price
     */
    public function calculateDiscount(float $price): float
    {
        if ($price < $this->min_purchase) {
            return 0;
        }

        if ($this->discount_type === 'percentage') {
            $discount = $price * ($this->discount_value / 100);
            if ($this->max_discount && $discount > $this->max_discount) {
                return $this->max_discount;
            }
            return $discount;
        }

        return min($this->discount_value, $price);
    }

    /**
     * Get discounted price for a book
     */
    public function getDiscountedPrice(Book $book): float
    {
        $discount = $this->calculateDiscount($book->price);
        return max(0, $book->price - $discount);
    }

    /**
     * Scope for active promos
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where('start_date', '<=', now())
            ->where('end_date', '>=', now());
    }

    /**
     * Scope for flash sales
     */
    public function scopeFlashSale($query)
    {
        return $query->where('type', 'flash_sale');
    }

    /**
     * Get promo type label
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'flash_sale' => 'Flash Sale',
            'seasonal' => 'Seasonal',
            'clearance' => 'Clearance',
            'bundle' => 'Bundle',
            default => $this->type,
        };
    }

    /**
     * Get discount label
     */
    public function getDiscountLabelAttribute(): string
    {
        if ($this->discount_type === 'percentage') {
            return (int)$this->discount_value . '%';
        }
        return 'Rp ' . number_format($this->discount_value, 0, ',', '.');
    }
}
