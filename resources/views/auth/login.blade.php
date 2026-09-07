@extends('layouts.app')

@section('title', 'Login')

@section('body-class', 'auth-page')

@section('content')
<div class="auth-page-shell relative min-h-screen overflow-hidden bg-[#f8fbff]">
    <div id="tsparticles" aria-hidden="true"></div>

    <div class="relative z-10 flex min-h-screen items-center justify-center px-4 py-8 sm:px-6">
        <div class="w-full max-w-[430px] rounded-[28px] border border-slate-200/80 bg-white/70 p-7 shadow-[0_24px_60px_rgba(15,23,42,0.08)] backdrop-blur-sm sm:p-8">
            <div class="mb-6 flex justify-center">
                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-[#dff9f5] text-[#0fa8a8] shadow-[inset_0_0_0_1px_rgba(15,168,168,0.12)]">
                    <svg class="h-8 w-8" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                        <path d="M20 21a8 8 0 0 0-16 0" />
                        <circle cx="12" cy="8" r="4" />
                    </svg>
                </div>
            </div>

            <div class="text-center">
                <h1 class="text-[2.1rem] font-black tracking-[-0.04em] text-slate-900">Login</h1>
            </div>

            <form class="mt-8 space-y-5" action="{{ route('login.perform') }}" method="POST">
                @csrf

                <div>
                    <label for="identifier" class="mb-2 block text-sm font-semibold text-slate-700">ID</label>
                    <input id="identifier" name="identifier" type="text" autocomplete="username" required value="{{ old('identifier') }}" class="block w-full rounded-xl border border-slate-200 bg-slate-100/90 px-4 py-3.5 text-base text-slate-800 placeholder:text-slate-400 focus:border-sky-400 focus:outline-none focus:ring-4 focus:ring-sky-100" placeholder="Student ID">
                </div>

                <div class="relative">
                    <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">Password</label>
                    <input id="password" name="password" type="password" autocomplete="current-password" required class="block w-full rounded-xl border border-slate-200 bg-slate-100/90 px-4 py-3.5 pr-12 text-base text-slate-800 placeholder:text-slate-400 focus:border-sky-400 focus:outline-none focus:ring-4 focus:ring-sky-100" placeholder="••••••••">
                    <button type="button" id="togglePassword" class="absolute bottom-3.5 right-3 flex h-7 w-7 items-center justify-center rounded-full text-slate-500 transition hover:bg-slate-200 hover:text-slate-700 focus:outline-none" aria-label="Show password">
                        <svg id="eyeIcon" class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                            <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z" />
                            <circle cx="12" cy="12" r="3" />
                        </svg>
                    </button>
                </div>

                @if($errors->any())
                    <div class="text-sm font-medium text-red-600">
                        {{ $errors->first() }}
                    </div>
                @endif

                <div class="flex items-center">
                    <label for="remember" class="inline-flex cursor-pointer items-center gap-2 text-sm text-slate-700">
                        <input id="remember" name="remember" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-teal-600 focus:ring-teal-500" checked>
                        <span>Remember me</span>
                    </label>
                </div>

                <button type="submit" class="mt-3 w-full rounded-xl border border-sky-600 bg-sky-600 px-4 py-3 text-lg font-bold text-white shadow-[0_10px_25px_rgba(14,116,144,0.25)] transition hover:-translate-y-0.5 hover:bg-sky-700 focus:outline-none focus:ring-4 focus:ring-sky-100">
                    Login
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordInput = document.getElementById('password');
        const togglePasswordButton = document.getElementById('togglePassword');
        const eyeIcon = document.getElementById('eyeIcon');

        if (passwordInput && togglePasswordButton && eyeIcon) {
            togglePasswordButton.addEventListener('click', function () {
                const isPassword = passwordInput.type === 'password';
                passwordInput.type = isPassword ? 'text' : 'password';
                togglePasswordButton.setAttribute('aria-label', isPassword ? 'Hide password' : 'Show password');

                if (isPassword) {
                    eyeIcon.innerHTML = `
                        <path d="M3 3l18 18" />
                        <path d="M10.58 10.58A2 2 0 0 0 13.42 13.42" />
                        <path d="M9.88 5.08A10.94 10.94 0 0 1 12 5c6.5 0 10 7 10 7a18.12 18.12 0 0 1-4.18 5.11" />
                        <path d="M6.61 6.61A17.43 17.43 0 0 0 2 12s3.5 7 10 7a10.8 10.8 0 0 0 5.12-1.39" />
                    `;
                } else {
                    eyeIcon.innerHTML = `
                        <path d="M2 12s3.5-6 10-6 10 6 10 6-3.5 6-10 6S2 12 2 12Z" />
                        <circle cx="12" cy="12" r="3" />
                    `;
                }
            });
        }
    });
</script>

<style>
    .auth-page main {
        padding-top: 0 !important;
    }

    .auth-page-shell #tsparticles {
        position: absolute;
        inset: 0;
        width: 100%;
        height: 100%;
        z-index: 0;
        pointer-events: none;
    }

    .auth-page-shell #tsparticles canvas {
        display: block;
        width: 100% !important;
        height: 100% !important;
    }
</style>
@endsection

