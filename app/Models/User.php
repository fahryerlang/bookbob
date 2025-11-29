<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Check if user is admin.
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is a regular user.
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * Get the carts for the user.
     */
    public function carts(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get the orders for the user.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get the messages for the user.
     */
    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get the wallet for the user.
     */
    public function wallet(): HasOne
    {
        return $this->hasOne(Wallet::class);
    }

    /**
     * Get the topup requests for the user.
     */
    public function topupRequests(): HasMany
    {
        return $this->hasMany(TopupRequest::class);
    }

    /**
     * Get wallet balance
     */
    public function getWalletBalanceAttribute()
    {
        return $this->wallet?->balance ?? 0;
    }

    /**
     * Get or create wallet
     */
    public function getOrCreateWallet()
    {
        return $this->wallet ?? $this->wallet()->create(['balance' => 0]);
    }

    /**
     * Get the wishlists for the user.
     */
    public function wishlists(): HasMany
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Get the wishlist books for the user.
     */
    public function wishlistBooks()
    {
        return $this->belongsToMany(Book::class, 'wishlists')
            ->withPivot('price_when_added', 'notified_at')
            ->withTimestamps();
    }

    /**
     * Check if a book is in user's wishlist.
     */
    public function hasInWishlist($bookId): bool
    {
        return $this->wishlists()->where('book_id', $bookId)->exists();
    }

    /**
     * Get wishlist count.
     */
    public function getWishlistCountAttribute(): int
    {
        return $this->wishlists()->count();
    }

    /**
     * Get the reviews written by the user.
     */
    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Check if user has reviewed a book for a specific order.
     */
    public function hasReviewedBook($bookId, $orderId): bool
    {
        return $this->reviews()
            ->where('book_id', $bookId)
            ->where('order_id', $orderId)
            ->exists();
    }

    /**
     * Check if user can review a book (has completed order with this book).
     */
    public function canReviewBook($bookId): bool
    {
        return $this->orders()
            ->where('status', 'completed')
            ->whereHas('orderItems', function ($query) use ($bookId) {
                $query->where('book_id', $bookId);
            })
            ->exists();
    }
}
