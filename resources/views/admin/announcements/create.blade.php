@extends('layouts.app')

@section('title', 'Create Announcement')

@section('content')
<section class="max-w-3xl mx-auto p-8">
    <h1 class="text-2xl font-bold mb-4">Create Announcement</h1>

    <form action="{{ url('/admin/announcements') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block font-semibold mb-2">Title</label>
            <input type="text" name="title" class="w-full p-3 border rounded" required>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-2">Content</label>
            <textarea name="content" rows="6" class="w-full p-3 border rounded" required></textarea>
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-2">Image (optional)</label>
            <input type="file" name="image" accept="image/*">
        </div>
        <div class="mb-4">
            <label class="block font-semibold mb-2">File (optional)</label>
            <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip">
        </div>
        <button class="px-4 py-2 bg-green-600 text-white rounded">Publish</button>
    </form>
</section>
@endsection
