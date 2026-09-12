@extends('layouts.admin')

@section('content')
@php
    $tabLabel = ['hero'=>'Hero','about'=>'About','mission'=>'Mission','vision'=>'Vision','values'=>'Value','impact'=>'Impact Level','projects'=>'Project','gallery'=>'Gallery Item','events'=>'Event','testimonials'=>'Testimonial','team'=>'Team Member','blog'=>'Post','volunteer'=>'Volunteer Content','memorial-banner'=>'Memorial Banner','donate-impact'=>'Donation Impact','partners'=>'Partners & Sponsors','cta'=>'Call to Action','info-cards'=>'Info Card'][$activeTab] ?? ucfirst($activeTab);
    $back = route('admin.cms.index', ['tab' => $activeTab]);
    $isEdit = $action === 'edit';
    $updateOnlyTabs = ['hero','about','mission','vision','volunteer','memorial-banner','donate-impact','cta'];
    $isUpdateOnly = in_array($activeTab, $updateOnlyTabs, true);
@endphp
<style>
    .cms-action-page { max-width: 1100px; margin: 0 auto; }
    .cms-action-header, .cms-form-container, .cms-view-container { background: var(--surface); border: 1px solid var(--gray-200); border-radius: 16px; box-shadow: 0 12px 32px rgba(15,23,42,.06); }
    .cms-action-header { align-items: flex-start; display: flex; justify-content: space-between; gap: 1.5rem; margin-bottom: 1rem; padding: 1.5rem 1.75rem; }
    .cms-back-link { color: var(--primary); font-size: .82rem; font-weight: 800; text-decoration: none; }
    .cms-back-link:hover { color: var(--primary-dark); text-decoration: underline; }
    .cms-action-header h1 { color: var(--text-strong); font-size: clamp(1.5rem, 3vw, 2rem); line-height: 1.15; margin: .8rem 0 .4rem; }
    .cms-action-header p { color: var(--text-muted); line-height: 1.55; margin: 0; max-width: 680px; }
    .cms-mode-badge { align-items: center; background: var(--primary-glow); border: 1px solid var(--primary); border-radius: 999px; color: var(--primary-dark); display: inline-flex; font-size: .72rem; font-weight: 800; gap: .4rem; padding: .45rem .7rem; white-space: nowrap; }
    .cms-form-container { border-top: 4px solid var(--primary); padding: 1.75rem; }
    .cms-form-container > h2 { color: var(--text-strong); font-size: 1.15rem; margin: 0 0 1.25rem; }
    .cms-form-section { border: 1px solid var(--gray-200); border-radius: 12px; margin-bottom: 1.25rem; padding: 1rem 1.1rem .25rem; }
    .cms-form-section h3 { color: var(--text-strong); font-size: .9rem; margin: 0 0 .85rem; }
    .cms-form-section p { color: var(--text-muted); font-size: .8rem; line-height: 1.5; margin: -.45rem 0 1rem; }
    .cms-form-container .form-group { margin-bottom: 1rem; }
    .cms-form-container .form-group label { color: var(--text-body); font-size: .82rem; }
    .cms-form-container .form-group input,
    .cms-form-container .form-group select,
    .cms-form-container .form-group textarea { background: var(--surface); color: var(--text-body); min-height: 44px; }
    .cms-form-container .form-group textarea { min-height: 120px; resize: vertical; }
    .cms-form-container input[type="file"] { padding: .55rem .7rem; }
    .cms-form-check { align-items: center; background: var(--surface-muted); border: 1px solid var(--gray-200); border-radius: 9px; color: var(--text-body); display: inline-flex; font-size: .82rem; gap: .55rem; padding: .7rem .8rem; }
    .cms-form-check input { accent-color: var(--primary); }
    .cms-form-container .form-actions { margin-top: 1.5rem; }
    .cms-form-container .btn-primary, .cms-view-container .btn-secondary { min-height: 42px; }
    .cms-view-container { padding: 1.5rem; }
    .cms-view-container h2 { color: var(--text-strong); margin: 0 0 1rem; }
    .cms-view-container p { border-bottom: 1px solid var(--gray-200); color: var(--text-body); line-height: 1.6; margin: 0; padding: .8rem 0; }
    @media (max-width: 700px) { .cms-action-header { flex-direction: column; padding: 1.25rem; } .cms-mode-badge { align-self: flex-start; } .cms-form-container { padding: 1rem; } .cms-form-section { padding: .85rem .85rem .15rem; } }
