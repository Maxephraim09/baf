<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;

class DonationController extends Controller
{
    public function create()
    {
        return redirect()->route('donate');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'country' => ['nullable', 'string', 'max:100'],
            'amount' => ['required', 'numeric', 'min:1'],
            'frequency' => ['required', 'string', 'in:one-time,monthly,quarterly,yearly'],
            'payment_method' => ['required', 'string', 'in:manual'],
            'message' => ['nullable', 'string', 'max:5000'],
            'anonymous' => ['nullable', 'boolean'],
            'dedication_name' => ['nullable', 'string', 'max:255'],
            'dedication_type' => ['nullable', 'string', 'in:honor,memory'],
        ]);

        $donation = Donation::create([
            'donor_name' => $validated['name'],
            'donor_email' => $validated['email'],
            'donor_phone' => $validated['phone'] ?? null,
            'country' => $validated['country'] ?? null,
            'amount' => $validated['amount'],
            'frequency' => $validated['frequency'],
            'payment_method' => $validated['payment_method'],
            'status' => 'pending',
            'message' => $validated['message'] ?? null,
            'is_anonymous' => $request->boolean('anonymous'),
            'dedication_name' => $validated['dedication_name'] ?? null,
            'dedication_type' => $validated['dedication_type'] ?? null,
        ]);

        return redirect()->route('donations.thank-you')->with([
            'donation_id' => $donation->id,
            'donation_amount' => $donation->amount,
            'donor_name' => $donation->donor_name,
        ]);
    }

    public function thankYou()
    {
        return view('donations.thank-you');
    }
}
