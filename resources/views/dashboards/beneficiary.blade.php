@extends('layouts.app')

@section('content')
@include('dashboards.partials.role-panel', [
    'roleLabel' => 'Beneficiary dashboard',
    'intro' => 'Keep your foundation support information in one place and contact our team whenever you need assistance.',
    'actionUrl' => route('contact'),
    'actionLabel' => 'Request support',
    'panelTitle' => 'Your support journey',
    'panelText' => 'Our team can help you understand available programs and guide you toward the right support channel.',
])
@endsection
