<?php

namespace App\Services;

use App\Models\Blog;
use App\Models\CmsSection;
use App\Models\GalleryItem;
use App\Models\ImpactLevel;
use App\Models\InfoCard;
use App\Models\LandingEvent;
use App\Models\Project;
use App\Models\Partner;
use App\Models\TeamMember;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class CmsService
{
    public function homepage(): array
    {
        if (! Schema::hasTable('cms_sections')) {
            return $this->emptyHomepage();
        }

        return Cache::remember('homepage.cms', now()->addMinutes(10), function (): array {
            $sections = CmsSection::with(['contents' => fn ($query) => $query->where('is_active', true)->orderBy('sort_order')])
                ->where('is_enabled', true)
                ->orderBy('sort_order')
                ->get()
                ->keyBy('key');

            $projects = Project::query()
                ->where('status', 'active')
                ->where(fn ($query) => $query->whereNull('is_active')->orWhere('is_active', true))
                ->withSum(['donations as raised_total' => fn ($query) => $query->whereIn('status', ['successful', 'completed', 'paid', 'confirmed'])], 'amount')
                ->orderBy('sort_order')
                ->get();

            foreach ($projects as $project) {
                $project->raised_amount = min((float) ($project->raised_total ?? 0), (float) $project->goal_amount);
            }

            return [
                'sections' => $sections,
                'hero' => $sections->get('hero')?->contents->first(),
                'about' => $sections->get('about')?->contents->first(),
                'mission' => $sections->get('mission')?->contents->first(),
                'vision' => $sections->get('vision')?->contents->first(),
                'values' => $sections->get('values')?->contents ?? collect(),
                'volunteerSection' => $sections->get('volunteer')?->contents->first(),
                'projects' => $projects,
                'partners' => Partner::where('is_active', true)->orderBy('sort_order')->get(),
                'impactLevels' => ImpactLevel::where('is_active', true)->orderBy('sort_order')->get(),
                'galleryItems' => GalleryItem::where('is_active', true)->orderBy('sort_order')->get(),
                'events' => LandingEvent::where('is_active', true)->where('event_date', '>=', now()->startOfDay())->orderBy('event_date')->orderBy('sort_order')->get(),
                'testimonials' => Testimonial::where('is_active', true)->orderBy('sort_order')->get(),
                'teamMembers' => TeamMember::where('is_active', true)->orderBy('sort_order')->get(),
                'infoCards' => InfoCard::where('is_active', true)->orderBy('sort_order')->get(),
                'blogPosts' => Blog::published()->where('is_featured', true)->latest('published_at')->take(3)->get(),
            ];
        });
    }

    public function forgetHomepage(): void
    {
        Cache::forget('homepage.cms');
    }

    private function emptyHomepage(): array
    {
        return [
            'sections' => collect(), 'hero' => null, 'about' => null, 'mission' => null,
            'vision' => null, 'values' => collect(), 'volunteerSection' => null,
            'projects' => collect(), 'impactLevels' => collect(), 'galleryItems' => collect(),
            'partners' => collect(),
            'events' => collect(), 'testimonials' => collect(), 'teamMembers' => collect(),
            'infoCards' => collect(), 'blogPosts' => collect(),
        ];
    }
}