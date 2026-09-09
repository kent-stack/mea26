@extends('layouts.app')

@section('title', 'Edit Announcement')

@section('content')
<section class="upload-section" style="padding: 3rem 5% 5rem; background: #f8fafc; min-height: 100vh;">
    <div class="form-container" style="max-width: 800px; margin: 0 auto; background: #ffffff; padding: 4rem; border-radius: 32px; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0;">
        <div style="display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 2rem;">
            <h1 style="font-size: 2.25rem; font-weight: 800; color: #0f172a;">Edit Announcement</h1>
            <a href="{{ route('submitted.reports') }}" style="border: 1px solid #e2e8f0; border-radius: 9999px; padding: 0.6rem 1rem; color: #334155;">Back</a>
        </div>

        @if($errors->any())
            <div style="margin-bottom: 1.5rem; border: 1px solid #fecaca; border-radius: 1rem; background: #fef2f2; padding: 1rem; color: #991b1b;">
                @foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach
            </div>
        @endif

        <form action="{{ route('announcements.update', $report) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div style="display: grid; gap: 1.5rem;">
                <div>
                    <label for="announcement_title" style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: #334155;">Announcement Title</label>
                    <input id="announcement_title" name="announcement_title" type="text" required value="{{ old('announcement_title', $announcement->title) }}" style="width: 100%; border: 1px solid #e2e8f0; border-radius: 0.9rem; background: #f8fafc; padding: 0.9rem 1rem;">
                </div>

                <div>
                    <label for="announcement_content" style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: #334155;">Announcement Content</label>
                    <textarea id="announcement_content" name="announcement_content" rows="6" style="width: 100%; border: 1px solid #e2e8f0; border-radius: 0.9rem; background: #f8fafc; padding: 0.9rem 1rem;">{{ old('announcement_content', $announcement->content) }}</textarea>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: #334155;">Announcement Image</label>
                    @if($announcement->image)
                        <div id="current-announcement-image" style="display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.9rem; background: #f8fafc; padding: 0.75rem;">
                            <img src="{{ Storage::disk('public')->url($announcement->image) }}" alt="Current announcement" style="height: 4rem; width: 6rem; border-radius: 0.5rem; object-fit: cover;">
                            <button type="button" id="remove-announcement-image" style="height: 2rem; width: 2rem; border-radius: 9999px; background: #fee2e2; font-weight: 800; color: #b91c1c;">&times;</button>
                        </div>
                        <input type="hidden" name="remove_announcement_image" id="remove-announcement-image-input" value="0">
                    @endif
                    <label for="announcement_image" style="display: inline-flex; cursor: pointer; border-radius: 0.75rem; background: #2563eb; padding: 0.7rem 1rem; font-weight: 700; color: white;">Add image</label>
                    <input id="announcement_image" name="announcement_image" type="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.webp,.avif,image/*" style="display: none;">
                    <p id="announcement-image-name" style="margin-top: 0.5rem; font-size: 0.8rem; color: #64748b;">Existing image stays until removed.</p>
                </div>

                <div>
                    <label style="display: block; margin-bottom: 0.5rem; font-weight: 700; color: #334155;">Announcement File</label>
                    @if($announcement->file)
                        <div id="current-announcement-file" style="display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 0.75rem; border: 1px solid #e2e8f0; border-radius: 0.9rem; background: #f8fafc; padding: 0.9rem 1rem;">
                            <span style="overflow: hidden; text-overflow: ellipsis; white-space: nowrap; font-size: 0.9rem; color: #334155;">{{ basename($announcement->file) }}</span>
                            <button type="button" id="remove-announcement-file" style="height: 2rem; width: 2rem; flex-shrink: 0; border-radius: 9999px; background: #fee2e2; font-weight: 800; color: #b91c1c;">&times;</button>
                        </div>
                        <input type="hidden" name="remove_announcement_file" id="remove-announcement-file-input" value="0">
                    @endif
                    <label for="announcement_file" style="display: inline-flex; cursor: pointer; border-radius: 0.75rem; background: #2563eb; padding: 0.7rem 1rem; font-weight: 700; color: white;">Add file</label>
                    <input id="announcement_file" name="announcement_file" type="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.txt,.zip,.mp4,.mov,.avi,.webm,.mkv,video/*" style="display: none;">
                    <p id="announcement-file-name" style="margin-top: 0.5rem; font-size: 0.8rem; color: #64748b;">Max 2GB. Existing file stays until removed.</p>
                </div>

                <div style="display: flex; justify-content: flex-end; gap: 0.75rem;">
                    <a href="{{ route('submitted.reports') }}" style="border: 1px solid #e2e8f0; border-radius: 0.75rem; padding: 0.75rem 1rem; font-weight: 700; color: #334155;">Cancel</a>
                    <button type="submit" style="border-radius: 0.75rem; background: #2563eb; padding: 0.75rem 1.25rem; font-weight: 700; color: white;">Save Changes</button>
                </div>
            </div>
        </form>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bindFileName = (inputId, outputId) => {
            document.getElementById(inputId)?.addEventListener('change', function () {
                if (this.files.length) document.getElementById(outputId).textContent = this.files[0].name;
            });
        };
        bindFileName('announcement_image', 'announcement-image-name');
        bindFileName('announcement_file', 'announcement-file-name');

        [['remove-announcement-image', 'current-announcement-image', 'remove-announcement-image-input'], ['remove-announcement-file', 'current-announcement-file', 'remove-announcement-file-input']].forEach(function (entry) {
            document.getElementById(entry[0])?.addEventListener('click', function () {
                document.getElementById(entry[1])?.remove();
                document.getElementById(entry[2]).value = '1';
            });
        });
    });
</script>
@endsection
