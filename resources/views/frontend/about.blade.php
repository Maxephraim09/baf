@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-5xl px-4 py-16 sm:px-6 lg:px-8">
	<a class="text-sm font-semibold" style="color:var(--primary)" href="{{ route('home') }}">&larr; Back to home</a>
	<h1 class="mt-6 text-4xl font-bold" style="color:var(--secondary)">{{ $about?->title ?? 'Our History' }}</h1>
	<p class="mt-4 text-lg leading-8 text-gray-600">{{ $about?->description ?? 'Learn about the history and work of Agontara Foundation.' }}</p>
	<div class="mt-10 grid gap-6 md:grid-cols-2">
		<article class="rounded-xl bg-white p-6 shadow"><h2 class="text-2xl font-bold" style="color:var(--primary)">{{ $mission?->title ?? 'Our Mission' }}</h2><p class="mt-3 leading-7 text-gray-600">{{ $mission?->description ?? 'To empower communities through sustainable action.' }}</p></article>
		<article class="rounded-xl bg-white p-6 shadow"><h2 class="text-2xl font-bold" style="color:var(--primary)">{{ $vision?->title ?? 'Our Vision' }}</h2><p class="mt-3 leading-7 text-gray-600">{{ $vision?->description ?? 'A just and thriving future for every community.' }}</p></article>
	</div>
</div>
@endsection
