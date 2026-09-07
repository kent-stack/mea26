@extends('layouts.app')

@section('title', 'Report Management')

@section('content')
<div class="container mx-auto px-4 pt-24 pb-8 md:pt-28">
    <div class="mb-8 mt-2 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="text-2xl font-semibold">Report Management</h1>
        <form method="GET" action="{{ route('admin.reports.index') }}" class="flex flex-col gap-3 sm:flex-row sm:items-center sm:space-x-2 mobile-filter-form">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Search title, description, or name" class="w-full rounded border border-slate-300 px-3 py-2 sm:w-auto mobile-filter-input" />
            <select name="type" onchange="this.form.submit()" class="w-full rounded border border-slate-300 px-3 py-2 sm:w-auto mobile-filter-select">
                <option value="">All Types</option>
                <option value="Daily Report" {{ request('type')=='Daily Report' ? 'selected' : '' }}>Daily Report</option>
                <option value="Weekly Report" {{ request('type')=='Weekly Report' ? 'selected' : '' }}>Weekly Report</option>
            </select>
        </form>
    </div>

    @if(session('success'))
        <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">{{ session('success') }}</div>
    @endif

    @if($reports->isEmpty())
        <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center text-slate-600">
            No reports found.
        </div>
    @else
        <div class="space-y-5">
            @foreach($reports as $report)
                <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm sm:p-6 report-card-item">
                    <div class="flex flex-col gap-3 md:flex-row md:items-center md:justify-between">
                        <div class="min-w-0">
                            <p class="text-sm font-semibold uppercase text-sky-600">{{ $report->report_type ?? 'Report' }}</p>
                            <h2 class="report-title mt-1 text-xl font-bold text-slate-800 break-words">{{ $report->title }}</h2>
                        </div>
                        <div class="mobile-action-group flex w-full gap-2 md:w-auto">
                            <a href="{{ route('admin.reports.show', $report) }}" class="mobile-action-btn rounded-lg border border-sky-200 bg-sky-50 px-3 py-2 text-center text-sm font-semibold text-sky-700 hover:bg-sky-100">View</a>
                            <form method="POST" action="{{ route('admin.reports.destroy', $report) }}" onsubmit="return confirm('Are you sure you want to delete this report?');" class="mobile-action-form">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="mobile-action-btn rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm font-semibold text-red-700 hover:bg-red-100">Delete</button>
                            </form>
                        </div>
                    </div>
                    <p class="report-description mt-3 break-words text-slate-600">{{ Str::limit($report->description, 180) }}</p>
                    <div class="mt-4 text-sm text-slate-500">
                        Submitted by {{ $report->student_name ?? optional($report->submitter)->name ?? $report->student_email }} · {{ $report->created_at?->format('d M Y') }}
                    </div>
                </div>
            @endforeach
        </div>
    @endif

    <div class="mt-5">
        @if($reports->hasPages())
            <nav aria-label="Pagination" class="flex justify-center">
                <ul class="flex flex-wrap items-center gap-2">
                    @if($reports->currentPage() > 1)
                        <li>
                            <a href="{{ $reports->previousPageUrl() }}" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
                                Previous
                            </a>
                        </li>
                    @endif

                    @foreach($reports->getUrlRange(1, $reports->lastPage()) as $page => $url)
                        <li>
                            @if($page == $reports->currentPage())
                                <span class="rounded-lg bg-slate-900 px-3 py-2 text-sm font-semibold text-white">
                                    {{ $page }}
                                </span>
                            @else
                                <a href="{{ $url }}" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
                                    {{ $page }}
                                </a>
                            @endif
                        </li>
                    @endforeach

                    @if($reports->hasMorePages())
                        <li>
                            <a href="{{ $reports->nextPageUrl() }}" class="rounded-lg border border-slate-300 bg-white px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
                                Next
                            </a>
                        </li>
                    @endif
                </ul>
            </nav>
        @endif
    </div>
</div>

<style>
    .pt-2{
        padding-top: 1.5rem !important;
    }
    @media (max-width: 640px) {
        .container {
            padding-top: 5.75rem !important;
        }

        .mb-8 {
            margin-top: 0.25rem !important;
        }

        .mobile-filter-form {
            display: flex !important;
            flex-direction: row !important;
            align-items: center !important;
            gap: 0.5rem !important;
        }

        .mobile-filter-input,
        .mobile-filter-select {
            flex: 1 1 0 !important;
            min-width: 0 !important;
        }

        .mobile-filter-button {
            flex: 0 0 auto !important;
            min-width: 88px !important;
        }

        .report-card-item {
            padding: 0.875rem !important;
        }

        .report-title,
        .report-description {
            display: -webkit-box !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
            white-space: normal !important;
            word-break: break-word !important;
            overflow-wrap: anywhere !important;
        }

        .report-title {
            -webkit-line-clamp: 1 !important;
        }

        .report-description {
            -webkit-line-clamp: 1 !important;
        }

        .mobile-action-group {
            display: flex !important;
            flex-direction: row !important;
            align-items: stretch !important;
            width: 100% !important;
            gap: 0.5rem !important;
        }

        .mobile-action-form {
            flex: 1 1 0 !important;
            min-width: 0 !important;
        }

        .mobile-action-btn {
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            width: 100% !important;
            min-width: 0 !important;
            flex: 1 1 0 !important;
        }
    }
</style>
@endsection
