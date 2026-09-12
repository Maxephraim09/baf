<div class="form-row">
    <div class="form-group"><label>Tag</label><input class="form-control" name="tag" value="{{ old('tag', $editProject->tag) }}"></div>
    <div class="form-group"><label>Title</label><input class="form-control" name="title" value="{{ old('title', $editProject->title) }}" required></div>
</div>
<div class="form-group"><label>Description</label><textarea class="form-control" name="description" rows="5" required>{{ old('description', $editProject->description) }}</textarea></div>
<div class="form-row">
    <div class="form-group"><label>Goal amount</label><input class="form-control" type="number" min="0" step="0.01" name="goal_amount" value="{{ old('goal_amount', $editProject->goal_amount) }}" required></div>
    <div class="form-group"><label>Location</label><input class="form-control" name="location" value="{{ old('location', $editProject->location) }}"></div>
    <div class="form-group"><label>Status</label><select class="form-control" name="status"><option value="active" @selected(old('status', $editProject->status) === 'active')>Active</option><option value="upcoming" @selected(old('status', $editProject->status) === 'upcoming')>Upcoming</option><option value="completed" @selected(old('status', $editProject->status) === 'completed')>Completed</option></select></div>
</div>
<div class="form-row">
    <div class="form-group"><label>Start date</label><input class="form-control" type="date" name="start_date" value="{{ old('start_date', optional($editProject->start_date)->format('Y-m-d')) }}"></div>
    <div class="form-group"><label>End date</label><input class="form-control" type="date" name="end_date" value="{{ old('end_date', optional($editProject->end_date)->format('Y-m-d')) }}"></div>
    <div class="form-group"><label>Sort order</label><input class="form-control" type="number" min="0" name="sort_order" value="{{ old('sort_order', $editProject->sort_order) }}" required></div>
</div>
<div class="form-group"><label>Replace image <small>Optional</small></label><input class="form-control" type="file" name="image" accept="image/jpeg,image/png,image/webp"></div>
<label><input type="checkbox" name="is_active" value="1" @checked(old('is_active', $editProject->is_active))> Published / active</label>
<p style="margin-top:.75rem;color:var(--text-muted);">Raised and progress remain calculated from confirmed donation records.</p>
