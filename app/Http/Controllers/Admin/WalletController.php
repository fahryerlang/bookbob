<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\TopupRequest;
use App\Models\Wallet;
use App\Models\WalletTransaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WalletController extends Controller
{
    /**
     * Display wallet management dashboard
     */
    public function index()
    {
        $stats = [
            'total_balance' => Wallet::sum('balance'),
            'pending_requests' => TopupRequest::pending()->count(),
            'today_topups' => TopupRequest::approved()->whereDate('approved_at', today())->sum('amount'),
            'users_with_wallet' => Wallet::where('balance', '>', 0)->count(),
        ];

        $recentRequests = TopupRequest::with('user')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.wallet.index', compact('stats', 'recentRequests'));
    }

    /**
     * Display topup requests list
     */
    public function topupRequests(Request $request)
    {
        $query = TopupRequest::with(['user', 'bankAccount', 'approver']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by method
        if ($request->filled('method')) {
            $query->where('method', $request->method);
        }

        $topupRequests = $query->latest()->paginate(15);

        return view('admin.wallet.topup-requests', compact('topupRequests'));
    }

    /**
     * Show topup request detail
     */
    public function showTopupRequest(TopupRequest $topupRequest)
    {
        $topupRequest->load(['user', 'bankAccount', 'approver']);
        
        return view('admin.wallet.topup-show', compact('topupRequest'));
    }

    /**
     * Approve topup request
     */
    public function approveTopup(Request $request, TopupRequest $topupRequest)
    {
        if ($topupRequest->status !== 'pending') {
            return back()->with('error', 'Request ini sudah diproses sebelumnya.');
        }

        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $topupRequest->approve(auth()->id(), $request->admin_notes);

        return redirect()->route('admin.wallet.topup-requests')
            ->with('success', 'Top up berhasil disetujui. Saldo user telah ditambahkan.');
    }

    /**
     * Reject topup request
     */
    public function rejectTopup(Request $request, TopupRequest $topupRequest)
    {
        if ($topupRequest->status !== 'pending') {
            return back()->with('error', 'Request ini sudah diproses sebelumnya.');
        }

        $request->validate([
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $topupRequest->reject(auth()->id(), $request->admin_notes);

        return redirect()->route('admin.wallet.topup-requests')
            ->with('success', 'Top up berhasil ditolak.');
    }

    /**
     * Manual topup form
     */
    public function manualTopupForm()
    {
        $users = User::where('role', 'user')->orderBy('name')->get();
        
        $recentManualTopups = WalletTransaction::with('wallet.user')
            ->where('type', 'topup')
            ->where('description', 'like', 'Top up manual%')
            ->latest()
            ->take(5)
            ->get();

        return view('admin.wallet.manual-topup', compact('users', 'recentManualTopups'));
    }

    /**
     * Process manual topup for user
     */
    public function manualTopup(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1000',
            'description' => 'nullable|string|max:500',
        ]);

        $user = User::findOrFail($request->user_id);
        $wallet = $user->getOrCreateWallet();

        $description = $request->description ?: 'Top up manual oleh admin';
        
        $wallet->deposit($request->amount, 'Top up manual: ' . $description, null, null);

        return redirect()->route('admin.wallet.index')
            ->with('success', 'Saldo berhasil ditambahkan ke akun ' . $user->name);
    }

    /**
     * Bank accounts management
     */
    public function bankAccounts()
    {
        $bankAccounts = BankAccount::orderBy('created_at', 'desc')->get();
        
        return view('admin.wallet.bank-accounts', compact('bankAccounts'));
    }

    /**
     * Store new bank account
     */
    public function storeBankAccount(Request $request)
    {
        $request->validate([
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_name' => 'required|string|max:100',
            'logo' => 'nullable|image|max:1024',
            'is_active' => 'nullable',
        ]);

        $data = [
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'is_active' => $request->has('is_active'),
        ];
        
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('bank-logos', 'public');
        }

        BankAccount::create($data);

        return back()->with('success', 'Rekening bank berhasil ditambahkan.');
    }

    /**
     * Update bank account
     */
    public function updateBankAccount(Request $request, BankAccount $bankAccount)
    {
        $request->validate([
            'bank_name' => 'required|string|max:100',
            'account_number' => 'required|string|max:50',
            'account_name' => 'required|string|max:100',
            'logo' => 'nullable|image|max:1024',
            'is_active' => 'nullable',
        ]);

        $data = [
            'bank_name' => $request->bank_name,
            'account_number' => $request->account_number,
            'account_name' => $request->account_name,
            'is_active' => $request->has('is_active'),
        ];
        
        if ($request->hasFile('logo')) {
            // Delete old logo
            if ($bankAccount->logo) {
                Storage::disk('public')->delete($bankAccount->logo);
            }
            $data['logo'] = $request->file('logo')->store('bank-logos', 'public');
        }

        $bankAccount->update($data);

        return back()->with('success', 'Rekening bank berhasil diperbarui.');
    }

    /**
     * Delete bank account
     */
    public function deleteBankAccount(BankAccount $bankAccount)
    {
        if ($bankAccount->logo) {
            Storage::disk('public')->delete($bankAccount->logo);
        }
        
        $bankAccount->delete();

        return back()->with('success', 'Rekening bank berhasil dihapus.');
    }
}
