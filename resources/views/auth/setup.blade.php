@extends('layouts.app')

@section('title', 'Initial Setup')

@section('content')
<section class="mx-auto max-w-2xl px-4 py-16 sm:px-6 lg:px-8">
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
        <p class="text-sm font-semibold uppercase tracking-[0.2em] text-sky-600">Initial Setup</p>
        <h1 class="mt-2 text-3xl font-extrabold text-slate-800">Create the first superadmin</h1>
        <p class="mt-2 text-slate-600">This page is available only before the first account is created.</p>

        @if($errors->any())
            <div class="mt-6 rounded-lg border border-red-200 bg-red-50 p-3 text-red-800">
                <ul class="list-inside list-disc">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('setup.store') }}" class="mt-6 space-y-5">
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
            <button type="submit" class="rounded-lg bg-sky-600 px-5 py-2 font-semibold text-white hover:bg-sky-700">Create superadmin</button>
        </form>
    </div>
</section>
@endsection