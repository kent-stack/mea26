@extends('layouts.app')

@section('title', $report->title)

@section('content')
<section class="bg-slate-50 py-16">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-lg">
            <div class="bg-sky-100 px-6 py-8 sm:px-10">
                @php
                    $submittedDate = $report->created_at ?? $report->updated_at;
                @endphp
                <div class="mb-4 flex flex-wrap items-center gap-3">
                    <span class="inline-flex rounded-full bg-sky-600 px-3 py-1 text-sm font-semibold text-white">
                        {{ $report->report_type ?? 'Report' }}
                    </span>
                    <span class="text-sm font-medium text-slate-600">
                        {{ $submittedDate ? $submittedDate->format('d M Y') : '' }}
                    </span>
                </div>

                <h1 class="report-title text-3xl font-extrabold text-slate-900 sm:text-4xl">{{ $report->title }}</h1>
            </div>

            <div class="p-6 sm:p-10">
                <div class="prose max-w-none text-slate-700">
                    <p class="report-description whitespace-pre-line text-lg leading-8">{{ $report->description }}</p>
                </div>

                @if(!empty($report->photos))
                    <div class="mt-10">
                        <div class="gallery-scroll flex gap-4 overflow-x-auto pb-2">
                            @foreach($report->photos as $index => $photo)
                                @php
                                    $photoUrl = route('reports.media', [$report, $index]);
                                @endphp

                                @if($photoUrl)
                                    @php($isVideo = in_array(strtolower(pathinfo($photo, PATHINFO_EXTENSION)), ['mp4', 'mov', 'avi', 'webm', 'mkv']))
                                    @if($isVideo)
                                        <video src="{{ $photoUrl }}" controls class="h-52 min-w-[220px] flex-1 rounded-2xl border border-slate-200 bg-slate-50 object-cover shadow-sm" aria-label="Report video"></video>
                                    @else
                                        <button type="button" class="photo-trigger group relative min-w-[220px] flex-1 overflow-hidden rounded-2xl border border-slate-200 bg-slate-50 shadow-sm transition hover:scale-[1.01]" data-photo="{{ $photoUrl }}" aria-label="View report photo">
                                            <img src="{{ $photoUrl }}" alt="Report photo" class="h-52 w-full object-cover transition duration-200 group-hover:brightness-90">
                                        </button>
                                    @endif
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mt-8">
                    <a href="{{ route('lapor') }}" class="inline-flex rounded-xl border border-slate-300 bg-white px-5 py-2.5 font-semibold text-slate-700 transition hover:bg-slate-100">
                        ← Back to Reports
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .report-title,
    .report-description {
        overflow-wrap: anywhere;
        word-break: break-word;
        white-space: normal;
    }

    .gallery-scroll {
        overflow-x: hidden;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }

    .gallery-scroll::-webkit-scrollbar {
        height: 10px;
        background: #e2e8f0;
        border-radius: 9999px;
    }

    .gallery-scroll::-webkit-scrollbar-thumb {
        background: #94a3b8;
        border-radius: 9999px;
    }
</style>

<div id="photoModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 p-4">
    <div class="relative max-h-[90vh] max-w-5xl rounded-2xl bg-white p-3 shadow-2xl">
        <button type="button" id="closePhotoModal" class="absolute -right-3 -top-3 flex h-9 w-9 items-center justify-center rounded-full bg-slate-900 text-lg font-bold text-white shadow-lg">×</button>
        <img id="modalPhoto" src="" alt="Expanded report photo" class="max-h-[85vh] w-auto max-w-full rounded-xl object-contain">
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('photoModal');
        const modalImage = document.getElementById('modalPhoto');
        const closeButton = document.getElementById('closePhotoModal');
        const gallery = document.querySelector('.gallery-scroll');

        if (gallery) {
            const photoCount = gallery.querySelectorAll('.photo-trigger').length;
            gallery.style.overflowX = photoCount > 3 ? 'auto' : 'hidden';
            gallery.style.scrollbarWidth = photoCount > 3 ? 'thin' : 'none';
            gallery.style.msOverflowStyle = photoCount > 3 ? 'auto' : 'none';
        }

        document.querySelectorAll('.photo-trigger').forEach(function (button) {
            button.addEventListener('click', function () {
                const photoUrl = this.dataset.photo;
                modalImage.src = photoUrl;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            });
        });

        function closeModal() {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            modalImage.src = '';
        }

        closeButton.addEventListener('click', closeModal);
        modal.addEventListener('click', function (event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    });
</script>
@endsection
