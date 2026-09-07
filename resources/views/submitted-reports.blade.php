@extends('layouts.app')

@section('title', 'Submitted Reports')

@section('content')
<style>
    .report-card {
        overflow: hidden;
    }

    .report-title {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        max-width: 100%;
    }

    .report-description {
        display: block;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
        word-break: break-word;
    }

    .submitted-title {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    @media (max-width: 640px) {
        .submitted-header {
            align-items: flex-start !important;
            gap: 1rem !important;
        }

        .submitted-title {
            display: block;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            width: 100%;
            margin-right: 0.5rem;
        }

        .submitted-action {
            align-self: flex-end;
            margin-left: auto;
            min-width: 122px;
            text-align: center;
        }
    }
</style>
<section class="py-20 bg-slate-50">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="submitted-header mb-8 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="submitted-title text-3xl font-extrabold text-slate-800">Submitted Announcement</h1>
            <a href="/submit" class="submitted-action rounded-full bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">+ New Report</a>
        </div>

        @if(session('success'))
            <div class="mb-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if($reports->isEmpty())
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center text-slate-600">
                No reports have been submitted yet.
            </div>
        @else
            <div class="space-y-4">
                @foreach($reports as $report)
                    <div class="report-card rounded-2xl bg-white shadow-sm border border-slate-200 p-6">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">
                           <div class="min-w-0 md:max-w-[80%]">
                                <p class="text-sm text-sky-600 font-semibold uppercase">{{ $report->report_type ?? 'Report' }}</p>
                               <h2 class="report-title text-xl font-bold text-slate-800">{{ $report->title }}</h2>
                            </div>
                           <div class="flex items-center gap-2 shrink-0">
                                <a href="{{ $report->report_type === 'Announcement' ? route('announcements.edit', $report) : route('reports.edit', $report) }}" class="rounded-lg border border-sky-200 bg-sky-50 px-3 py-2 text-sm font-semibold text-sky-700 hover:bg-sky-100">Edit</a>
                                <form action="{{ route('reports.destroy', $report) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this report?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-100">Delete</button>
                                </form>
                            </div>
                        </div>
                        <p class="report-description mt-3 text-slate-600">{{ $report->description }}</p>
                        <div class="mt-4 text-sm text-slate-500">{{ $report->created_at?->format('d M Y') }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection
