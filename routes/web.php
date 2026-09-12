<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Frontend\DonationController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\VolunteerController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Admin\CmsController;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/team', [HomeController::class, 'team'])->name('team');
Route::get('/team/{member}', [HomeController::class, 'teamMember'])->name('team.show');
Route::get('/board', [HomeController::class, 'board'])->name('board');
Route::get('/heritage', [\App\Http\Controllers\Frontend\HeritageController::class, 'index'])->name('heritage.index');
Route::get('/heritage/{item}', [\App\Http\Controllers\Frontend\HeritageController::class, 'show'])->name('heritage.show');
Route::get('/heritage/{item}/download', [\App\Http\Controllers\Frontend\HeritageController::class, 'download'])->name('heritage.download');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');
Route::post('/contact', [HomeController::class, 'submitContact'])->name('contact.submit');
Route::get('/donate', [HomeController::class, 'donate'])->name('donate');
Route::get('/donations/create', [DonationController::class, 'create'])->name('donations.create');
Route::post('/donations', [DonationController::class, 'store'])->name('donations.store');
Route::get('/donations/thank-you', [DonationController::class, 'thankYou'])->name('donations.thank-you');

// Blog Routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/category/{category}', [BlogController::class, 'category'])->name('blog.category');

// Volunteer Routes
Route::get('/volunteer', [VolunteerController::class, 'index'])->name('volunteer');
Route::post('/volunteer', [VolunteerController::class, 'store'])->name('volunteer.store');
Route::get('/volunteer/success', [VolunteerController::class, 'success'])->name('volunteer.success');



Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user?->hasRole('superadmin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user?->hasRole('donor')) {
        return view('dashboards.donor');
    }

    if ($user?->hasRole('volunteer')) {
        return view('dashboards.volunteer');
    }

    if ($user?->hasRole('beneficiary')) {
        return view('dashboards.beneficiary');
    }

    // Legacy accounts created before role selection retain access as donors.
    return view('dashboards.donor');
})->middleware(['auth'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:superadmin'])->prefix('admin')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::get('/dashboard', [DashboardController::class, 'index']);
    Route::get('/settings', [\App\Http\Controllers\Admin\SettingsController::class, 'edit'])->name('admin.settings');
    // Settings POST handler - saves individual sections
    Route::post('/settings/{section}', [\App\Http\Controllers\Admin\SettingsController::class, 'update'])->name('admin.settings.update');
});

// Admin Routes for Volunteer Management (protected by auth middleware)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/volunteers', [VolunteerController::class, 'indexAdmin'])->name('volunteers.index');
    Route::get('/volunteers/{id}', [VolunteerController::class, 'show'])->name('volunteers.show');
    Route::put('/volunteers/{id}/status', [VolunteerController::class, 'updateStatus'])->name('volunteers.status');
    Route::get('/volunteers/export/csv', [VolunteerController::class, 'export'])->name('volunteers.export');
    Route::delete('/volunteers/{id}', [VolunteerController::class, 'destroy'])->name('volunteers.destroy');
});

