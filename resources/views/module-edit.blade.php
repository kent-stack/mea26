@extends('layouts.app')

@section('title', 'Edit Module')

@section('content')
<section class="py-20 bg-slate-50">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-8 flex items-center justify-between gap-4">
            <h1 class="text-3xl font-extrabold text-slate-800">Edit Module</h1>
            <a href="{{ route('participants') }}" class="rounded-full border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700 hover:bg-slate-100">Back</a>
        </div>

        <div class="rounded-2xl bg-white shadow-sm border border-slate-200 p-6">
            <form action="{{ route('modules.update', $module) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="space-y-5">
                    <div>
                        <label for="module_title" class="mb-2 block text-sm font-semibold text-slate-700">Title</label>
                        <input id="module_title" name="module_title" type="text" value="{{ old('module_title', $module->title) }}" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3" required>
                    </div>

                    <div>
                        <label for="module_description" class="mb-2 block text-sm font-semibold text-slate-700">Description</label>
                        <textarea id="module_description" name="module_description" rows="5" class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">{{ old('module_description', $module->description) }}</textarea>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Module Category</label>
                        <div class="grid grid-cols-2 gap-3">
                            <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                                <input type="radio" name="module_category" value="tugas" {{ old('module_category', $module->module_category ?? 'materi') === 'tugas' ? 'checked' : '' }}>
                                <span class="font-semibold">Tugas</span>
                            </label>
                            <label class="flex cursor-pointer items-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                                <input type="radio" name="module_category" value="materi" {{ old('module_category', $module->module_category ?? 'materi') === 'materi' ? 'checked' : '' }}>
                                <span class="font-semibold">Materi</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-semibold text-slate-700">Module File</label>
                        @if($module->file_path)
                            <div id="current-module-file" class="mb-3 flex items-center justify-between gap-3 rounded-xl border border-slate-200 bg-slate-50 px-4 py-3">
                                <span class="truncate text-sm text-slate-700">{{ $module->file_name ?? 'Uploaded file' }}</span>
                                <button type="button" id="remove-module-file" class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-red-100 font-bold text-red-700" aria-label="Remove current file">&times;</button>
                            </div>
                            <input type="hidden" name="remove_module_file" id="remove-module-file-input" value="0">
                        @endif
                        <label for="module_file" class="inline-flex cursor-pointer rounded-xl bg-sky-600 px-4 py-3 text-sm font-semibold text-white hover:bg-sky-700">Add file</label>
                        <input id="module_file" name="module_file" type="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip,.mp4,.mov,.avi,.webm,.mkv,video/*" class="hidden">
                        <p id="module-file-name" class="mt-2 text-xs text-slate-500">Max 2GB. Existing file stays until removed.</p>
                    </div>

                    <div class="flex justify-end gap-3">
                        <a href="{{ route('participants') }}" class="rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-semibold text-slate-700">Cancel</a>
                        <button type="submit" class="rounded-lg bg-sky-600 px-4 py-2 text-sm font-semibold text-white hover:bg-sky-700">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const fileInput = document.getElementById('module_file');
        const fileName = document.getElementById('module-file-name');
        const removeButton = document.getElementById('remove-module-file');
        const removeInput = document.getElementById('remove-module-file-input');

        fileInput?.addEventListener('change', function () {
            if (this.files.length) fileName.textContent = this.files[0].name;
        });

        removeButton?.addEventListener('click', function () {
            document.getElementById('current-module-file')?.remove();
            if (removeInput) removeInput.value = '1';
        });
    });
</script>
@endsection
