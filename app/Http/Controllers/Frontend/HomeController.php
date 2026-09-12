<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Services\CmsService;
use App\Models\BoardMember;
use App\Models\TeamMember;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(CmsService $cms)
    {
        return view('welcome', $cms->homepage());
    }

    public function about(CmsService $cms)
    {
        $content = $cms->homepage();
        return view('frontend.about', $content);
    }

    public function team()
    {
        return view('frontend.team', ['members' => TeamMember::where('is_active', true)->orderBy('sort_order')->get()]);
    }

    public function teamMember(TeamMember $member)
    {
        abort_unless($member->is_active, 404);
        return view('frontend.team-show', compact('member'));
    }

    public function board()
    {
        return view('frontend.board', ['members' => BoardMember::where('is_active', true)->orderBy('sort_order')->get()]);
    }

    public function contact()
    {
        return view('frontend.contact');
    }

    public function submitContact(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'subject' => ['required', 'string', 'in:general,donation,volunteer,partnership,support,other'],
            'message' => ['required', 'string', 'max:5000'],
            'newsletter' => ['nullable', 'boolean'],
        ]);

        ContactMessage::create($data + ['status' => 'new']);

        return back()->with('success', 'Thank you for contacting us. We will respond as soon as possible.');
    }

    public function donate()
    {
        return view('frontend.donate');
    }
}
