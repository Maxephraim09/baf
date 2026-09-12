<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\LandingEvent;
use App\Models\Project;
use App\Models\Volunteer;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $paidStatuses = ['successful', 'completed', 'paid', 'confirmed'];
        $projects = Project::query()
            ->where('status', 'active')
            ->where(fn ($query) => $query->whereNull('is_active')->orWhere('is_active', true))
            ->withSum(['donations as raised_total' => fn ($query) => $query->whereIn('status', $paidStatuses)], 'amount')
            ->orderBy('sort_order')
            ->take(5)
            ->get();

        $totalRaised = Donation::whereIn('status', $paidStatuses)->sum('amount');
        $totalGoal = Project::where('status', 'active')->sum('goal_amount');

        return view('admin.dashboard', [
            'stats' => [
                'projects' => Project::where('status', 'active')->count(),
                'raised' => $totalRaised,
                'events' => LandingEvent::where('is_active', true)->where('event_date', '>=', Carbon::now())->count(),
                'volunteers' => Volunteer::whereIn('status', ['reviewed', 'accepted'])->count(),
            ],
            'totalGoal' => $totalGoal,
            'projects' => $projects,
            'recentDonations' => Donation::latest()->take(5)->get(),
        ]);
    }

    public function getStats()
    {
        return response()->json([
            'projects' => 0,
            'donations' => 0,
            'events' => 0,
        ]);
    }

    public function bulkDelete()
    {
        return response()->json(['success' => false]);
    }
}
