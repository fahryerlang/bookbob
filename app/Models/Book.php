<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'author',
        'publisher',
        'year_published',
        'isbn',
        'description',
        'price',
        'stock',
        'cover_image',
        'is_active',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Get the category that owns the book.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the carts for the book.
     */
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the order items for the book.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the wishlists for the book.
     */
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Get the users who wishlisted this book.
     */
    public function wishlistedBy()
    {
        return $this->belongsToMany(User::class, 'wishlists')
            ->withPivot('price_when_added', 'notified_at')
            ->withTimestamps();
    }

    /**
     * Get wishlist count for this book.
     */
    public function getWishlistCountAttribute(): int
    {
        return $this->wishlists()->count();
    }

    /**
     * Get the reviews for the book.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get average rating for the book.
     */
    public function getAverageRatingAttribute(): float
    {
        return round($this->reviews()->avg('rating') ?? 0, 1);
    }

    /**
     * Get review count for the book.
     */
    public function getReviewCountAttribute(): int
    {
        return $this->reviews()->count();
    }

    /**
     * Get rating breakdown (count per star).
     */
    public function getRatingBreakdown(): array
    {
        $breakdown = [];
        for ($i = 5; $i >= 1; $i--) {
            $breakdown[$i] = $this->reviews()->where('rating', $i)->count();
        }
        return $breakdown;
    }

    /**
     * Get promos for this book
     */
    public function promos(): BelongsToMany
    {
        return $this->belongsToMany(Promo::class, 'promo_book');
    }

    /**
     * Get active promo for this book
     */
    public function getActivePromoAttribute(): ?Promo
    {
        // First check specific book promos
        $promo = $this->promos()->active()->first();
        
        if (!$promo) {
            // Check promos that apply to all books
            $promo = Promo::active()->where('apply_to_all_books', true)->first();
        }
        
        return $promo;
    }

    /**
     * Get active promo (method alias)
     */
    public function getActivePromo(): ?Promo
    {
        return $this->active_promo;
    }

    /**
     * Get discounted price if there's an active promo
     */
    public function getDiscountedPriceAttribute(): ?float
    {
        $promo = $this->active_promo;
        if ($promo) {
            return $promo->getDiscountedPrice($this);
        }
        return null;
    }

    /**
     * Get discounted price (method alias)
     */
    public function getDiscountedPrice(): float
    {
        return $this->discounted_price ?? $this->price;
    }

    /**
     * Get discount percentage for display
     */
    public function getDiscountPercentageAttribute(): ?int
    {
        $promo = $this->active_promo;
        if ($promo && $promo->discount_type === 'percentage') {
            return (int)$promo->discount_value;
        }
        if ($promo && $promo->discount_type === 'fixed') {
            return (int)(($promo->discount_value / $this->price) * 100);
        }
        return null;
    }

    /**
     * Check if book is on sale
     */
    public function getIsOnSaleAttribute(): bool
    {
        return $this->active_promo !== null;
    }

    /**
     * Check if book is on sale (method alias)
     */
    public function isOnSale(): bool
    {
        return $this->is_on_sale;
    }
}
