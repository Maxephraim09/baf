<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CmsContent;
use App\Models\CmsSection;
use App\Models\Blog;
use App\Models\GalleryItem;
use App\Models\ImpactLevel;
use App\Models\InfoCard;
use App\Models\LandingEvent;
use App\Models\Project;
use App\Models\Partner;
use App\Models\TeamMember;
use App\Models\Testimonial;
use App\Services\CmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CmsController extends Controller
{
    public function __construct(private readonly CmsService $cms)
    {
    }

    public function index(Request $request)
    {
        $sections = CmsSection::with('contents')->orderBy('sort_order')->get();
        $projects = Project::withSum(['donations as raised_total' => fn ($query) => $query->whereIn('status', $this->paidStatuses())], 'amount')
            ->when($request->filled('search'), fn ($query) => $query->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->string('search') . '%')
                    ->orWhere('tag', 'like', '%' . $request->string('search') . '%');
            }))
            ->when($request->filled('status'), fn ($query) => $query->where('is_active', $request->boolean('status')))
            ->orderBy('sort_order')->paginate(10)->withQueryString();
        $tab = $request->query('tab', 'hero');
        abort_unless(in_array($tab, $this->cmsTabs(), true), 404);
        $action = $request->query('action');
        $editType = $request->query('edit_type');
        $editId = $request->integer('edit');
        $editItem = null;
        $section = $sections->firstWhere('key', $tab);
        $content = $section?->contents->first();

        if ($editType && $editId) {
            if ($editType === 'values') {
                $editItem = CmsContent::whereHas('section', fn ($query) => $query->where('key', 'values'))
                    ->find($editId);
            } else {
                [$editModel] = $this->itemConfig($editType);
                $editItem = $editModel::find($editId);
            }
        }

        $viewData = [
            'sections' => $sections,
            'section' => $section,
            'content' => $content,
            'projects' => $projects,
            'partners' => Partner::orderBy('sort_order')->get(),
            'impactLevels' => ImpactLevel::orderBy('sort_order')->get(),
            'galleryItems' => GalleryItem::orderBy('sort_order')->get(),
            'events' => LandingEvent::orderBy('event_date')->get(),
            'testimonials' => Testimonial::orderBy('sort_order')->get(),
            'teamMembers' => TeamMember::orderBy('sort_order')->get(),
            'infoCards' => InfoCard::orderBy('sort_order')->get(),
            'blogPosts' => Blog::latest('published_at')->latest()->get(),
            'activeTab' => $tab,
            'action' => $action,
            'editType' => $editType,
            'editItem' => $editItem,
            'editProject' => $request->filled('edit_project') ? Project::find($request->integer('edit_project')) : null,
            'items' => match ($tab) {
                'gallery' => GalleryItem::orderBy('sort_order')->get(),
                'events' => LandingEvent::orderBy('event_date')->get(),
                'testimonials' => Testimonial::orderBy('sort_order')->get(),
                'team' => TeamMember::orderBy('sort_order')->get(),
                'info-cards' => InfoCard::orderBy('sort_order')->get(),
                'partners' => Partner::orderBy('sort_order')->get(),
                default => collect(),
            },
            'type' => $tab,
        ];

        if ($action) {
            return view('admin.cms.action', $viewData);
        }

        return view('admin.cms.index', $viewData);
    }

    public function updateSection(Request $request, CmsSection $section)
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'is_enabled' => ['nullable', 'boolean'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
        ]);

        $section->update([...$data, 'is_enabled' => $request->boolean('is_enabled')]);
        $this->cms->forgetHomepage();

        return back()->with('success', $section->name . ' section updated.')->with('active_tab', $section->key);
    }

    public function updateContent(Request $request, CmsSection $section)
    {
        $data = $request->validate([
            'title' => ['nullable', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:1000'],
            'description' => ['nullable', 'string', 'max:10000'],
            'button_text' => ['nullable', 'string', 'max:100'],
            'button_link' => ['nullable', 'max:2048', 'regex:/^(https?:\/\/|\/)/i'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        DB::transaction(function () use ($request, $section, &$data): void {
            $content = $section->contents()->firstOrNew([]);
            $oldImage = $content->image;
            if ($request->hasFile('image')) {
                $data['image'] = $request->file('image')->store('cms/' . $section->key, 'public');
            }
            $data['is_active'] = $request->boolean('is_active');
            $content->fill($data)->save();
            if (isset($data['image']) && $oldImage && $oldImage !== $data['image']) {
                Storage::disk('public')->delete($oldImage);
            }
        });

        $this->cms->forgetHomepage();
        return back()->with('success', $section->name . ' content updated.')->with('active_tab', $section->key);
    }

    public function storeValue(Request $request, CmsSection $section)
    {
        abort_unless($section->key === 'values', 404);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
            'metadata.icon' => ['nullable', 'string', 'max:80', 'regex:/^fa-[a-z0-9-]+$/'],
        ]);

        $section->contents()->create([
            'title' => $data['title'],
            'description' => $data['description'],
            'metadata' => $data['metadata'] ?? [],
            'sort_order' => $data['sort_order'],
            'is_active' => $request->boolean('is_active'),
        ]);

        $this->cms->forgetHomepage();

        return back()->with('success', 'Value added successfully.')->with('active_tab', 'values');
    }

    public function destroyContent(CmsSection $section, CmsContent $content)
    {
        abort_unless($content->section_id === $section->id && $section->key === 'values', 404);

        $content->delete();
        $this->cms->forgetHomepage();

        return back()->with('success', 'Value deleted successfully.')->with('active_tab', 'values');
    }

    public function updateValue(Request $request, CmsSection $section, CmsContent $content)
    {
        abort_unless($section->key === 'values' && $content->section_id === $section->id, 404);

        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:5000'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
            'metadata.icon' => ['nullable', 'string', 'max:80', 'regex:/^fa-[a-z0-9-]+$/'],
        ]);

        $content->update([
            'title' => $data['title'],
            'description' => $data['description'],
            'metadata' => $data['metadata'] ?? [],
            'sort_order' => $data['sort_order'],
            'is_active' => $request->boolean('is_active'),
        ]);

        $this->cms->forgetHomepage();

        return redirect()->route('admin.cms.index', ['tab' => 'values'])
            ->with('success', 'Value updated successfully.');
    }

    public function storeItem(Request $request, string $type)
    {
        $request->merge(['sort_order' => $request->input('sort_order', 0)]);
        [$model, $rules] = $this->itemConfig($type);
        $data = $request->validate($rules);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cms/' . $type, 'public');
            $data[$type === 'partners' ? 'logo' : 'image'] = $imagePath;
        }
        $model::create($data);
        $this->cms->forgetHomepage();
        return back()->with('success', Str::headline($type) . ' created.')->with('active_tab', $type);
    }

    public function updateItem(Request $request, string $type, int $id)
    {
        $request->merge(['sort_order' => $request->input('sort_order', 0)]);
        [$model, $rules] = $this->itemConfig($type);
        $item = $model::findOrFail($id);
        if (array_key_exists('image', $rules)) {
            $rules['image'][0] = 'nullable';
        }
        $data = $request->validate($rules);
        $data['sort_order'] = $data['sort_order'] ?? 0;
        $data['is_active'] = $request->boolean('is_active');
        $oldImage = $type === 'partners' ? $item->logo : $item->image;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('cms/' . $type, 'public');
            $data[$type === 'partners' ? 'logo' : 'image'] = $imagePath;
        }
        $item->update($data);
        $newImage = $type === 'partners' ? ($data['logo'] ?? null) : ($data['image'] ?? null);
        if ($newImage && $oldImage && $oldImage !== $newImage) {
            Storage::disk('public')->delete($oldImage);
        }
        $this->cms->forgetHomepage();
        return back()->with('success', Str::headline($type) . ' updated.')->with('active_tab', $type);
    }

    public function destroyItem(string $type, int $id)
    {
        [$model] = $this->itemConfig($type);
        $item = $model::findOrFail($id);
        $image = $type === 'partners' ? $item->logo : $item->image;
        if ($image) {
            Storage::disk('public')->delete($image);
        }
        $item->delete();
        $this->cms->forgetHomepage();
        return back()->with('success', Str::headline($type) . ' deleted.')->with('active_tab', $type);
    }

    public function storeProject(Request $request)
    {
        $data = $this->projectData($request);
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('projects', 'public');
        }
        $data['slug'] = Str::slug($data['title']);
        Project::create($data);
        $this->cms->forgetHomepage();
        return redirect()->route('admin.cms.index', ['tab' => 'projects'])->with('success', 'Project created.');
    }

    public function updateProject(Request $request, Project $project)
    {
        $data = $this->projectData($request, $project);
        $oldImage = $project->image;
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('projects', 'public');
        }
        $data['slug'] = Str::slug($data['title']);
        $project->update($data);
        if (isset($data['image']) && $oldImage && $oldImage !== $data['image']) {
            Storage::disk('public')->delete($oldImage);
        }
        $this->cms->forgetHomepage();
        return redirect()->route('admin.cms.index', ['tab' => 'projects'])->with('success', 'Project updated.');
    }

    public function destroyProject(Project $project)
    {
        if ($project->donations()->exists()) {
            return back()->with('error', 'Projects with donation records cannot be deleted. Deactivate it instead.');
        }
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }
        $project->delete();
        $this->cms->forgetHomepage();
        return back()->with('success', 'Project deleted.');
    }

    private function projectData(Request $request, ?Project $project = null): array
    {
        return $request->validate([
            'tag' => ['nullable', 'string', 'max:100'],
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string', 'max:10000'],
            'goal_amount' => ['required', 'numeric', 'min:0'],
            'location' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:active,completed,upcoming'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:9999'],
            'is_active' => ['nullable', 'boolean'],
            'image' => [$project ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
        ]) + ['is_active' => $request->boolean('is_active')];
    }

    private function itemConfig(string $type): array
    {
        return match ($type) {
            'impact' => [ImpactLevel::class, ['level' => ['required', 'string', 'max:80'], 'title' => ['required', 'string', 'max:255'], 'sort_order' => ['required', 'integer', 'min:0'], 'is_active' => ['nullable', 'boolean']]],
            'gallery' => [GalleryItem::class, ['title' => ['required', 'string', 'max:255'], 'caption' => ['nullable', 'string', 'max:2000'], 'category' => ['nullable', 'string', 'max:100'], 'sort_order' => ['required', 'integer', 'min:0'], 'is_active' => ['nullable', 'boolean'], 'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120']]],
            'events' => [LandingEvent::class, ['title' => ['required', 'string', 'max:255'], 'description' => ['nullable', 'string', 'max:5000'], 'event_date' => ['required', 'date'], 'location' => ['nullable', 'string', 'max:255'], 'status' => ['required', 'string', 'max:50'], 'sort_order' => ['required', 'integer', 'min:0'], 'is_active' => ['nullable', 'boolean'], 'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120']]],
            'testimonials' => [Testimonial::class, ['author_name' => ['required', 'string', 'max:255'], 'role' => ['nullable', 'string', 'max:255'], 'testimonial' => ['required', 'string', 'max:5000'], 'rating' => ['nullable', 'integer', 'between:1,5'], 'sort_order' => ['required', 'integer', 'min:0'], 'is_active' => ['nullable', 'boolean'], 'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120']]],
            'team' => [TeamMember::class, ['name' => ['required', 'string', 'max:255'], 'role' => ['required', 'string', 'max:255'], 'bio' => ['nullable', 'string', 'max:5000'], 'sort_order' => ['required', 'integer', 'min:0'], 'is_founder' => ['nullable', 'boolean'], 'is_active' => ['nullable', 'boolean'], 'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120']]],
            'info-cards' => [InfoCard::class, ['badge' => ['nullable', 'string', 'max:100'], 'title' => ['required', 'string', 'max:255'], 'description' => ['nullable', 'string', 'max:3000'], 'link_text' => ['nullable', 'string', 'max:100'], 'link_url' => ['nullable', 'max:2048', 'regex:/^(https?:\/\/|\/)/i'], 'sort_order' => ['required', 'integer', 'min:0'], 'is_active' => ['nullable', 'boolean'], 'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120']]],
            'partners' => [Partner::class, ['name' => ['required', 'string', 'max:255'], 'description' => ['nullable', 'string', 'max:2000'], 'sort_order' => ['required', 'integer', 'min:0'], 'is_active' => ['nullable', 'boolean'], 'image' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,svg', 'max:5120']]],
            default => abort(404),
        };
    }

    private function paidStatuses(): array
    {
        return ['successful', 'completed', 'paid', 'confirmed'];
    }

    private function cmsTabs(): array
    {
        return ['hero', 'about', 'mission', 'vision', 'values', 'impact', 'projects', 'gallery', 'events', 'testimonials', 'team', 'blog', 'volunteer', 'memorial-banner', 'donate-impact', 'partners', 'cta', 'info-cards'];
    }

    private function findEditableItem(Request $request): mixed
    {
        $type = $request->query('edit_type');
        $id = $request->integer('edit');

        if (! $type || ! $id) {
            return null;
        }

        [$model] = $this->itemConfig($type);

        return $model::find($id);
    }
}