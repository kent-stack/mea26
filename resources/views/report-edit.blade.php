@extends('layouts.app')

@section('title', 'Edit Report')

@section('content')
<section class="py-20 bg-slate-50">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        <div class="rounded-2xl bg-white p-8 shadow-lg border border-slate-200">
            <h1 class="mb-6 text-3xl font-extrabold text-slate-800">Edit Report</h1>

            <form id="report-edit-form" action="{{ route('reports.update', $report) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div id="removed-photos-container"></div>

                <div class="mb-5">
                    <label for="report_type" class="mb-2 block text-sm font-semibold text-slate-700">Report Type</label>
                    <select id="report_type" name="report_type" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 focus:border-sky-500 focus:outline-none" required>
                        <option value="Daily Report" {{ old('report_type', $report->report_type) == 'Daily Report' ? 'selected' : '' }}>Daily Report</option>
                        <option value="Weekly Report" {{ old('report_type', $report->report_type) == 'Weekly Report' ? 'selected' : '' }}>Weekly Report</option>
                    </select>
                </div>

                <div class="mb-5">
                    <label for="nama_project" class="mb-2 block text-sm font-semibold text-slate-700">Project Title</label>
                    <input id="nama_project" name="nama_project" type="text" value="{{ old('nama_project', $report->title) }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 focus:border-sky-500 focus:outline-none" required>
                </div>

                <div class="mb-5">
                    <label for="penjelasan_project" class="mb-2 block text-sm font-semibold text-slate-700">Project Description</label>
                    <textarea id="penjelasan_project" name="penjelasan_project" rows="6" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 focus:border-sky-500 focus:outline-none" required>{{ old('penjelasan_project', $report->description) }}</textarea>
                </div>

                @if(!empty($report->photos))
                    <div class="mb-5">
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Current Photos</label>
                        <div class="grid grid-cols-2 gap-3 md:grid-cols-4">
                            @foreach($report->photos as $photo)
                                @php
                                    $photoUrl = Storage::disk('public')->exists($photo) ? Storage::disk('public')->url($photo) : null;
                                @endphp

                                @if($photoUrl)
                                    <div class="photo-item group relative overflow-hidden rounded-xl border border-slate-200 bg-slate-50 shadow-sm">
                                        <button type="button" class="remove-photo-btn absolute right-2 top-2 z-10 flex h-7 w-7 items-center justify-center rounded-full bg-slate-900/80 text-xs font-bold text-white shadow-md transition hover:bg-red-600" data-photo="{{ $photo }}" aria-label="Delete photo">
                                            ×
                                        </button>
                                        <img src="{{ $photoUrl }}" alt="Report photo" class="h-28 w-full object-cover">
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    </div>
                @endif

                <div class="mb-5">
                    <label class="mb-2 block text-sm font-semibold text-slate-700">Add More Photos</label>
                    <input type="file" name="photos[]" multiple accept="image/*" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-3 focus:border-sky-500 focus:outline-none">
                    <p class="mt-2 text-xs text-slate-500">Upload additional photos. The photos already submitted will remain and the new ones will be added.</p>
                </div>

                <div class="flex justify-end gap-3">
                    <a href="{{ route('submitted.reports') }}" class="rounded-xl border border-slate-300 px-4 py-2.5 font-semibold text-slate-700 hover:bg-slate-100">Cancel</a>
                    <button type="submit" class="rounded-xl bg-sky-600 px-4 py-2.5 font-semibold text-white hover:bg-sky-700">Update Report</button>
                </div>
            </form>
        </div>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const form = document.getElementById('report-edit-form');
        const removedContainer = document.getElementById('removed-photos-container');

        if (!form || !removedContainer) {
            return;
        }

        document.querySelectorAll('.remove-photo-btn').forEach(function (button) {
            button.addEventListener('click', function () {
                const photo = this.dataset.photo;
                const existing = Array.from(removedContainer.querySelectorAll('input[name="removed_photos[]"]'))
                    .find(function (input) {
                        return input.value === photo;
                    });

                const photoCard = this.closest('.photo-item');

                if (existing) {
                    existing.remove();
                    if (photoCard) {
                        photoCard.classList.remove('ring-2', 'ring-red-400', 'opacity-50');
                    }
                    return;
                }

                const hiddenInput = document.createElement('input');
                hiddenInput.type = 'hidden';
                hiddenInput.name = 'removed_photos[]';
                hiddenInput.value = photo;
                removedContainer.appendChild(hiddenInput);

                if (photoCard) {
                    photoCard.classList.add('ring-2', 'ring-red-400', 'opacity-50');
                }
            });
        });
    });
</script>
@endsection
