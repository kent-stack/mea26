@extends('layouts.app')

@section('title', 'Latest Update')

@section('content')
<section x-data="{ open:false, filterType: 'all' }" class="reports bg-white" aria-label="Latest Update">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-20 py-16">
        @if(!isset($showAllMode) || !$showAllMode)
            <h2 class="text-3xl font-extrabold text-gray-900 mb-6">Latest Update</h2>
        @else
            <div class="mb-8 flex items-center justify-between gap-4">
                <h2 class="text-3xl font-extrabold text-gray-900">All Reports</h2>
            </div>
            
            <!-- Filter Buttons -->
            <div class="flex justify-center mb-8">
                <div class="flex gap-3 bg-gray-100 rounded-lg p-3">
                    <button @click="filterType = 'all'" :class="filterType === 'all' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-200'" class="px-5 py-2 rounded-md text-sm font-semibold transition-colors duration-200">
                        All
                    </button>
                    <button @click="filterType = 'Daily Report'" :class="filterType === 'Daily Report' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-200'" class="px-5 py-2 rounded-md text-sm font-semibold transition-colors duration-200">
                        Daily
                    </button>
                    <button @click="filterType = 'Weekly Report'" :class="filterType === 'Weekly Report' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 hover:bg-gray-200'" class="px-5 py-2 rounded-md text-sm font-semibold transition-colors duration-200">
                        Weekly
                    </button>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 gap-8">
            @if(!isset($showAllMode) || !$showAllMode)
                @if(isset($report) && $report)
                    @php
                        $thumbPath = null;
                        if ($report->photos && is_array($report->photos) && count($report->photos)) {
                            $thumbPath = \Illuminate\Support\Facades\Storage::disk('public')->exists($report->photos[0])
                                ? route('reports.media', [$report, 0])
                                : null;
                        }
                        $isVideo = $report->photos && is_array($report->photos) && count($report->photos)
                            && in_array(strtolower(pathinfo($report->photos[0], PATHINFO_EXTENSION)), ['mp4', 'mov', 'avi', 'webm', 'mkv']);

                        $submittedDate = $report->created_at ?? $report->updated_at;
                    @endphp
                    <article class="report-card bg-white rounded-2xl shadow-lg overflow-hidden flex flex-col lg:flex-row w-full">
                        <div class="report-image lg:w-2/5 w-full">
                            @if($isVideo && $thumbPath)
                                <video src="{{ $thumbPath }}" muted preload="metadata" class="object-cover w-full h-48 lg:h-64" aria-label="Report video"></video>
                            @else
                                <img src="{{ $thumbPath ?? asset('images/report-thumb.jpg') }}" alt="Report image" class="object-cover w-full h-48 lg:h-64">
                            @endif
                        </div>
                        <div class="p-6 lg:p-8 lg:w-3/5 flex flex-col justify-between">
                            <div>
                                <div class="flex items-center gap-4">
                                    <span class="inline-block bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-semibold">{{ $report->report_type ?? 'REPORT' }}</span>
                                    <span class="text-sm text-gray-500">{{ $submittedDate ? $submittedDate->format('d M Y') : 'Unknown date' }}</span>
                                </div>
                                <h3 class="report-title mt-4 text-2xl font-extrabold text-gray-900 lg:text-3xl">{{ $report->title }}</h3>
                                <p class="report-description mt-3 text-gray-600">{{ $report->description }}</p>
                            </div>
                            <div class="mt-6">
                                <a href="{{ route('report.detail', $report) }}" class="text-red-600 font-semibold">More →</a>
                            </div>
                        </div>
                    </article>
                @else
                    <p class="text-gray-500">No reports yet.</p>
                @endif
            @endif
        </div>

        <!-- Previous Reports Section / All Reports Section -->
        @if($previousReports && count($previousReports) > 0)
        <div class="mt-16">
            @if(!isset($showAllMode) || !$showAllMode)
                <h3 class="text-2xl font-extrabold text-gray-900 mb-8">Previous Reports</h3>
            @endif
            <div class="{{ (isset($showAllMode) && $showAllMode) ? 'previous-reports-grid previous-reports-grid--all' : 'previous-reports-grid' }} grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($previousReports as $prevReport)
                    @php
                        $thumbPath = null;
                        if ($prevReport->photos && is_array($prevReport->photos) && count($prevReport->photos)) {
                            $thumbPath = \Illuminate\Support\Facades\Storage::disk('public')->exists($prevReport->photos[0])
                                ? route('reports.media', [$prevReport, 0])
                                : null;
                        }
                        $isVideo = $prevReport->photos && is_array($prevReport->photos) && count($prevReport->photos)
                            && in_array(strtolower(pathinfo($prevReport->photos[0], PATHINFO_EXTENSION)), ['mp4', 'mov', 'avi', 'webm', 'mkv']);
                        $submittedDate = $prevReport->created_at ?? $prevReport->updated_at;
                        $isDaily = $prevReport->report_type === 'Daily Report';
                        $isWeekly = $prevReport->report_type === 'Weekly Report';
                    @endphp
                    @if(isset($showAllMode) && $showAllMode)
                        <article x-show="filterType === 'all' || filterType === '{{ $prevReport->report_type }}'" class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow flex flex-col" x-transition>
                            <div class="h-40 overflow-hidden bg-gray-200">
                                @if($isVideo && $thumbPath)
                                    <video src="{{ $thumbPath }}" muted preload="metadata" class="object-cover w-full h-full" aria-label="Report video"></video>
                                @else
                                    <img src="{{ $thumbPath ?? asset('images/report-thumb.jpg') }}" alt="Report image" class="object-cover w-full h-full">
                                @endif
                            </div>
                            <div class="p-4 flex flex-col flex-grow">
                                <div class="mb-3">
                                    <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">{{ $prevReport->submitter->name ?? 'Unknown' }}</span>
                                </div>
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="inline-block bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-semibold">{{ $prevReport->report_type ?? 'REPORT' }}</span>
                                    <span class="text-xs text-gray-500">{{ $submittedDate ? $submittedDate->format('d M Y') : 'Unknown date' }}</span>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 truncate overflow-hidden text-ellipsis whitespace-nowrap">{{ $prevReport->title }}</h4>
                                <div class="mt-auto">
                                    <a href="{{ route('report.detail', $prevReport) }}" class="text-red-600 font-semibold text-sm">More →</a>
                                </div>
                            </div>
                        </article>
                    @else
                        <article class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-lg transition-shadow flex flex-col">
                            <div class="h-40 overflow-hidden bg-gray-200">
                                @if($isVideo && $thumbPath)
                                    <video src="{{ $thumbPath }}" muted preload="metadata" class="object-cover w-full h-full" aria-label="Report video"></video>
                                @else
                                    <img src="{{ $thumbPath ?? asset('images/report-thumb.jpg') }}" alt="Report image" class="object-cover w-full h-full">
                                @endif
                            </div>
                            <div class="p-4 flex flex-col flex-grow">
                                <div class="mb-3">
                                    <span class="inline-block bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">{{ $prevReport->submitter->name ?? 'Unknown' }}</span>
                                </div>
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="inline-block bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs font-semibold">{{ $prevReport->report_type ?? 'REPORT' }}</span>
                                    <span class="text-xs text-gray-500">{{ $submittedDate ? $submittedDate->format('d M Y') : 'Unknown date' }}</span>
                                </div>
                                <h4 class="text-lg font-semibold text-gray-900 mb-4 truncate overflow-hidden text-ellipsis whitespace-nowrap">{{ $prevReport->title }}</h4>
                                <div class="mt-auto">
                                    <a href="{{ route('report.detail', $prevReport) }}" class="text-red-600 font-semibold text-sm">More →</a>
                                </div>
                            </div>
                        </article>
                    @endif
                @endforeach
            </div>

            @if($hasMoreReports ?? false)
            <div class="mt-8 text-center">
                <a href="{{ route('lapor.all') }}" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-8 rounded-lg transition-colors duration-200">
                    All Reports →
                </a>
            </div>
            @endif

            @if(isset($showAllMode) && $showAllMode && $previousReports->hasPages())
                <div class="mt-8">
                    <nav aria-label="Pagination navigation">
                        <ul class="pagination">
                            @if ($previousReports->onFirstPage())
                                <li class="disabled"><span>«</span></li>
                            @else
                                <li><a href="{{ $previousReports->previousPageUrl() }}" rel="prev">«</a></li>
                            @endif

                            @php
                                $currentPage = $previousReports->currentPage();
                                $lastPage = $previousReports->lastPage();
                                $start = max(1, $currentPage - 2);
                                $end = min($lastPage, $currentPage + 2);
                            @endphp

                            @if ($start > 1)
                                <li><a href="{{ $previousReports->url(1) }}">1</a></li>
                                @if ($start > 2)
                                    <li><span>…</span></li>
                                @endif
                            @endif

                            @for ($page = $start; $page <= $end; $page++)
                                @if ($page == $currentPage)
                                    <li class="active"><span>{{ $page }}</span></li>
                                @else
                                    <li><a href="{{ $previousReports->url($page) }}">{{ $page }}</a></li>
                                @endif
                            @endfor

                            @if ($end < $lastPage)
                                @if ($end < $lastPage - 1)
                                    <li><span>…</span></li>
                                @endif
                                <li><a href="{{ $previousReports->url($lastPage) }}">{{ $lastPage }}</a></li>
                            @endif

                            @if ($previousReports->hasMorePages())
                                <li><a href="{{ $previousReports->nextPageUrl() }}" rel="next">»</a></li>
                            @else
                                <li class="disabled"><span>»</span></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            @endif
        </div>
        @endif
    </div>
        <div id="reportModal" x-show="open" x-cloak x-transition class="js-modal fixed inset-0 z-50 flex items-start justify-center p-6">
            <div data-js-overlay class="js-modal-overlay fixed inset-0 bg-black/40 backdrop-blur-sm"></div>
            <div data-js-dialog @click.stop class="relative bg-white w-full max-w-4xl rounded-lg overflow-hidden shadow-2xl">
                <div class="bg-green-600 text-white p-8">
                    <div class="flex items-start justify-between">
                        <h3 class="text-3xl font-extrabold">Weekly Report 4 (Project 2 : Social Media Marketing Kit for Sundan Plaosan Village Tourism Mapping)</h3>
                        <button data-js-close @click="open=false" class="js-modal-close text-white opacity-90 hover:opacity-100 text-2xl leading-none">✕</button>
                    </div>
                </div>
                <div class="p-8 max-h-[70vh] overflow-y-auto">
                    <p class="text-gray-700 mb-6">Malang, June 8–15, 2026</p>
                    <p class="mb-4">Monday, June 8, 2026<br>
                    Our team continued the finalization of our project. During this discussion session, we focused on determining and printing various materials and outputs that would later be presented during the final presentation at the end of the program period.</p>
                    <p class="mb-4">Tuesday, June 9, 2026<br>
                    Today was a special day because Dusun Sundan was holding its annual Bersih Dusun event...</p>
                    <p class="text-sm text-gray-500">(More content can be loaded dynamically from the DB.)</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .report-title {
        display: -webkit-box;
        -webkit-line-clamp: 1;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        word-break: break-word;
    }

    .report-description {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
        text-overflow: ellipsis;
        word-break: break-word;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.5rem;
        list-style: none;
        padding: 0;
        margin: 1.5rem 0 0;
    }

    .pagination li {
        display: inline-flex;
        margin: 0;
    }

    .pagination a,
    .pagination span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 2.6rem;
        height: 2.6rem;
        padding: 0 0.8rem;
        border: 1px solid #d1d5db;
        border-radius: 0.5rem;
        background: #ffffff;
        color: #374151;
        font-size: 0.82rem;
        font-weight: 700;
        text-decoration: none;
        line-height: 1;
        box-shadow: 0 1px 0 rgba(17, 24, 39, 0.02);
    }

    .pagination a:hover {
        background: #f3f4f6;
        color: #111827;
    }

    .pagination [aria-current="page"] > span,
    .pagination .active > span,
    .pagination .active > a,
    .pagination li.active a,
    .pagination li.active span {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
    }

    .pagination .disabled > span,
    .pagination .disabled > a,
    .pagination li.disabled a,
    .pagination li.disabled span {
        opacity: 0.45;
        pointer-events: none;
        cursor: default;
    }

    .pagination .page-item .page-link,
    .pagination li > a,
    .pagination li > span {
        min-width: 2.6rem;
        height: 2.6rem;
    }

    @media (max-width: 767px) {
        .reports .mb-8, .reports .mb-6 {
            margin-bottom: 1rem !important;
        }

        .reports h2 {
            padding-top: 1.35rem !important;
            margin-top: 0.5rem !important;
        }

        .previous-reports-grid {
            grid-template-columns: 1fr !important;
            gap: 1rem !important;
        }

        .previous-reports-grid article {
            border-radius: 0.875rem !important;
            overflow: hidden;
        }

        .previous-reports-grid:not(.previous-reports-grid--all) article:nth-child(n + 2) {
            display: none !important;
        }

        .previous-reports-grid article .h-40 {
            height: 150px !important;
        }

        .previous-reports-grid article .p-4 {
            padding: 0.75rem !important;
        }

        .previous-reports-grid article h4 {
            font-size: 1rem !important;
            line-height: 1.4 !important;
            margin-bottom: 0.75rem !important;
            white-space: normal !important;
            display: -webkit-box !important;
            -webkit-line-clamp: 2 !important;
            -webkit-box-orient: vertical !important;
            overflow: hidden !important;
            text-overflow: ellipsis !important;
        }

        .previous-reports-grid article .mt-auto {
            margin-top: 0.5rem !important;
        }

        .previous-reports-grid article .text-xs {
            font-size: 0.68rem !important;
        }

        .pagination {
            gap: 0.35rem;
            margin-top: 1.25rem;
        }

        .pagination a,
        .pagination span {
            min-width: 2.2rem;
            height: 2.2rem;
            padding: 0 0.6rem;
            font-size: 0.75rem;
        }
    }

</style>

@endsection