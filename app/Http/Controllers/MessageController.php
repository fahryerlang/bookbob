<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Display a listing of user's messages.
     */
    public function index()
    {
        $messages = Message::where('user_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('messages.index', compact('messages'));
    }

    /**
     * Show the form for creating a new message (public contact page).
     */
    public function create()
    {
        return view('contact');
    }

    /**
     * Show the form for creating a new message (authenticated user).
     */
    public function userCreate()
    {
        return view('messages.create');
    }

    /**
     * Store a newly created message (public contact form).
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        if (auth()->check()) {
            $validated['user_id'] = auth()->id();
        }

        Message::create($validated);

        return redirect()->back()
            ->with('success', 'Pesan Anda berhasil dikirim! Kami akan segera menghubungi Anda.');
    }

    /**
     * Store a newly created message (authenticated user).
     */
    public function userStore(Request $request)
    {
        $validated = $request->validate([
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        $user = auth()->user();

        Message::create([
            'user_id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
        ]);

        return redirect()->route('messages.index')
            ->with('success', 'Pesan Anda berhasil dikirim ke Admin!');
    }

    /**
     * Display the specified message.
     */
    public function show(Message $message)
    {
        // Pastikan user hanya bisa melihat pesan miliknya
        if ($message->user_id !== auth()->id()) {
            abort(403);
        }

        return view('messages.show', compact('message'));
    }
}
