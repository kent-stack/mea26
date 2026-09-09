@extends('layouts.app')

@section('title', 'Edit Participant')

@section('content')
<section class="bg-slate-50 py-16">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('admin.participants.show', $participant) }}" class="font-semibold text-sky-700 hover:text-sky-900">&larr; Back to participant profile</a>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <div class="mb-8">
                <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Participant Management</p>
                <h1 class="mt-2 text-3xl font-extrabold text-slate-800">Edit Participant</h1>
                <p class="mt-2 text-slate-600">Update participant information and profile photo.</p>
            </div>

            @if($errors->any())
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    <ul class="list-disc space-y-1 pl-5">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.participants.update', $participant) }}" enctype="multipart/form-data" class="space-y-6">
                @csrf
                @method('PUT')

                <div class="grid gap-5 sm:grid-cols-2">
                    <div>
                        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Username / Name</label>
                        <input id="name" name="name" type="text" value="{{ old('name', $participant->name) }}" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                    </div>
                    <div>
                        <label for="full_name" class="mb-2 block text-sm font-semibold text-slate-700">Full name</label>
                        <input id="full_name" name="full_name" type="text" value="{{ old('full_name', $participant->full_name) }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                    </div>
                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                        <input id="email" name="email" type="email" value="{{ old('email', $participant->email) }}" required class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                    </div>
                    <div>
                        <label for="school_origin" class="mb-2 block text-sm font-semibold text-slate-700">School origin</label>
                        <input id="school_origin" name="school_origin" type="text" value="{{ old('school_origin', $participant->school_origin) }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                    </div>
                    <div>
                        <label for="gender" class="mb-2 block text-sm font-semibold text-slate-700">Gender</label>
                        <select id="gender" name="gender" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                            <option value="">-- Select --</option>
                            <option value="Laki-laki" @selected(old('gender', $participant->gender) === 'Laki-laki')>Male</option>
                            <option value="Perempuan" @selected(old('gender', $participant->gender) === 'Perempuan')>Female</option>
                        </select>
                    </div>
                    <div>
                        <label for="date_of_birth" class="mb-2 block text-sm font-semibold text-slate-700">Date of birth</label>
                        <input id="date_of_birth" name="date_of_birth" type="date" value="{{ old('date_of_birth', optional($participant->date_of_birth)->format('Y-m-d')) }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                    </div>
                    <div>
                        <label for="place_of_birth" class="mb-2 block text-sm font-semibold text-slate-700">Place of birth</label>
                        <input id="place_of_birth" name="place_of_birth" type="text" value="{{ old('place_of_birth', $participant->place_of_birth) }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                    </div>
                    <div>
                        <label for="whatsapp_number" class="mb-2 block text-sm font-semibold text-slate-700">WhatsApp number</label>
                        <input id="whatsapp_number" name="whatsapp_number" type="text" value="{{ old('whatsapp_number', $participant->whatsapp_number) }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                    </div>
                    <div>
                        <label for="telegram_number" class="mb-2 block text-sm font-semibold text-slate-700">Telegram number</label>
                        <input id="telegram_number" name="telegram_number" type="text" value="{{ old('telegram_number', $participant->telegram_number) }}" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">
                    </div>
                </div>

                <div>
                    <label for="address" class="mb-2 block text-sm font-semibold text-slate-700">Complete address</label>
                    <textarea id="address" name="address" rows="4" class="w-full rounded-xl border border-slate-300 bg-slate-50 px-4 py-3 text-slate-800 focus:border-sky-500 focus:outline-none focus:ring-2 focus:ring-sky-200">{{ old('address', $participant->address) }}</textarea>
                </div>

                <div>
                    <label for="photo_3x4" class="mb-2 block text-sm font-semibold text-slate-700">3x4 photo</label>
                    <input id="photo_3x4" name="photo_3x4" type="file" accept=".jpg,.jpeg,.png,.gif,.bmp,.webp,.avif,image/*" class="block w-full rounded-xl border border-slate-300 bg-slate-50 px-3 py-2.5 text-sm text-slate-700">
                    <p class="mt-2 text-xs text-slate-500">Leave empty to keep the current photo.</p>
                </div>

                <div class="flex flex-wrap justify-end gap-3">
                    <a href="{{ route('admin.participants.show', $participant) }}" class="rounded-xl border border-slate-300 px-5 py-3 font-semibold text-slate-700 hover:bg-slate-100">Cancel</a>
                    <button type="submit" class="rounded-xl bg-sky-600 px-5 py-3 font-semibold text-white hover:bg-sky-700">Save Changes</button>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection
