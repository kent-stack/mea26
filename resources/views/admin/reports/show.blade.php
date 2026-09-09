@extends('layouts.app')

@section('title', 'Report Details')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="mb-6">
        <a href="{{ route('admin.reports.index') }}" class="text-blue-600 hover:underline">&larr; Back to list</a>
    </div>

    <div class="bg-white rounded shadow p-6">
        <h2 class="text-xl font-semibold mb-2">{{ $report->title }}</h2>
        <p class="text-sm text-gray-600 mb-4">Submitted by: {{ $report->student_name ?? optional($report->submitter)->name ?? $report->student_email }} — {{ $report->created_at->format('Y-m-d H:i') }}</p>

        <div class="prose max-w-none mb-4">{!! nl2br(e($report->description)) !!}</div>

        @php
            $photos = [];
            if (is_array($report->photos)) {
                $photos = $report->photos;
            } elseif (is_string($report->photos) && strlen(trim($report->photos)) > 0) {
                $decoded = json_decode($report->photos, true);
                $photos = is_array($decoded) ? $decoded : [];
            }
        @endphp

        @if(!empty($photos))
            <div class="grid grid-cols-2 gap-4">
                @foreach($photos as $index => $photo)
                    <img src="{{ route('reports.media', [$report, $index]) }}" alt="photo" class="w-full rounded" />
                @endforeach
            </div>
        @endif

        <div class="mt-6 flex space-x-2">
            <form method="POST" action="{{ route('admin.reports.destroy', $report) }}" onsubmit="return confirm('Are you sure you want to delete this report?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="px-4 py-2 bg-red-600 text-white rounded">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
