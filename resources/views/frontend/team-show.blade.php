@extends('layouts.app')
@section('content')
<div class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:px-8"><a class="text-sm font-semibold" style="color:var(--primary)" href="{{ route('team') }}">&larr; Back to team</a><h1 class="mt-6 text-4xl font-bold" style="color:var(--secondary)">{{ $member->name }}</h1><p class="mt-2 text-lg font-semibold" style="color:var(--primary)">{{ $member->role }}</p><p class="mt-6 text-lg leading-8 text-gray-600">{{ $member->bio }}</p></div>
@endsection
