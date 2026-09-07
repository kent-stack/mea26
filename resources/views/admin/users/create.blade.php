@extends('layouts.app')

@section('title', 'Create User')

@section('content')
<section class="mx-auto max-w-2xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Superadmin Area</p>
        <h1 class="mt-2 text-3xl font-extrabold text-slate-800">Create User</h1>
        <p class="mt-2 text-slate-600">Add a participant or administrator without storing credentials in the codebase.</p>

        @if(session('success'))
            <div class="mt-6 rounded-lg border border-green-200 bg-green-50 p-3 text-green-800">{{ session('success') }}</div>
        @endif

        @if($errors->any())
            <div class="mt-6 rounded-lg border border-red-200 bg-red-50 p-3 text-red-800">
                <ul class="list-inside list-disc">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('admin.users.store') }}" class="mt-6 space-y-5">
            @csrf
            <div>
                <label for="name" class="mb-2 block font-semibold text-slate-700">Name</label>
                <input id="name" name="name" value="{{ old('name') }}" required class="w-full rounded-lg border border-slate-300 px-4 py-2" autocomplete="name">
            </div>
            <div>
                <label for="username" class="mb-2 block font-semibold text-slate-700">Username</label>
                <input id="username" name="username" value="{{ old('username') }}" required class="w-full rounded-lg border border-slate-300 px-4 py-2" autocomplete="username">
            </div>
            <div>
                <label for="password" class="mb-2 block font-semibold text-slate-700">Password</label>
                <input id="password" type="password" name="password" required minlength="8" class="w-full rounded-lg border border-slate-300 px-4 py-2" autocomplete="new-password">
            </div>
            <div>
                <label for="password_confirmation" class="mb-2 block font-semibold text-slate-700">Confirm password</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required minlength="8" class="w-full rounded-lg border border-slate-300 px-4 py-2" autocomplete="new-password">
            </div>
            <div>
                <label for="role" class="mb-2 block font-semibold text-slate-700">Role</label>
                <select id="role" name="role" required class="w-full rounded-lg border border-slate-300 px-4 py-2">
                    <option value="participant" @selected(old('role') === 'participant')>Participant</option>
                    <option value="admin" @selected(old('role') === 'admin')>Administrator</option>
                </select>
            </div>
            <button type="submit" class="rounded-lg bg-sky-600 px-5 py-2 font-semibold text-white hover:bg-sky-700">Create user</button>
        </form>
    </div>
</section>
@endsection