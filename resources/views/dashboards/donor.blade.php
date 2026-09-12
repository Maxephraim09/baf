@extends('layouts.app')

@section('content')
@include('dashboards.partials.role-panel', [
    'roleLabel' => 'Donor dashboard',
    'intro' => 'Thank you for helping communities move forward. Choose a project or make a general contribution when you are ready.',
    'actionUrl' => route('donate'),
    'actionLabel' => 'Make a donation',
    'panelTitle' => 'Make your next impact',
    'panelText' => 'Your support helps fund practical work across education, healthcare, community development, and humanitarian relief.',
])
@endsection
