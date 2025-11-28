<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'bank_name',
        'account_number',
        'account_holder',
        'bank_logo',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Scope for active accounts
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope for ordering
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('bank_name');
    }

    /**
     * Get formatted account number (masked)
     */
    public function getMaskedAccountNumberAttribute()
    {
        $length = strlen($this->account_number);
        if ($length <= 4) {
            return $this->account_number;
        }
        
        return str_repeat('*', $length - 4) . substr($this->account_number, -4);
    }
}
