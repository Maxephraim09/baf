<div class="form-row">
    <div class="form-group"><label>Tag</label><input class="form-control" name="tag" value="{{ old('tag') }}"></div>
    <div class="form-group"><label>Title</label><input class="form-control" name="title" value="{{ old('title') }}" required></div>
</div>
<div class="form-group"><label>Description</label><textarea class="form-control" name="description" rows="4" required>{{ old('description') }}</textarea></div>
<div class="form-row">
    <div class="form-group"><label>Goal amount</label><input class="form-control" type="number" min="0" step="0.01" name="goal_amount" value="{{ old('goal_amount') }}" required></div>
    <div class="form-group"><label>Location</label><input class="form-control" name="location" value="{{ old('location') }}"></div>
    <div class="form-group"><label>Status</label><select class="form-control" name="status"><option value="active">Active</option><option value="upcoming">Upcoming</option><option value="completed">Completed</option></select></div>
</div>
<div class="form-row">
    <div class="form-group"><label>Start date</label><input class="form-control" type="date" name="start_date" value="{{ old('start_date') }}"></div>
    <div class="form-group"><label>End date</label><input class="form-control" type="date" name="end_date" value="{{ old('end_date') }}"></div>
    <div class="form-group"><label>Sort order</label><input class="form-control" type="number" min="0" name="sort_order" value="{{ old('sort_order', 0) }}"></div>
</div>
<div class="form-group"><label>Image</label><input class="form-control" type="file" name="image" accept="image/jpeg,image/png,image/webp" required></div>
<label><input type="checkbox" name="is_active" value="1" checked> Published / active</label>
<p style="margin-top:.75rem;color:var(--gray-500);">Raised and progress are calculated from confirmed donation records. They cannot be edited here.</p>
