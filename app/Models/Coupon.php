<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Coupon extends Model
{
    protected $fillable = [
        'code',
        'name',
        'description',
        'type',
        'value',
        'max_discount',
        'min_purchase',
        'usage_limit',
        'usage_limit_per_user',
        'used_count',
        'start_date',
        'end_date',
        'is_active',
        'is_first_purchase_only',
    ];

    protected $casts = [
        'value' => 'decimal:2',
        'max_discount' => 'decimal:2',
        'min_purchase' => 'decimal:2',
        'usage_limit' => 'integer',
        'usage_limit_per_user' => 'integer',
        'used_count' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_active' => 'boolean',
        'is_first_purchase_only' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($coupon) {
            $coupon->code = strtoupper($coupon->code);
        });
    }

    /**
     * Get coupon usages
     */
    public function usages(): HasMany
    {
        return $this->hasMany(CouponUsage::class);
    }

    /**
     * Get orders using this coupon
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Check if coupon is valid for use
     */
    public function isValid(): bool
    {
        // Check if active
        if (!$this->is_active) {
            return false;
        }

        // Check date range
        $now = now();
        if ($this->start_date && $now->lessThan($this->start_date)) {
            return false;
        }
        if ($this->end_date && $now->greaterThan($this->end_date)) {
            return false;
        }

        // Check usage limit
        if ($this->usage_limit && $this->used_count >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    /**
     * Check if user can use this coupon
     */
    public function canBeUsedBy(User $user): array
    {
        // Check basic validity
        if (!$this->isValid()) {
            return ['valid' => false, 'message' => 'Kupon tidak valid atau sudah kadaluarsa.'];
        }

        // Check first purchase only
        if ($this->is_first_purchase_only) {
            $hasOrders = $user->orders()->where('payment_status', 'paid')->exists();
            if ($hasOrders) {
                return ['valid' => false, 'message' => 'Kupon ini hanya untuk pembelian pertama.'];
            }
        }

        // Check per user limit
        $userUsageCount = $this->usages()->where('user_id', $user->id)->count();
        if ($userUsageCount >= $this->usage_limit_per_user) {
            return ['valid' => false, 'message' => 'Anda sudah menggunakan kupon ini sebelumnya.'];
        }

        return ['valid' => true, 'message' => 'Kupon valid.'];
    }

    /**
     * Calculate discount for a given subtotal
     */
    public function calculateDiscount(float $subtotal): float
    {
        if ($subtotal < $this->min_purchase) {
            return 0;
        }

        if ($this->type === 'percentage') {
            $discount = $subtotal * ($this->value / 100);
            if ($this->max_discount && $discount > $this->max_discount) {
                return $this->max_discount;
            }
            return $discount;
        }

        return min($this->value, $subtotal);
    }

    /**
     * Record usage of this coupon
     */
    public function recordUsage(User $user, Order $order, float $discountAmount): CouponUsage
    {
        $usage = $this->usages()->create([
            'user_id' => $user->id,
            'order_id' => $order->id,
            'discount_amount' => $discountAmount,
        ]);

        $this->increment('used_count');

        return $usage;
    }

    /**
     * Get discount label
     */
    public function getDiscountLabelAttribute(): string
    {
        if ($this->type === 'percentage') {
            return (int)$this->value . '%';
        }
        return 'Rp ' . number_format($this->value, 0, ',', '.');
    }

    /**
     * Generate a random coupon code
     */
    public static function generateCode(int $length = 8): string
    {
        do {
            $code = strtoupper(Str::random($length));
        } while (self::where('code', $code)->exists());
        
        return $code;
    }

    /**
     * Scope for active coupons
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                  ->orWhere('end_date', '>=', now());
            });
    }

    /**
     * Scope for first purchase coupons
     */
    public function scopeFirstPurchase($query)
    {
        return $query->where('is_first_purchase_only', true);
    }
}
