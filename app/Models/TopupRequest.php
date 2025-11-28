<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopupRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'method',
        'amount',
        'status',
        'proof_image',
        'bank_account_id',
        'payment_gateway',
        'payment_id',
        'notes',
        'admin_notes',
        'approved_by',
        'approved_at',
        'expired_at',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'approved_at' => 'datetime',
        'expired_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bankAccount()
    {
        return $this->belongsTo(BankAccount::class);
    }

    public function approvedBy()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get method label
     */
    public function getMethodLabelAttribute()
    {
        return match($this->method) {
            'request' => 'Request Manual',
            'transfer' => 'Transfer Bank',
            'gateway' => 'Payment Gateway',
            default => $this->method,
        };
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending' => 'Menunggu',
            'approved' => 'Disetujui',
            'rejected' => 'Ditolak',
            'expired' => 'Kadaluarsa',
            default => $this->status,
        };
    }

    /**
     * Get status color
     */
    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'yellow',
            'approved' => 'green',
            'rejected' => 'red',
            'expired' => 'gray',
            default => 'gray',
        };
    }

    /**
     * Scope for pending requests
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for approved requests
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    /**
     * Approve the topup request
     */
    public function approve($adminId, $adminNotes = null)
    {
        $this->update([
            'status' => 'approved',
            'approved_by' => $adminId,
            'approved_at' => now(),
            'admin_notes' => $adminNotes,
        ]);

        // Add balance to user wallet
        $wallet = $this->user->wallet ?? $this->user->wallet()->create(['balance' => 0]);
        $wallet->addBalance(
            $this->amount,
            'topup',
            'Top up via ' . $this->method_label,
            TopupRequest::class,
            $this->id
        );

        return $this;
    }

    /**
     * Reject the topup request
     */
    public function reject($adminId, $adminNotes = null)
    {
        $this->update([
            'status' => 'rejected',
            'approved_by' => $adminId,
            'approved_at' => now(),
            'admin_notes' => $adminNotes,
        ]);

        return $this;
    }
}
