<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\HeritageItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeritageController extends Controller
{
    public function index(Request $request)
    {
        $items = HeritageItem::where('is_active', true)
            ->when($request->filled('type'), fn ($query) => $query->where('type', $request->string('type')))
            ->when($request->filled('q'), fn ($query) => $query->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->string('q') . '%')
                    ->orWhere('description', 'like', '%' . $request->string('q') . '%');
            }))
            ->latest()->paginate(12)->withQueryString();

        return view('frontend.heritage.index', compact('items'));
    }

    public function show(HeritageItem $item)
    {
        abort_unless($item->is_active, 404);
        return view('frontend.heritage.show', compact('item'));
    }

    public function download(HeritageItem $item)
    {
        abort_unless($item->is_active && $item->media_path && Storage::disk('public')->exists($item->media_path), 404);
        $item->increment('download_count');
        return Storage::disk('public')->download($item->media_path, $item->title);
    }
}
