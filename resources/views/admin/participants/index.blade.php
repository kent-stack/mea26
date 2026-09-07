@extends('layouts.app')

@section('title', 'Participant Management')

@section('content')
<section class="bg-slate-50 py-16 desktop-participant-page">
    <div class="mx-auto max-w-6xl px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Admin Area</p>
                <h1 class="mt-2 text-3xl font-extrabold text-slate-800">Participant Management</h1>
                <p class="mt-2 text-slate-600">View participant profiles and contact information.</p>
            </div>
            <form method="GET" action="{{ route('admin.participants.index') }}" class="flex gap-2">
                <input type="search" name="q" value="{{ $search }}" placeholder="Search participants" class="w-full rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm sm:w-64">
                <button type="submit" class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">Search</button>
            </form>
        </div>

        @if($participants->isEmpty())
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center text-slate-600">
                No participants found.
            </div>
        @else
            @php
                $desktopPageSize = 6;
                $desktopTotalPages = ceil($participants->count() / $desktopPageSize);
            @endphp

            <div id="participant-grid" class="grid gap-5 sm:grid-cols-2 lg:grid-cols-3">
                @foreach($participants as $participant)
                    <article class="participant-card overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                        <div class="flex gap-4 p-5">
                            <div class="h-20 w-16 shrink-0 overflow-hidden rounded-xl bg-slate-100">
                                @if($participant->photo_3x4)
                                    <img src="{{ asset('storage/' . $participant->photo_3x4) }}" alt="{{ $participant->full_name ?: $participant->name }}" class="h-full w-full object-cover">
                                @else
                                    <div class="flex h-full items-center justify-center text-2xl font-bold text-sky-700">{{ strtoupper(substr($participant->full_name ?: $participant->name ?: 'P', 0, 1)) }}</div>
                                @endif
                            </div>
                            <div class="min-w-0">
                                <h2 class="truncate text-lg font-bold text-slate-800">{{ $participant->full_name ?: $participant->name }}</h2>
                                <p class="truncate text-sm text-slate-500">{{ $participant->email }}</p>
                                <p class="mt-1 truncate text-sm text-slate-600">{{ $participant->school_origin ?: 'School not provided' }}</p>
                            </div>
                        </div>
                        <div class="border-t border-slate-100 px-5 py-3">
                            <a href="{{ route('admin.participants.show', $participant) }}" class="text-sm font-semibold text-sky-700 hover:text-sky-900">View Profile</a>
                        </div>
                    </article>
                @endforeach
            </div>

            @if($participants->count() > 6)
                <nav id="participant-pagination" class="mt-8 flex items-center justify-center gap-4" aria-label="Participant pagination">
                    <button id="participant-previous" type="button" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-40">Previous</button>
                    <span id="participant-page-status" class="text-sm font-medium text-slate-600" aria-live="polite"></span>
                    <button id="participant-next" type="button" class="rounded-lg border border-slate-300 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100 disabled:cursor-not-allowed disabled:opacity-40">Next</button>
                </nav>
            @endif
        @endif
    </div>
</section>

@if($participants->count() > 6)
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cards = Array.from(document.querySelectorAll('.participant-card'));
        const previousButton = document.getElementById('participant-previous');
        const nextButton = document.getElementById('participant-next');
        const pageStatus = document.getElementById('participant-page-status');
        let currentPage = 1;

        function pageSize() {
            return window.matchMedia('(max-width: 639px)').matches ? 2 : 6;
        }

        function renderPage() {
            const size = pageSize();
            const pageCount = Math.ceil(cards.length / size);
            currentPage = Math.min(currentPage, pageCount);
            const firstCard = (currentPage - 1) * size;

            cards.forEach(function (card, index) {
                if (window.matchMedia('(max-width: 639px)').matches) {
                    card.classList.remove('hidden');
                    return;
                }

                card.classList.toggle('hidden', index < firstCard || index >= firstCard + size);
            });

            previousButton.disabled = currentPage === 1;
            nextButton.disabled = currentPage === pageCount;
            pageStatus.textContent = 'Page ' + currentPage + ' of ' + pageCount;
        }

        previousButton.addEventListener('click', function () {
            currentPage -= 1;
            renderPage();
        });

        nextButton.addEventListener('click', function () {
            currentPage += 1;
            renderPage();
        });

        window.addEventListener('resize', renderPage);
        renderPage();
    });
</script>
@endif

<style>
    .pt-2 {
        padding-top: 1.5rem !important;
    }

    @media (min-width: 641px) {
        .desktop-participant-page {
            min-height: calc(100vh - 190px) !important;
            padding-top: 4.5rem !important;
        }

        .desktop-participant-page > div {
            flex: 1 !important;
        }
    }

    @media (max-width: 640px) {
        section {
            padding-top: 5.75rem !important;
        }
    }
</style>

@endsection