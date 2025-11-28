<?php

namespace App\Http\Controllers;

use App\Models\BankAccount;
use App\Models\TopupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WalletController extends Controller
{
    /**
     * Display wallet dashboard
     */
    public function index()
    {
        $user = auth()->user();
        $wallet = $user->getOrCreateWallet();
        $balance = $wallet->balance;
        
        $transactions = $wallet->transactions()
            ->latest()
            ->take(5)
            ->get();

        $pendingTopups = $user->topupRequests()
            ->pending()
            ->count();

        return view('wallet.index', compact('wallet', 'balance', 'transactions', 'pendingTopups'));
    }

    /**
     * Show topup method selection page
     */
    public function topup()
    {
        return view('wallet.topup');
    }

    /**
     * Show request topup form
     */
    public function topupRequestForm()
    {
        return view('wallet.topup-request');
    }

    /**
     * Process request topup
     */
    public function topupRequest(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000|max:10000000',
            'notes' => 'nullable|string|max:500',
        ], [
            'amount.min' => 'Minimal top up Rp 10.000',
            'amount.max' => 'Maksimal top up Rp 10.000.000',
        ]);

        TopupRequest::create([
            'user_id' => auth()->id(),
            'method' => 'request',
            'amount' => $request->amount,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('wallet.history')
            ->with('success', 'Permintaan top up berhasil dikirim. Silakan tunggu verifikasi dari admin.');
    }

    /**
     * Show transfer topup form
     */
    public function topupTransferForm()
    {
        $bankAccounts = BankAccount::active()->get();
        
        return view('wallet.topup-transfer', compact('bankAccounts'));
    }

    /**
     * Process transfer topup
     */
    public function topupTransfer(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:10000|max:10000000',
            'bank_account_id' => 'required|exists:bank_accounts,id',
            'proof_image' => 'required|image|max:2048',
            'notes' => 'nullable|string|max:500',
        ], [
            'amount.min' => 'Minimal top up Rp 10.000',
            'amount.max' => 'Maksimal top up Rp 10.000.000',
            'proof_image.required' => 'Bukti transfer wajib diupload',
            'proof_image.image' => 'File harus berupa gambar',
            'proof_image.max' => 'Ukuran gambar maksimal 2MB',
        ]);

        $proofPath = $request->file('proof_image')->store('topup-proofs', 'public');

        TopupRequest::create([
            'user_id' => auth()->id(),
            'method' => 'transfer',
            'amount' => $request->amount,
            'bank_account_id' => $request->bank_account_id,
            'proof_image' => $proofPath,
            'notes' => $request->notes,
            'status' => 'pending',
        ]);

        return redirect()->route('wallet.history')
            ->with('success', 'Bukti transfer berhasil dikirim. Silakan tunggu verifikasi dari admin.');
    }

    /**
     * Show gateway topup page (coming soon)
     */
    public function topupGateway()
    {
        return view('wallet.topup-gateway');
    }

    /**
     * Show topup history
     */
    public function history()
    {
        $topupRequests = auth()->user()
            ->topupRequests()
            ->with('bankAccount')
            ->latest()
            ->paginate(10);

        return view('wallet.history', compact('topupRequests'));
    }

    /**
     * Show topup detail
     */
    public function showTopup(TopupRequest $topupRequest)
    {
        // Pastikan user hanya bisa lihat request miliknya
        if ($topupRequest->user_id !== auth()->id()) {
            abort(403);
        }

        return view('wallet.topup-show', compact('topupRequest'));
    }
}
