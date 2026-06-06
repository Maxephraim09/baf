<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
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
