<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Wishlist extends Model
{
    protected $fillable = [
        'user_id',
        'book_id',
        'price_when_added',
        'notified_at',
    ];

    protected $casts = [
        'price_when_added' => 'decimal:2',
        'notified_at' => 'datetime',
    ];

    /**
     * Get the user that owns the wishlist item.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the book in the wishlist.
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Check if the book price has dropped since added to wishlist.
     */
    public function hasPriceDropped(): bool
    {
        if (!$this->price_when_added) {
            return false;
        }

        return $this->book->price < $this->price_when_added;
    }

    /**
     * Get the discount percentage since added.
     */
    public function getDiscountPercentageAttribute(): float
    {
        if (!$this->price_when_added || $this->price_when_added <= 0) {
            return 0;
        }

        if ($this->book->price >= $this->price_when_added) {
            return 0;
        }

        return round((($this->price_when_added - $this->book->price) / $this->price_when_added) * 100, 1);
    }

    /**
     * Get the price difference (savings).
     */
    public function getSavingsAttribute(): float
    {
        if (!$this->price_when_added) {
            return 0;
        }

        $savings = $this->price_when_added - $this->book->price;
        return $savings > 0 ? $savings : 0;
    }

    /**
     * Scope for items with price drop.
     */
    public function scopeWithPriceDrop($query)
    {
        return $query->whereHas('book', function ($q) {
            $q->whereColumn('books.price', '<', 'wishlists.price_when_added');
        });
    }

    /**
     * Scope for items not yet notified.
     */
    public function scopeNotNotified($query)
    {
        return $query->whereNull('notified_at');
    }
}
