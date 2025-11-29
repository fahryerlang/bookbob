<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'total_amount',
        'subtotal',
        'promo_discount',
        'coupon_discount',
        'coupon_id',
        'coupon_code',
        'status',
        'payment_status',
        'payment_method',
        'shipping_address',
        'shipping_phone',
        'notes',
        'paid_at',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'promo_discount' => 'decimal:2',
        'coupon_discount' => 'decimal:2',
        'paid_at' => 'datetime',
    ];

    /**
     * Get the user that owns the order.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the order items for the order.
     */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get the coupon used for this order.
     */
    public function coupon(): BelongsTo
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * Get coupon usage record
     */
    public function couponUsage()
    {
        return $this->hasOne(CouponUsage::class);
    }

    /**
     * Get total discount
     */
    public function getTotalDiscountAttribute(): float
    {
        return ($this->promo_discount ?? 0) + ($this->coupon_discount ?? 0);
    }

    /**
     * Generate a unique order number.
     */
    public static function generateOrderNumber(): string
    {
        $prefix = 'ORD';
        $date = now()->format('Ymd');
        $random = strtoupper(substr(uniqid(), -5));
        
        return "{$prefix}-{$date}-{$random}";
    }

    /**
     * Get the reviews for this order.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Check if a specific book in this order has been reviewed.
     */
    public function hasReviewedBook($bookId): bool
    {
        return $this->reviews()->where('book_id', $bookId)->exists();
    }

    /**
     * Check if all items in this order have been reviewed.
     */
    public function isFullyReviewed(): bool
    {
        $itemCount = $this->orderItems()->count();
        $reviewCount = $this->reviews()->count();
        return $itemCount > 0 && $itemCount === $reviewCount;
    }
}
