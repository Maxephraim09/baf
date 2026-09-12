@extends('layouts.app')

@section('content')
@include('dashboards.partials.role-panel', [
    'roleLabel' => 'Volunteer dashboard',
    'intro' => 'Find meaningful ways to contribute your time and skills, then keep your volunteer profile up to date.',
    'actionUrl' => route('volunteer'),
    'actionLabel' => 'Apply to volunteer',
    'panelTitle' => 'Ready to get involved?',
    'panelText' => 'Complete the volunteer application so our team can understand your interests, availability, and experience.',
])
@endsection