Route::middleware(['auth', 'role:superadmin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/cms', [CmsController::class, 'index'])->name('cms.index');
    Route::put('/cms/sections/{section}', [CmsController::class, 'updateSection'])->name('cms.sections.update');
    Route::put('/cms/sections/{section}/content', [CmsController::class, 'updateContent'])->name('cms.sections.content.update');
    Route::post('/cms/sections/{section}/values', [CmsController::class, 'storeValue'])->name('cms.sections.values.store');
    Route::put('/cms/sections/{section}/values/{content}', [CmsController::class, 'updateValue'])->name('cms.sections.values.update');
    Route::delete('/cms/sections/{section}/values/{content}', [CmsController::class, 'destroyContent'])->name('cms.sections.values.destroy');
    Route::post('/cms/{type}', [CmsController::class, 'storeItem'])->name('cms.items.store');
    Route::put('/cms/{type}/{id}', [CmsController::class, 'updateItem'])->name('cms.items.update');
    Route::delete('/cms/{type}/{id}', [CmsController::class, 'destroyItem'])->name('cms.items.destroy');
    Route::post('/cms/projects', [CmsController::class, 'storeProject'])->name('cms.projects.store');
    Route::put('/cms/projects/{project}', [CmsController::class, 'updateProject'])->name('cms.projects.update');
    Route::delete('/cms/projects/{project}', [CmsController::class, 'destroyProject'])->name('cms.projects.destroy');
    Route::get('/messages', function () {
        return view('admin.messages', ['messages' => \App\Models\ContactMessage::latest()->paginate(20)]);
    })->name('messages.index');
    Route::put('/messages/{message}/reply', function (\Illuminate\Http\Request $request, \App\Models\ContactMessage $message) {
        $data = $request->validate(['admin_reply' => ['required', 'string', 'max:5000']]);
        $message->update(['admin_reply' => $data['admin_reply'], 'status' => 'replied', 'replied_at' => now()]);
        return back()->with('success', 'Reply saved for ' . $message->email . '.');
    })->name('messages.reply');
    Route::get('/heritage', function () {
        return view('admin.heritage', ['items' => \App\Models\HeritageItem::latest()->paginate(20)]);
    })->name('heritage.index');
    Route::post('/heritage', function (\Illuminate\Http\Request $request) {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:artifact,video,audio,photo,educational_resource,historical_archive'],
            'description' => ['nullable', 'string', 'max:10000'],
            'source' => ['nullable', 'string', 'max:255'],
            'media_path' => ['nullable', 'file', 'max:51200'],
            'is_active' => ['nullable', 'boolean'],
        ]);
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('media_path')) {
            $data['media_path'] = $request->file('media_path')->store('heritage', 'public');
        }
        \App\Models\HeritageItem::create($data);
        return back()->with('success', 'Heritage resource saved.');
    })->name('heritage.store');
    Route::get('/reports', function () {
        $items = \App\Models\HeritageItem::query();
        return view('admin.reports', [
            'visitors' => 0,
            'donations' => \App\Models\Donation::whereIn('status', ['successful', 'completed', 'paid', 'confirmed'])->sum('amount'),
            'projects' => \App\Models\Project::where('status', 'active')->count(),
            'downloads' => (clone $items)->sum('download_count'),
            'downloadTypes' => (clone $items)->selectRaw('type, SUM(download_count) as total')->groupBy('type')->pluck('total', 'type'),
        ]);
    })->name('reports.index');
    Route::get('/reports/export', function () {
        $rows = \App\Models\HeritageItem::select('type', 'title', 'download_count', 'created_at')->get();
        return response()->streamDownload(function () use ($rows): void {
            $output = fopen('php://output', 'w');
            fputcsv($output, ['Type', 'Title', 'Downloads', 'Created']);
            foreach ($rows as $row) fputcsv($output, [$row->type, $row->title, $row->download_count, $row->created_at]);
            fclose($output);
        }, 'agontara-report.csv', ['Content-Type' => 'text/csv']);
    })->name('reports.export');
    Route::get('/board', function () {
        return view('admin.board', ['members' => \App\Models\BoardMember::orderBy('sort_order')->get()]);
    })->name('board.index');
    Route::post('/board', function (\Illuminate\Http\Request $request) {
        $data = $request->validate(['name' => ['required', 'string', 'max:255'], 'role' => ['required', 'string', 'max:255'], 'bio' => ['required', 'string', 'max:5000'], 'sort_order' => ['nullable', 'integer', 'min:0'], 'is_active' => ['nullable', 'boolean']]);
        $data['is_active'] = $request->boolean('is_active');
        \App\Models\BoardMember::create($data);
        return back()->with('success', 'Board member added.');
    })->name('board.store');
});

require __DIR__.'/auth.php';
