<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function about()
    {
        return view('frontend.about');
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function submitContact(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['required', 'string', 'in:general,donation,volunteer,partnership,support,other'],
            'message' => ['required', 'string', 'max:5000'],
            'newsletter' => ['nullable', 'boolean'],
        ]);

        return back()->with('success', 'Thank you for contacting us. We will respond as soon as possible.');
    }

    public function donate()
    {
        return view('frontend.donate');
    }
}
