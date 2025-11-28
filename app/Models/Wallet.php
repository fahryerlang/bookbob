<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'balance',
    ];

    protected $casts = [
        'balance' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transactions()
    {
        return $this->hasMany(WalletTransaction::class);
    }

    /**
     * Add balance to wallet (alias for deposit)
     */
    public function addBalance($amount, $type, $description, $referenceType = null, $referenceId = null)
    {
        $balanceBefore = $this->balance;
        $this->balance += $amount;
        $this->save();

        return $this->transactions()->create([
            'type' => $type,
            'amount' => $amount,
            'balance_before' => $balanceBefore,
            'balance_after' => $this->balance,
            'description' => $description,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
        ]);
    }

    /**
     * Deposit/Top up to wallet
     */
    public function deposit($amount, $description, $referenceType = null, $referenceId = null)
    {
        return $this->addBalance($amount, 'topup', $description, $referenceType, $referenceId);
    }

    /**
     * Deduct balance from wallet
     */
    public function deductBalance($amount, $type, $description, $referenceType = null, $referenceId = null)
    {
        if ($this->balance < $amount) {
            throw new \Exception('Saldo tidak mencukupi');
        }

        $balanceBefore = $this->balance;
        $this->balance -= $amount;
        $this->save();

        return $this->transactions()->create([
            'type' => $type,
            'amount' => -$amount,
            'balance_before' => $balanceBefore,
            'balance_after' => $this->balance,
            'description' => $description,
            'reference_type' => $referenceType,
            'reference_id' => $referenceId,
        ]);
    }

    /**
     * Check if wallet has enough balance
     */
    public function hasEnoughBalance($amount)
    {
        return $this->balance >= $amount;
    }
}
