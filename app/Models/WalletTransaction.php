<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WalletTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'wallet_id',
        'type',
        'amount',
        'balance_before',
        'balance_after',
        'description',
        'reference_type',
        'reference_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'balance_before' => 'decimal:2',
        'balance_after' => 'decimal:2',
    ];

    public function wallet()
    {
        return $this->belongsTo(Wallet::class);
    }

    public function reference()
    {
        return $this->morphTo();
    }

    /**
     * Get type label
     */
    public function getTypeLabelAttribute()
    {
        return match($this->type) {
            'topup' => 'Top Up',
            'payment' => 'Pembayaran',
            'refund' => 'Pengembalian Dana',
            'cashback' => 'Cashback',
            'adjustment' => 'Penyesuaian',
            default => $this->type,
        };
    }

    /**
     * Get type color
     */
    public function getTypeColorAttribute()
    {
        return match($this->type) {
            'topup' => 'green',
            'payment' => 'red',
            'refund' => 'blue',
            'cashback' => 'purple',
            'adjustment' => 'gray',
            default => 'gray',
        };
    }

    /**
     * Scope for income transactions
     */
    public function scopeIncome($query)
    {
        return $query->where('amount', '>', 0);
    }

    /**
     * Scope for expense transactions
     */
    public function scopeExpense($query)
    {
        return $query->where('amount', '<', 0);
    }
}