</style>
<div class="cms-action-page">
    <div class="cms-action-header"><div><a class="cms-back-link" href="{{ $back }}"><i class="fas fa-arrow-left"></i> Back to {{ $tabLabel }} table</a><h1>{{ $action === 'section-title' ? 'Update Section Title' : ($isUpdateOnly ? 'Update' : ($isEdit ? 'Edit' : 'Add')) }} {{ $tabLabel }}</h1><p>{{ $isUpdateOnly ? 'Update the existing section content for this page block.' : 'Complete the fields below, then save to publish the latest content.' }}</p></div><span class="cms-mode-badge"><i class="fas {{ $isUpdateOnly ? 'fa-sync-alt' : ($isEdit ? 'fa-pen' : 'fa-plus') }}"></i> {{ $isUpdateOnly ? 'Update only' : ($isEdit ? 'Editing record' : 'New record') }}</span></div>
    <div class="panel-card cms-form-container">
    @if($action === 'section-title')
        <h2>Update Section Title</h2><form method="POST" action="{{ route('admin.cms.sections.update', $section) }}">@csrf @method('PUT')<input type="hidden" name="return_tab" value="{{ $activeTab }}"><div class="form-group"><label>Section name</label><input class="form-control" name="name" value="{{ old('name', $section?->name) }}" required></div><div class="form-group"><label>Description</label><textarea class="form-control" name="description" rows="5">{{ old('description', $section?->description) }}</textarea></div><input type="hidden" name="sort_order" value="{{ $section?->sort_order ?? 0 }}"><label class="cms-form-check"><input type="checkbox" name="is_enabled" value="1" @checked($section?->is_enabled ?? true)> Section enabled</label><div class="form-actions"><button class="btn-primary"><i class="fas fa-save"></i> Save Section Title</button></div></form>
    @elseif($action === 'view')
        <section class="cms-view-container"><h2>View {{ $tabLabel }}</h2>@if($editProject)<p><strong>Title:</strong> {{ $editProject->title }}</p><p><strong>Description:</strong> {{ $editProject->description }}</p><p><strong>Goal:</strong> {{ number_format($editProject->goal_amount, 2) }}</p>@elseif($editItem)<p><strong>Title:</strong> {{ $editItem->title ?? $editItem->name ?? $editItem->author_name ?? $editItem->level ?? $editItem->badge }}</p><p><strong>Description:</strong> {{ $editItem->description ?? $editItem->bio ?? $editItem->testimonial ?? $editItem->caption }}</p><p><strong>Status:</strong> {{ $editItem->is_active ? 'Active' : 'Hidden' }}</p>@else<p>No record details are available.</p>@endif<a class="btn-secondary" href="{{ $back }}"><i class="fas fa-arrow-left"></i> Back to table</a></section>
    @elseif(in_array($activeTab, ['hero','about','mission','vision','volunteer','memorial-banner','donate-impact','cta'], true))
        <form method="POST" action="{{ route('admin.cms.sections.content.update', $section) }}" enctype="multipart/form-data">@csrf @method('PUT')<div class="form-group"><label>Title</label><input class="form-control" name="title" value="{{ old('title', $content?->title) }}"></div><div class="form-group"><label>Subtitle</label><input class="form-control" name="subtitle" value="{{ old('subtitle', $content?->subtitle) }}"></div><div class="form-group"><label>Description</label><textarea class="form-control" name="description" rows="6">{{ old('description', $content?->description) }}</textarea></div><div class="form-row"><div class="form-group"><label>Button text</label><input class="form-control" name="button_text" value="{{ old('button_text', $content?->button_text) }}"></div><div class="form-group"><label>Button URL</label><input class="form-control" type="url" name="button_link" value="{{ old('button_link', $content?->button_link) }}"></div></div><div class="form-group"><label>Image</label><input class="form-control" type="file" name="image" accept="image/jpeg,image/png,image/webp"></div><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $content?->is_active ?? true))> Active</label><div class="form-actions"><button class="btn-primary">Save {{ $tabLabel }}</button></div></form>
    @elseif($activeTab === 'projects')
        <form method="POST" action="{{ $isEdit ? route('admin.cms.projects.update', $editProject) : route('admin.cms.projects.store') }}" enctype="multipart/form-data">@csrf @if($isEdit) @method('PUT') @endif @include($isEdit ? 'admin.cms.partials.project-edit-fields' : 'admin.cms.partials.project-fields')<div class="form-actions"><button class="btn-primary">Save Project</button></div></form>
    @elseif($activeTab === 'values')
        <form method="POST" action="{{ $isEdit ? route('admin.cms.sections.values.update', [$section, $editItem]) : route('admin.cms.sections.values.store', $section) }}">@csrf @if($isEdit) @method('PUT') @endif<div class="form-group"><label>Title</label><input class="form-control" name="title" value="{{ old('title', $editItem?->title) }}" required></div><div class="form-group"><label>Description</label><textarea class="form-control" name="description" required>{{ old('description', $editItem?->description) }}</textarea></div><div class="form-group"><label>Sort order</label><input class="form-control" type="number" name="sort_order" min="0" value="{{ old('sort_order', $editItem?->sort_order ?? 0) }}" required></div><label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $editItem?->is_active ?? true))> Active</label><div class="form-actions"><button class="btn-primary">Save Value</button></div></form>
    @elseif($activeTab === 'partners')
        <form method="POST" action="{{ $isEdit ? route('admin.cms.items.update', ['type' => 'partners', 'id' => $editItem->id]) : route('admin.cms.items.store', 'partners') }}" enctype="multipart/form-data">@csrf @if($isEdit) @method('PUT') @endif
            <div class="cms-form-section"><h3>Partner details</h3><div class="form-row"><div class="form-group"><label for="partner-name">Partner name</label><input id="partner-name" class="form-control" name="name" value="{{ old('name', $editItem?->name) }}" required></div><div class="form-group"><label for="partner-order">Display order</label><input id="partner-order" class="form-control" type="number" name="sort_order" min="0" value="{{ old('sort_order', $editItem?->sort_order ?? 0) }}" required></div></div><div class="form-group"><label for="partner-description">Description</label><textarea id="partner-description" class="form-control" name="description" rows="4">{{ old('description', $editItem?->description) }}</textarea></div></div>
            <div class="cms-form-section"><h3>Logo</h3><p>Upload a clear partner logo in JPG, PNG, WebP, or SVG format.</p><div class="form-group"><label for="partner-logo">{{ $isEdit ? 'Replace logo' : 'Partner logo' }}</label><input id="partner-logo" class="form-control" type="file" name="image" accept="image/jpeg,image/png,image/webp,image/svg+xml" @required(! $isEdit)></div></div>
            <label class="cms-form-check"><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $editItem?->is_active ?? true))> Show on website</label><div class="form-actions"><a class="btn-secondary" href="{{ $back }}">Cancel</a><button class="btn-primary"><i class="fas fa-save"></i> {{ $isEdit ? 'Update Partner' : 'Add Partner' }}</button></div>
        </form>
    @elseif($activeTab === 'blog')
        <div class="panel-card"><h2>Blog / News</h2><p>Use the existing blog management area to create and edit posts. This CMS tab intentionally does not duplicate Blog records.</p></div>
    @else
        <form method="POST" action="{{ $isEdit ? route('admin.cms.items.update', ['type' => $activeTab, 'id' => $editItem->id]) : route('admin.cms.items.store', $activeTab) }}" enctype="multipart/form-data">@csrf @if($isEdit) @method('PUT') @endif
            <div class="form-row">
                @if($activeTab === 'impact')<div class="form-group"><label>Level</label><input class="form-control" name="level" value="{{ old('level', $editItem?->level) }}" required></div>@endif
                <div class="form-group"><label>{{ $activeTab === 'testimonials' ? 'Author name' : ($activeTab === 'team' ? 'Name' : 'Title') }}</label><input class="form-control" name="{{ $activeTab === 'testimonials' ? 'author_name' : ($activeTab === 'team' ? 'name' : 'title') }}" value="{{ old($activeTab === 'testimonials' ? 'author_name' : ($activeTab === 'team' ? 'name' : 'title'), $editItem?->title ?? $editItem?->name ?? $editItem?->author_name) }}" required></div>
                <div class="form-group"><label>Sort order</label><input class="form-control" type="number" name="sort_order" min="0" value="{{ old('sort_order', $editItem?->sort_order ?? 0) }}" required></div>
            </div>
            <div class="form-group"><label>{{ $activeTab === 'testimonials' ? 'Testimonial' : ($activeTab === 'team' ? 'Bio' : ($activeTab === 'events' || $activeTab === 'info-cards' ? 'Description' : ($activeTab === 'gallery' ? 'Caption' : 'Description'))) }}</label><textarea class="form-control" name="{{ $activeTab === 'testimonials' ? 'testimonial' : ($activeTab === 'team' ? 'bio' : ($activeTab === 'events' || $activeTab === 'info-cards' ? 'description' : 'caption')) }}">{{ old($activeTab === 'testimonials' ? 'testimonial' : ($activeTab === 'team' ? 'bio' : ($activeTab === 'events' || $activeTab === 'info-cards' ? 'description' : 'caption')), $editItem?->description ?? $editItem?->bio ?? $editItem?->testimonial ?? $editItem?->caption) }}</textarea></div>
            @if(in_array($activeTab, ['gallery', 'info-cards'], true))<div class="form-group"><label>{{ $activeTab === 'gallery' ? 'Category' : 'Badge' }}</label><input class="form-control" name="{{ $activeTab === 'gallery' ? 'category' : 'badge' }}" value="{{ old($activeTab === 'gallery' ? 'category' : 'badge', $editItem?->{$activeTab === 'gallery' ? 'category' : 'badge'}) }}"></div>@endif
            @if($activeTab === 'info-cards')<div class="form-row"><div class="form-group"><label>Link text</label><input class="form-control" name="link_text" value="{{ old('link_text', $editItem?->link_text) }}"></div><div class="form-group"><label>Link URL</label><input class="form-control" type="url" name="link_url" value="{{ old('link_url', $editItem?->link_url) }}"></div></div>@endif
            @if(in_array($activeTab, ['testimonials', 'team'], true))<div class="form-row"><div class="form-group"><label>Role</label><input class="form-control" name="role" value="{{ old('role', $editItem?->role) }}" @required($activeTab === 'team')></div>@if($activeTab === 'testimonials')<div class="form-group"><label>Rating</label><input class="form-control" type="number" name="rating" min="1" max="5" value="{{ old('rating', $editItem?->rating) }}"></div>@endif</div>@endif
            @if($activeTab === 'events')<div class="form-row"><div class="form-group"><label>Date</label><input class="form-control" type="datetime-local" name="event_date" value="{{ old('event_date', optional($editItem?->event_date)->format('Y-m-d\\TH:i')) }}" required></div><div class="form-group"><label>Location</label><input class="form-control" name="location" value="{{ old('location', $editItem?->location) }}"></div><div class="form-group"><label>Status</label><input class="form-control" name="status" value="{{ old('status', $editItem?->status ?? 'upcoming') }}" required></div></div>@endif
            @if(in_array($activeTab, ['gallery', 'testimonials', 'team', 'info-cards', 'events'], true))<div class="form-group"><label>Image</label><input class="form-control" type="file" name="image" accept="image/jpeg,image/png,image/webp" @required($activeTab === 'gallery' && ! $isEdit)></div>@endif
            @if($activeTab === 'team')<label><input type="checkbox" name="is_founder" value="1" @checked(old('is_founder', $editItem?->is_founder ?? false))> Founder / President</label>@endif
            <label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $editItem?->is_active ?? true))> Active</label><div class="form-actions"><button class="btn-primary">Save {{ $tabLabel }}</button></div>
        </form>
    @endif
    </div>
</div>
@endsection