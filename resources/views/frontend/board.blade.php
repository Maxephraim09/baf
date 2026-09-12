@extends('layouts.app')
@section('content')
<div class="mx-auto max-w-6xl px-4 py-16 sm:px-6 lg:px-8"><a class="text-sm font-semibold" style="color:var(--primary)" href="{{ route('home') }}">&larr; Back to home</a><h1 class="mt-6 text-4xl font-bold" style="color:var(--secondary)">Board Members</h1><div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">@forelse($members as $member)<article class="rounded-xl bg-white p-6 shadow"><h2 class="text-xl font-bold" style="color:var(--primary)">{{ $member->name }}</h2><p class="mt-1 font-semibold text-gray-700">{{ $member->role }}</p><p class="mt-3 text-gray-600">{{ $member->bio }}</p></article>@empty<p class="text-gray-600">Board profiles will be published soon.</p>@endforelse</div></div>
@endsection
