@extends('layouts.app')
@section('content')
<div class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:px-8"><a class="text-sm font-semibold" style="color:var(--primary)" href="{{ route('heritage.index') }}">&larr; Back to heritage</a><p class="mt-6 text-xs font-bold uppercase" style="color:var(--primary)">{{ str_replace('_', ' ', $item->type) }}</p><h1 class="mt-2 text-4xl font-bold" style="color:var(--secondary)">{{ $item->title }}</h1><p class="mt-6 text-lg leading-8 text-gray-600">{{ $item->description }}</p>@if($item->media_path)<a class="mt-8 inline-flex rounded-lg px-5 py-3 font-bold text-white" style="background:var(--primary)" href="{{ route('heritage.download', $item) }}">Download resource</a>@endif</div>
@endsection
